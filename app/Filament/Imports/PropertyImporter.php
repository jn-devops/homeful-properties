<?php

namespace App\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Homeful\Properties\Models\Property;

class PropertyImporter extends Importer
{
    protected static ?string $model = Property::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code'),
            ImportColumn::make('name'),
            ImportColumn::make('type'),
            ImportColumn::make('cluster'),
            ImportColumn::make('phase'),
            ImportColumn::make('block'),
            ImportColumn::make('lot'),
            ImportColumn::make('building'),
            ImportColumn::make('floor_area'),
            ImportColumn::make('lot_area'),
            ImportColumn::make('unit_type'),
            ImportColumn::make('unit_type_interior'),
            ImportColumn::make('house_color'),
            ImportColumn::make('roof_style'),
            ImportColumn::make('end_unit'),
            ImportColumn::make('veranda'),
            ImportColumn::make('balcony'),
            ImportColumn::make('firewall'),
            ImportColumn::make('eaves'),
            ImportColumn::make('bedrooms'),
            ImportColumn::make('toilets_and_bathrooms'),
            ImportColumn::make('parking_slots'),
            ImportColumn::make('carports'),
            ImportColumn::make('project_code'),
            ImportColumn::make('sku'),
            ImportColumn::make('tcp'),
        ];
    }

    public function resolveRecord(): ?Property
    {
        // Create or update the Property record based on SKU
        $property = Property::updateOrCreate(
            ['code' => (string) ($this->data['code'] ?? '')],
            [
                'name' => (string) ($this->data['name'] ?? ''),
                'type' => (string) ($this->data['type'] ?? ''),
                'cluster' => (string) ($this->data['cluster'] ?? 0),

                'tcp' => (float) ($this->data['tcp'] ?? 0),
                'sku' => (string) ($this->data['sku'] ?? ''),
            ]
        );

        $property->phase=(string) ($this->data['phase'] ?? '');
        $property->block=(string) ($this->data['block'] ?? '');
        $property->lot=(string) ($this->data['lot'] ?? '');
        $property->building=(string) ($this->data['building'] ?? '');
        $property->floor_area=(string) ($this->data['floor_area'] ?? '');
        $property->lot_area=(string) ($this->data['lot_area'] ?? '');
        $property->unit_type=(string) ($this->data['unit_type'] ?? '');
        $property->unit_type_interior=(string) ($this->data['unit_type_interior'] ?? '');
        $property->house_color=(string) ($this->data['string'] ?? '');
        $property->roof_style=(string) ($this->data['roof_style'] ?? '');

        $property->end_unit=(bool) ($this->data['end_unit'] ?? false);
        $property->veranda=(bool) ($this->data['veranda'] ?? false);
        $property->balcony=(bool) ($this->data['balcony'] ?? false);
        $property->firewall=(bool) ($this->data['firewall'] ?? false);
        $property->eaves=(bool) ($this->data['eaves'] ?? false);

        $property->bedrooms=(int) ($this->data['bedrooms'] ?? 0);
        $property->toilets_and_bathrooms=(int) ($this->data['toilets_and_bathrooms'] ?? 0);
        $property->parking_slots=(int) ($this->data['parking_slots'] ?? 0);
        $property->carports=(int) ($this->data['carports'] ?? 0);

        $property->project_code=(string) ($this->data['project_code'] ?? '');


        $property->save();
        return $property;
    }

    protected function beforeSave(): void
    {
        // Create or update the Property record based on SKU
        $property = Property::updateOrCreate(
            ['code' => (string) ($this->data['code'] ?? '')],
            [
                'name' => (string) ($this->data['name'] ?? ''),
                'type' => (string) ($this->data['type'] ?? ''),
                'cluster' => (string) ($this->data['cluster'] ?? 0),

                'tcp' => (float) ($this->data['tcp'] ?? 0),
                'sku' => (string) ($this->data['sku'] ?? ''),
            ]
        );

        $property->phase=(string) ($this->data['phase'] ?? '');
        $property->block=(string) ($this->data['block'] ?? '');
        $property->lot=(string) ($this->data['lot'] ?? '');
        $property->building=(string) ($this->data['building'] ?? '');
        $property->floor_area=(string) ($this->data['floor_area'] ?? '');
        $property->lot_area=(string) ($this->data['lot_area'] ?? '');
        $property->unit_type=(string) ($this->data['unit_type'] ?? '');
        $property->unit_type_interior=(string) ($this->data['unit_type_interior'] ?? '');
        $property->house_color=(string) ($this->data['string'] ?? '');
        $property->roof_style=(string) ($this->data['roof_style'] ?? '');

        $property->end_unit=(bool) ($this->data['end_unit'] ?? false);
        $property->veranda=(bool) ($this->data['veranda'] ?? false);
        $property->balcony=(bool) ($this->data['balcony'] ?? false);
        $property->firewall=(bool) ($this->data['firewall'] ?? false);
        $property->eaves=(bool) ($this->data['eaves'] ?? false);

        $property->bedrooms=(int) ($this->data['bedrooms'] ?? 0);
        $property->toilets_and_bathrooms=(int) ($this->data['toilets_and_bathrooms'] ?? 0);
        $property->parking_slots=(int) ($this->data['parking_slots'] ?? 0);
        $property->carports=(int) ($this->data['carports'] ?? 0);

        $property->project_code=(string) ($this->data['project_code'] ?? '');


        $property->save();
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
