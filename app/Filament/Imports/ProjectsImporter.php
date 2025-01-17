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
                ->guess(['code','project_code'])
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->guess(['name','project_name'])
                ->rules(['max:255']),
            ImportColumn::make('location')
                ->guess(['location','project_location'])
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->guess(['address','project_address'])
                ->rules(['max:255']),
            ImportColumn::make('type')
                ->guess(['type','project_type'])
                ->label('Market Segment')
                ->rules(['max:255']),
            ImportColumn::make('housingType')
                ->guess(['housing_type'])
                ->rules(['max:255']),
            ImportColumn::make('licenseNumber')
                ->guess(['license_number','project_license_number'])
                ->rules(['max:255']),
            ImportColumn::make('licenseDate')
                ->guess(['license_date','project_license_date'])
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
                'name' => $this->data['project_name'],
                'code'=>$this->data['project_code'],
            ],[
            'location'=>$this->data['project_location'],
        ]);
        $project->meta->set('address', $this->data['project_address']);
        $project->meta->set('type', $this->data['project_type']);
        $project->meta->set('housingType', $this->data['housing_type']);
        $project->meta->set('licenseNumber', $this->data['housing_type']);
        $project->meta->set('licenseDate', $this->data['license_date']);
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
