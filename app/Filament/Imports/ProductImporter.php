<?php

namespace App\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Homeful\Products\Models\Product;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('sku'),
            ImportColumn::make('name'),
            ImportColumn::make('brand'),
            ImportColumn::make('category'),
            ImportColumn::make('description'),
            ImportColumn::make('price'),
            ImportColumn::make('destinations'),
            ImportColumn::make('directions'),
            ImportColumn::make('amenities'),
            ImportColumn::make('facade_url'),
            ImportColumn::make('lot_area'),
            ImportColumn::make('floor_area'),
            ImportColumn::make('unit_type'),
            ImportColumn::make('appraised_value'),
            ImportColumn::make('percent_dp'),
            ImportColumn::make('dp_term'),
            ImportColumn::make('percent_mf'),
            ImportColumn::make('key_location'),
            ImportColumn::make('digital_assets'),
        ];
    }

    public function resolveRecord(): ?Product
    {
        $facadeUrl = $this->data['facade_url'] ?? null;

        $product = Product::updateOrCreate(
            ['sku' => (string) ($this->data['sku'] ?? '')],
            [
                'name' => (string) ($this->data['name'] ?? ''),
                'brand' => (string) ($this->data['brand'] ?? ''),
                'category' => (string) ($this->data['category'] ?? ''),
                'description' => (string) ($this->data['description'] ?? ''),
                'price' => (float) ($this->data['price'] ?? 0),
                'directions' => (string) ($this->data['directions'] ?? ''),
                'amenities' => (string) ($this->data['amenities'] ?? ''),
                'facade_url' => (string) ($facadeUrl ?? ''),
                'destinations' => (string) ($this->data['destinations'] ?? ''),
            ]
        );

        $product->facade_url= $facadeUrl ?? '';
        $product->directions= $this->data['directions'] ?? '';
        $product->destinations= $this->data['destinations'] ?? '';
        $product->amenities= $this->data['amenities'] ?? '';

        $product->key_location= $this->data['key_location'] ?? '';
        $product->percent_down_payment=(float) ($this->data['percent_dp'] ?? 0);
        $product->down_payment_term=(float) ($this->data['dp_term'] ?? 0);
        $product->percent_miscellaneous_fees=(float) ($this->data['percent_mf'] ?? 0);
        $product->digital_assets=(string) ($this->data['digital_assets'] ?? '');
        $product->save();

        return $product;
    }

    protected function beforeSave(): void
    {
        $facadeUrl = $this->data['facade_url'] ?? null;
        $product = Product::updateOrCreate(
            ['sku' => (string) ($this->data['sku'] ?? '')],
            [
                'name' => (string) ($this->data['name'] ?? ''),
                'brand' => (string) ($this->data['brand'] ?? ''),
                'category' => (string) ($this->data['category'] ?? ''),
                'description' => (string) ($this->data['description'] ?? ''),
                'price' => (float) ($this->data['tcp'] ?? 0),
                'location' => (string) ($this->data['location'] ?? ''),
                'directions' => (string) ($this->data['directions'] ?? ''),
                'amenities' => (string) ($this->data['amenities'] ?? ''),
                'facade_url' => (string) ($facadeUrl ?? ''),
                'destinations' => (string) ($this->data['destinations'] ?? ''),
            ]
        );
        $product->facade_url= $facadeUrl ?? '';
        $product->status_code= $this->data['status_code'] ?? '';
        $product->destinations= $this->data['destinations'] ?? '';
        $product->amenities= $this->data['amenities'] ?? '';
        $product->key_location= $this->data['key_location'] ?? '';
        $product->percent_down_payment=(float) ($this->data['percent_dp'] ?? 0);
        $product->down_payment_term=(float) ($this->data['dp_term'] ?? 0);
        $product->percent_miscellaneous_fees=(float) ($this->data['percent_mf'] ?? 0);
        $product->digital_assets=(string) ($this->data['digital_assets'] ?? '');
        $product->save();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
