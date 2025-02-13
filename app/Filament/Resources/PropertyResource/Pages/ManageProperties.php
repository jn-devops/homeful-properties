<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Exports\PropertyExporter;
use App\Filament\Imports\PropertyImporter;
use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProperties extends ManageRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(PropertyImporter::class),
            Actions\ExportAction::make()
                ->exporter(PropertyExporter::class),
        ];
    }
}
