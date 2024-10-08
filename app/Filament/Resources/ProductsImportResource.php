<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsImportResource\Pages;
use App\Filament\Resources\ProductsImportResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Homeful\Products\Models\Product;
use Homeful\Properties\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsImportResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('project_location')
                    ->maxLength(255),
                Forms\Components\TextInput::make('project_code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('property_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phase')
                    ->maxLength(255),
                Forms\Components\TextInput::make('block')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lot')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lot_area')
                    ->maxLength(255),
                Forms\Components\TextInput::make('floor_area')
                    ->maxLength(255),
                Forms\Components\TextInput::make('project_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('property_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_type_interior')
                    ->maxLength(255),
                Forms\Components\TextInput::make('house_color')
                    ->maxLength(255),
                Forms\Components\TextInput::make('building')
                    ->maxLength(255),
                Forms\Components\TextInput::make('processing_fee')
                    ->numeric(),
                Forms\Components\TextInput::make('brand')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('market_segment')
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('product_location_details')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('lifestyle_destinations')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('amenities')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('how_to_get_there')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('appraised_value')
                    ->numeric()
                    ->prefix('$'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phase')
                    ->searchable(),
                Tables\Columns\TextColumn::make('block')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lot')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lot_area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('floor_area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_type_interior')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('building')
                    ->searchable(),
                Tables\Columns\TextColumn::make('processing_fee')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('market_segment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
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
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ManageProductsImports::route('/'),
        ];
    }
}
