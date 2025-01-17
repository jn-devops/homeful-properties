<?php

namespace App\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Homeful\Properties\Models\Project;
class ProjectsImporter extends Importer
{
    protected static ?string $model = Project::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code')
                ->guess(['code'])
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->guess(['name'])
                ->rules(['max:255']),
            ImportColumn::make('location')
                ->guess(['location'])
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->rules(['max:255']),
            ImportColumn::make('type')
                ->label('Market Segment')
                ->rules(['max:255']),
            ImportColumn::make('housingType')
                ->rules(['max:255']),
            ImportColumn::make('licenseNumber')
                ->rules(['max:255']),
            ImportColumn::make('licenseDate')
                ->rules(['max:255']),
            ImportColumn::make('company_code')
                ->rules(['max:255']),
            ImportColumn::make('appraised_lot_value')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Project
    {
        $project = Project::firstOrCreate(
            [
                'name' => $this->data['name'],
                'code'=>$this->data['code'],
            ],[
            'location'=>$this->data['location'],
        ]);
        $project->meta->set('address', $this->data['address']);
        $project->meta->set('type', $this->data['type']);
        $project->meta->set('housingType', $this->data['housingType']);
        $project->meta->set('licenseNumber', $this->data['licenseNumber']);
        $project->meta->set('licenseDate', $this->data['licenseDate']);
        $project->meta->set('company_code', $this->data['company_code']);
        $project->meta->set('appraised_lot_value', $this->data['appraised_lot_value']);
        $project->meta->set('appraised__lot_value', $this->data['appraised_lot_value']);
        $project->save();

        return $project;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your projects import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
