<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
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
use Illuminate\Support\Carbon;

class ProjectsResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

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
                DatePicker::make('licenseDate')
                    ->required(),
                TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_tin')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pagibig_filing_site')
                    ->required()
                    ->maxLength(255),
                TextInput::make('filing_site')
                    ->required()
                    ->maxLength(255),
                TextInput::make('exec_position')
                    ->required()
                    ->maxLength(255),
                TextInput::make('exec_signatory')
                    ->required()
                    ->maxLength(255),
                TextInput::make('exec_tin')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('board_resolution_date')
                    ->required(),
                TextInput::make('appraised_lot_value')
                    ->numeric()
                    ->required(),
                TextInput::make('total_sold')
                    ->numeric()
                    ->required(),
                Textarea::make('project_description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(50)
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
                    ->getStateUsing(fn ($record) => $record->meta->licenseNumber)
                    // ->formatStateUsing(fn ($record) => $record->meta->licenseNumber)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->licenseNumber', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->licenseNumber', 'like', "%{$search}%");
                    }),
                TextColumn::make('licenseDate')
                    ->getStateUsing(fn ($record) =>Carbon::parse($record->meta->license_date)->format('Y-m-d') )
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->licenseDate', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->licenseDate', 'like', "%{$search}%");
                    }),
                TextColumn::make('company_name')
                    ->formatStateUsing(fn ($record) => $record->meta->company_name)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->company_name', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->company_name', 'like', "%{$search}%");
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
                TextColumn::make('company_tin')
                    ->formatStateUsing(fn ($record) => $record->meta->company_tin)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->company_tin', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->company_tin', 'like', "%{$search}%");
                    }),
                TextColumn::make('company_address')
                    ->formatStateUsing(fn ($record) => $record->meta->company_address)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->company_address', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->company_address', 'like', "%{$search}%");
                    }),
                TextColumn::make('pagibig_filing_site')
                    ->formatStateUsing(fn ($record) => $record->meta->pagibig_filing_site)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->pagibig_filing_site', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->pagibig_filing_site', 'like', "%{$search}%");
                    }),
                TextColumn::make('filing_site')
                    ->formatStateUsing(fn ($record) => $record->meta->filing_site)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->filing_site', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->filing_site', 'like', "%{$search}%");
                    }),
                TextColumn::make('exec_position')
                    ->formatStateUsing(fn ($record) => $record->meta->exec_position)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->exec_position', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->exec_position', 'like', "%{$search}%");
                    }),
                TextColumn::make('exec_signatory')
                    ->formatStateUsing(fn ($record) => $record->meta->exec_signatory)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->exec_signatory', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->exec_signatory', 'like', "%{$search}%");
                    }),
                TextColumn::make('exec_tin')
                    ->formatStateUsing(fn ($record) => $record->meta->exec_tin)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->exec_tin', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->exec_tin', 'like', "%{$search}%");
                    }),
                TextColumn::make('board_resolution_date')
                    ->getStateUsing(fn ($record) =>Carbon::parse($record->board_resolution_date)->format('Y-m-d') )
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('meta->board_resolution_date', $direction);
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->board_resolution_date', 'like', "%{$search}%");
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
                TextColumn::make('total_sold')
                    ->formatStateUsing(fn ($record) => $record->meta->total_sold),
                TextColumn::make('project_description')
                    ->formatStateUsing(fn ($record) => $record->meta->project_description)
                    ->words(15),
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
                        $data['company_name']=$record->meta->get('company_name');
                        $data['company_code']=$record->meta->get('company_code');
                        $data['company_tin']=$record->meta->get('company_tin');
                        $data['company_address']=$record->meta->get('company_address');
                        $data['pagibig_filing_site']=$record->meta->get('pagibig_filing_site');
                        $data['filing_site']=$record->meta->get('filing_site');
                        $data['exec_position']=$record->meta->get('exec_position');
                        $data['exec_signatory']=$record->meta->get('exec_signatory');
                        $data['exec_tin']=$record->meta->get('exec_tin');
                        $data['board_resolution_date']=$record->meta->get('board_resolution_date');
                        $data['appraised_lot_value']=$record->meta->get('appraised_lot_value');
                        $data['total_sold']=$record->meta->get('total_sold');
                        $data['project_description']=$record->meta->get('project_description');
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
