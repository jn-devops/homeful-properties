<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Homeful\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductsResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('sku'),
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\TextInput::make('brand'),
                        Forms\Components\TextInput::make('category'),
                        Forms\Components\TextInput::make('description'),
                        Forms\Components\TextInput::make('price'),
                        Forms\Components\TextInput::make('destinations'),
                        Forms\Components\TextInput::make('directions'),
                        Forms\Components\TextInput::make('amenities'),
                        Forms\Components\TextInput::make('facade_url'),
                        Forms\Components\TextInput::make('lot_area'),
                        Forms\Components\TextInput::make('floor_area'),
                        Forms\Components\TextInput::make('property_type'),
                        Forms\Components\TextInput::make('house_type'),
                        Forms\Components\TextInput::make('unit_type'),
                        Forms\Components\TextInput::make('appraised_value'),
                        Forms\Components\TextInput::make('percent_down_payment'),
                        Forms\Components\TextInput::make('down_payment_term'),
                        Forms\Components\TextInput::make('percent_miscellaneous_fees'),
                        Forms\Components\TextInput::make('interest_rate'),
                        Forms\Components\TextInput::make('percent_gross_monthly_income'),
                        Forms\Components\TextInput::make('max_age'),
                        Forms\Components\TextInput::make('mortgage_redemption_insurance_fee'),
                        Forms\Components\TextInput::make('income_requirement_multiplier'),
                        Forms\Components\TextInput::make('maximum_paying_age'),
                        Forms\Components\TextInput::make('key_location'),
                        Forms\Components\TextInput::make('digital_assets'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at','desc')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU'),
                TextColumn::make('project_code')
                    ->label('Project Code'),
                TextColumn::make('name')
                    ->label('Name'),
                TextColumn::make('brand')
                    ->label('Brand'),
                TextColumn::make('category')
                    ->label('Category'),
                TextColumn::make('description')
                    ->label('Description'),
                TextColumn::make('price')
                    ->label('Price'),
                TextColumn::make('processing_fee')
                    ->label('Processing Fee'),
                TextColumn::make('destinations')
                    ->label('Destinations'),
                TextColumn::make('directions')
                    ->label('Directions'),
                TextColumn::make('amenities')
                    ->label('Amenities'),
                TextColumn::make('facade_url')
                    ->label('Facade URL'),
                TextColumn::make('lot_area')
                    ->label('Lot Area'),
                TextColumn::make('floor_area')
                    ->label('Floor Area'),
                TextColumn::make('property_type')
                    ->label('Property Type'),
                TextColumn::make('house_type')
                    ->label('House Type'),
                TextColumn::make('unit_type')
                    ->label('Unit Type'),
                TextColumn::make('appraised_value')
                    ->label('Appraised Value'),
                TextColumn::make('percent_down_payment')
                    ->label('Percent Down Payment'),
                TextColumn::make('down_payment_term')
                    ->label('Down Payment Term'),
                TextColumn::make('balance_payment_term')
                    ->label('Balance Payment Term'),
                TextColumn::make('percent_miscellaneous_fees')
                    ->label('Percent Miscellaneous Fees'),
                TextColumn::make('balance_payment_interest_rate')
                    ->label('Interest Rate'),
                TextColumn::make('max_age')
                    ->label('Max Age'),
                TextColumn::make('percent_gross_monthly_income')
                    ->label('Percent GMI'),
                TextColumn::make('mortgage_redemption_insurance_fee')
                    ->label('MRIF'),
                TextColumn::make('income_requirement_multiplier')
                    ->label('Income Requirement Multiplier'),
                TextColumn::make('maximum_paying_age')
                    ->label('Maximum Paying Age'),
                TextColumn::make('key_location')
                    ->label('Key Location'),
                TextColumn::make('digital_assets')
                    ->label('Digital Assets'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data ,Product $record) {
                        $data['brand']=$record->brand;
                        //                        $data['market_segment']=$record->product->market_segment;
                        $data['price']=$record->price->getAmount()->toFloat();

                        $data['floor_area']=$record->meta->floor_area;
                        $data['lot_area']=$record->meta->lot_area;
                        $data['unit_type']=$record->meta->unit_type;
                        $data['facade_url']=$record->meta->facade_url;

                        $data['percent_dp']=$record->meta->percent_dp;
                        $data['percent_mf']=$record->meta->percent_mf;
                        $data['dp_term']=$record->meta->dp_term;

                        $data['destinations']=$record->destinations;
                        $data['amenities']=$record->amenities;
                        $data['key_location']=$record->key_location;
                        $data['digital_assets']=$record->digital_assets;
                        return $data;
                    })
                    ->using(function (Model $record, array $data): Model {
                        $record->update($data);
                        $record->brand = $data['brand'];

                        $record->price=$data['price'];
                        $record->category = $data['category'];
                        $record->floor_area = $data['floor_area'];
                        $record->lot_area = $data['lot_area'];
                        $record->unit_type = $data['unit_type'];
                        $record->facade_url = $data['facade_url'];

                        $record->meta->set('percent_dp',$data['percent_dp']);
                        $record->meta->set('percent_mf',$data['percent_mf']);
                        $record->meta->set('dp_term',$data['dp_term']);
                        $record->destinations = $data['destinations'];
                        $record->amenities = $data['amenities'];
                        $record->key_location = $data['key_location'];
                        $record->digital_assets = $data['digital_assets'];

                        $record->save();

                        return $record;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}

