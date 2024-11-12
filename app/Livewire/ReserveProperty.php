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
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_location')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->project_location', 'like', "%{$search}%");
                    }),
                Tables\Columns\TextColumn::make('project_code'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Property Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('meta->name', 'like', "%{$search}%");
                    }),
                Tables\Columns\TextColumn::make('phase'),
                Tables\Columns\TextColumn::make('block'),
                Tables\Columns\TextColumn::make('lot'),
                Tables\Columns\TextColumn::make('lot_area'),
                Tables\Columns\TextColumn::make('floor_area'),
                Tables\Columns\TextColumn::make('project_address'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Property Type'),
                Tables\Columns\TextColumn::make('unit_type'),
                Tables\Columns\TextColumn::make('unit_type_interior'),
                Tables\Columns\TextColumn::make('house_color'),
                Tables\Columns\TextColumn::make('building'),
                Tables\Columns\TextColumn::make('consultation_fee')
                    ->label('Processing Fee')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.brand')
                    ->label('Brand'),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.price')
                    ->label('Price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.market_segment')
                    ->label('Market Segment'),
                Tables\Columns\TextColumn::make('category')
                    ->getStateUsing(function ($record) {
                        return "{$record->product->market_segment} {$record->product->brand}";
                    }),
                Tables\Columns\TextColumn::make('appraised_value')
                    ->numeric()
                    ->sortable(),
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
