<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Homeful\Property\Enums\MarketSegment;
use Homeful\Property\Enums\HousingType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Homeful\Properties\Models\Project;

class ProjectsResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique('projects', 'name',ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->unique('projects', 'code',ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('location')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options(collect(MarketSegment::cases())->mapWithKeys(fn($cs) => [$cs->name => $cs->name])->toArray())
                    ->native(false),
                Forms\Components\Select::make('housingType')
                    ->required()
                    ->options(collect(HousingType::cases())->mapWithKeys(fn($cs) => [$cs->name => $cs->name])->toArray())
                    ->native(false),
                TextInput::make('licenseNumber')
                    ->required()
                    ->maxLength(255),
                TextInput::make('licenseDate')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('appraised_lot_value')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->formatStateUsing(fn ($record) => $record->meta->address)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->address', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->address', 'like', "%{$search}%");
                    }),
                TextColumn::make('type')
                    ->formatStateUsing(fn ($record) => $record->meta->type)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->type', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->type', 'like', "%{$search}%");
                    }),
                TextColumn::make('housingType')
                    ->formatStateUsing(fn ($record) => $record->meta->housingType)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->housingType', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->housingType', 'like', "%{$search}%");
                    }),
                TextColumn::make('licenseNumber')
                    ->formatStateUsing(fn ($record) => $record->meta->licenseNumber)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->licenseNumber', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->licenseNumber', 'like', "%{$search}%");
                    }),
                TextColumn::make('licenseDate')
                    ->formatStateUsing(fn ($record) => $record->meta->licenseDate)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->licenseDate', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->licenseDate', 'like', "%{$search}%");
                    }),
                TextColumn::make('company_code')
                    ->formatStateUsing(fn ($record) => $record->meta->company_code)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->company_code', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->company_code', 'like', "%{$search}%");
                    }),
                TextColumn::make('appraised_lot_value')
                    ->formatStateUsing(fn ($record) => $record->meta->appraised_lot_value)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->appraised_lot_value', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->appraised_lot_value', 'like', "%{$search}%");
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data,Model $record): array {
                        $data['address']=$record->meta->get('address');
                        $data['type']=$record->meta->get('type');
                        $data['housingType']=$record->meta->get('housingType');
                        $data['licenseNumber']=$record->meta->get('licenseNumber');
                        $data['licenseDate']=$record->meta->get('licenseDate');
                        $data['company_code']=$record->meta->get('company_code');
                        $data['appraised_lot_value']=$record->meta->get('appraised_lot_value');
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
        ];
    }
}
