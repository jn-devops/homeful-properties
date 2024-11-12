<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsImportResource\Pages;
use App\Filament\Resources\ProductsImportResource\RelationManagers;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Homeful\Products\Models\Product;
use Homeful\Properties\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsImportResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Properties';
    protected static ?string $label = 'Properties';

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
                Forms\Components\TextInput::make('name')
                    ->label('Property Name')
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
                Forms\Components\TextInput::make('type')
                    ->label('Property Type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_type_interior')
                    ->maxLength(255),
                Forms\Components\TextInput::make('house_color')
                    ->maxLength(255),
                Forms\Components\TextInput::make('building')
                    ->maxLength(255),
                Forms\Components\TextInput::make('consultation_fee')
                    ->label('Processing Fee')
                    ->numeric(),
                Forms\Components\TextInput::make('brand')
                    ->label('Brand')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('Php'),
                Forms\Components\TextInput::make('market_segment')
                    ->label('Market Segment')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Property Name')
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Property Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_type_interior')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('building')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consultation_fee')
                    ->label('Processing Fee')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.brand')
                    ->label('Brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.price')
                    ->label('Price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.market_segment')
                    ->label('Market Segment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->getStateUsing(function ($record) {
                        return "{$record->product->market_segment} {$record->product->brand}";
                    })
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
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data, Model $record): array {
                        $data['brand']=$record->product->brand;
                        $data['market_segment']=$record->product->market_segment;
                        $data['price']=$record->product->price->getAmount()->toFloat();
                        $data['category']=$record->product->market_segment.' '.$record->product->brand;
                        return $data;
                    }),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('update_status')
                    ->label('Update Status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->native(false)
                            ->options(
                                Status::pluck('description','code')
                            )
                            ->searchable()
                            ->required()
                    ])
                    ->action(function ($record, array $data){
                        $record->update([
                            'status'=>$data['status']
                        ]);
                        $record->save();
                    })
                    ->modalWidth(MaxWidth::Small)
            ],Tables\Enums\ActionsPosition::BeforeCells)
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
