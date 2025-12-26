<?php

namespace App\Filament\Resources\CartResource\RelationManagers;

use Filament\Forms; // Added
use Filament\Forms\Form; // Added
use Filament\Resources\RelationManagers\RelationManager; // Added
use Filament\Tables\Table; // Added
use Filament\Tables\Columns\TextColumn;

class CartItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'cartItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // No form fields as this is a read-only view of cart items
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // No header actions for read-only
            ])
            ->actions([
                // No actions for read-only
            ])
            ->bulkActions([
                // No bulk actions for read-only
            ]);
    }
}