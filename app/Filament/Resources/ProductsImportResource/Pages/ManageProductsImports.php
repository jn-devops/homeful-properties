<?php

namespace App\Filament\Resources\ProductsImportResource\Pages;

use App\Filament\Resources\ProductsImportResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Imports\ProductsImportImporter;
class ManageProductsImports extends ManageRecords
{
    protected static string $resource = ProductsImportResource::class;
    protected static ?string $title = 'Products';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(ProductsImportImporter::class)
        ];
    }
}
