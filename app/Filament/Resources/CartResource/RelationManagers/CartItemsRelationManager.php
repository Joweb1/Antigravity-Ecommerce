<?php

namespace App\Filament\Resources\CartResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables; // Updated or confirmed
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\CreateAction; // Added
use Filament\Tables\Actions\EditAction;   // Added
use Filament\Tables\Actions\DeleteAction; // Added
use Filament\Tables\Actions\BulkActionGroup; // Added
use Filament\Tables\Actions\DeleteBulkAction; // Added


class CartItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'cartItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name') // Display product name as title
            ->columns([
                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_price') // Added: display individual item price
                    ->getStateUsing(fn ($record) => $record->product->price / 100) // Access price from product
                    ->money()
                    ->label('Unit Price'),
                TextColumn::make('subtotal') // Added: display subtotal for the item
                    ->getStateUsing(fn ($record) => ($record->quantity * $record->product->price) / 100)
                    ->money()
                    ->label('Subtotal'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(), // Enabled
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Enabled
                Tables\Actions\DeleteAction::make(), // Enabled
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Enabled
                ]),
            ]);
    }
}