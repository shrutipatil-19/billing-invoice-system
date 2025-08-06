<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices'; // Make sure Client model has invoices() relation

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice #')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('invoice_date')
                    ->date()
                    ->label('Date')
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->money('INR')
                    ->label('Subtotal'),

                TextColumn::make('tax_amount')
                    ->money('INR')
                    ->label('Tax'),

                TextColumn::make('grand_total')
                    ->money('INR')
                    ->label('Grand Total'),

                TextColumn::make('created_at')
                    ->since()
                    ->label('Created'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('invoice_date', 'desc');
    }
}
