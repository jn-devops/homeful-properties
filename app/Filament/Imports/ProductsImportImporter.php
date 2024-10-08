<?php

namespace App\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Homeful\Products\Models\Product;
use Homeful\Properties\Models\Property;

class ProductsImportImporter extends Importer
{
    protected static ?string $model = Property::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('type')
                ->rules(['max:255']),
            ImportColumn::make('cluster')
                ->rules(['max:255']),
            ImportColumn::make('sku')
                ->label('SKU')
                ->rules(['max:255']),
            ImportColumn::make('phase')
                ->rules(['max:255']),
            ImportColumn::make('block')
                ->rules(['max:255']),
            ImportColumn::make('lot')
                ->rules(['max:255']),
            ImportColumn::make('floor_area')
                ->numeric(),
            ImportColumn::make('lot_area')
                ->numeric(),
            ImportColumn::make('building')
                ->rules(['max:255']),
            ImportColumn::make('unit_type')
                ->rules(['max:255']),
            ImportColumn::make('project_code')
                ->rules(['max:255']),
            ImportColumn::make('project_location')
                ->rules(['max:255']),
            ImportColumn::make('project_address'),
        ];
    }

    public function resolveRecord(): ?Property
    {
        $facadeUrl = $this->data['facade_url'] ?? null;

        if ($facadeUrl) {
            // Decode the JSON string into an associative array
            $facadeData = json_decode($facadeUrl, true);

            // Check if the 'facade' key exists and get its value
            $facade = $facadeData['facade'] ?? null;
        }

        // Create or update the Product record based on SKU
        $product = Product::updateOrCreate(
            ['sku' => (string) ($this->data['sku'] ?? '')],
            [
                'name' => (string) ($this->data['name'] ?? ''),
                'brand' => (string) ($this->data['brand'] ?? ''),
                'category' => (string) ($this->data['category'] ?? ''),
                'description' => (string) ($this->data['description'] ?? ''),
                'price' => (float) ($this->data['price'] ?? 0),
                'market_segment' => (string) ($this->data['market_segment'] ?? ''),
                'location' => (string) ($this->data['location'] ?? ''),
                'directions' => (string) ($this->data['directions'] ?? ''),
                'amenities' => (string) ($this->data['amenities'] ?? ''),
                'facade_url' => (string) ($facade ?? ''),
                'destinations' => (string) ($this->data['destinations'] ?? ''),
            ]
        );

        // Create or update the Property record based on SKU
        $property = Property::updateOrCreate(
            ['sku' => (string) ($this->data['sku'] ?? '')],
            [
                'code' => (string) ($this->data['code'] ?? ''),
                'name' => (string) ($this->data['name'] ?? ''),
                'type' => (string) ($this->data['type'] ?? ''),
                'cluster' => (string) ($this->data['cluster'] ?? 0),
                'phase' => (string) ($this->data['phase'] ?? ''),
                'block' => (string) ($this->data['block'] ?? ''),
                'lot' => (string) ($this->data['lot'] ?? ''),
                'floor_area' => (float) ($this->data['floor_area'] ?? 0),
                'lot_area' => (float) ($this->data['lot_area'] ?? 0),
                'building' => (string) ($this->data['building'] ?? ''),
                'unit_type' => (string) ($this->data['unit_type'] ?? ''),
                'project_code' => (string) ($this->data['project_code'] ?? ''),
                'project_location' => (string) ($this->data['project_location'] ?? ''),
                'project_address' => (string) ($this->data['project_address'] ?? ''),
            ]
        );

        // Associate the Property with the Product
        $property->product()->associate($product);
        $property->save();

        return $property;
    }


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your property import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
