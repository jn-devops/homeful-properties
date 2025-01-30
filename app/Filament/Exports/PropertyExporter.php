<?php

namespace App\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Homeful\Properties\Models\Property;

class PropertyExporter extends Exporter
{
    protected static ?string $model = Property::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code'),
            ExportColumn::make('project_location')
                ->state(function (Property $record) {
                    return $record->meta->get('project_location');
                }),
            ExportColumn::make('project_code')
                ->state(function (Property $record) {
                    return $record->meta->get('project_code');
                }),
            ExportColumn::make('property_name')
                ->state(function (Property $record) {
                    return $record->name;
                }),
            ExportColumn::make('cluster')
                ->state(function (Property $record) {
                    return $record->cluster;
                }),
            ExportColumn::make('phase')
                ->state(function (Property $record) {
                    return $record->meta->get('phase');
                }),
            ExportColumn::make('block')
                ->state(function (Property $record) {
                    return $record->meta->get('block');
                }),
            ExportColumn::make('lot')
                ->state(function (Property $record) {
                    return $record->meta->get('lot');
                }),
            ExportColumn::make('lot_area')
                ->state(function (Property $record) {
                    return $record->meta->get('lot_area');
                }),
            ExportColumn::make('floor_area')
                ->state(function (Property $record) {
                    return $record->meta->get('floor_area');
                }),
            ExportColumn::make('bedrooms')
                ->state(function (Property $record) {
                    return $record->bedrooms;
                }),
            ExportColumn::make('toilets_and_bathrooms')
                ->state(function (Property $record) {
                    return $record->meta->get('toilets_and_bathrooms');
                }),
            ExportColumn::make('parking_slots')
                ->state(function (Property $record) {
                    return $record->meta->get('parking_slots');
                }),
            ExportColumn::make('carports')
                ->state(function (Property $record) {
                    return $record->meta->get('carports');
                }),
            ExportColumn::make('project_address')
                ->state(function (Property $record) {
                    return $record->meta->get('project_address');
                }),
            ExportColumn::make('property_type')
                ->state(function (Property $record) {
                    return $record->type;
                }),
            ExportColumn::make('unit_type')
                ->state(function (Property $record) {
                    return $record->meta->get('unit_type');
                }),
            ExportColumn::make('unit_type_interior')
                ->state(function (Property $record) {
                    return $record->meta->get('unit_type_interior');
                }),
            ExportColumn::make('brand')
                ->state(function (Property $record) {
                    return $record->product->brand;
                }),
            ExportColumn::make('category')
                ->state(function (Property $record) {
                    return $record->product->category;
                }),
            ExportColumn::make('sku')
                ->state(function (Property $record) {
                    return $record->sku;
                }),
            ExportColumn::make('price')
                ->state(function (Property $record) {
                    return $record->price;
                }),
            ExportColumn::make('tcp')
                ->state(function (Property $record) {
                    return $record->tcp;
                }),
            ExportColumn::make('appraised_value')
                ->state(function (Property $record) {
                    return $record->appraised_value;
                }),
            ExportColumn::make('facade_url')
                ->state(function (Property $record) {
                    return $record->product->facade_url;
                }),
            ExportColumn::make('percent_dp')
                ->state(function (Property $record) {
                    return $record->product->meta->get('percent_dp');
                }),
            ExportColumn::make('dp_term')
                ->state(function (Property $record) {
                    return $record->product->meta->get('dp_term');
                }),
            ExportColumn::make('percent_mf')
                ->state(function (Property $record) {
                    return $record->product->meta->get('percent_mf');
                }),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your property export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
