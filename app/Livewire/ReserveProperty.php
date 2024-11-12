<?php

namespace App\Livewire;

use Homeful\Properties\Models\Property;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ReserveProperty extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->query(Property::query())
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('project_location')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->project_location', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('project_code')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->project_code', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Property Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->name', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('phase')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->phase', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('block')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->block', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('lot')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->lot', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('lot_area')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->lot_area', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('floor_area')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->floor_area', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('project_address')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->project_address', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('type')
                    ->label('Property Type')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->type', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('unit_type')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->unit_type', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('unit_type_interior')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->unit_type_interior', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('house_color')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->house_color', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('building')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->building', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('consultation_fee')
                    ->label('Processing Fee')
                    ->numeric()
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->consultation_fee', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('product.brand')
                    ->label('Brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('product.price')
                    ->label('Price')
                    ->money()
                    ->sortable()
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('product.market_segment')
                    ->label('Market Segment'),
                Tables\Columns\TextColumn::make('category')
                    ->getStateUsing(function ($record) {
                        return "{$record->product->market_segment} {$record->product->brand}";
                    }),
                Tables\Columns\TextColumn::make('appraised_value')
                    ->numeric()
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->appraised_value', 'like', "%{$search}%");
                    },isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.reserve-property');
    }
}
