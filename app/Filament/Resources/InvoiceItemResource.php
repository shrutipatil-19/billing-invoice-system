<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceItemResource\Pages;
use App\Filament\Resources\InvoiceItemResource\RelationManagers;
use App\Models\InvoiceItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select};
use Filament\Tables\Columns\TextColumn;

class InvoiceItemResource extends Resource
{
    protected static ?string $model = InvoiceItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('invoice_id')
                    ->label('Invoice')
                    ->relationship('invoice', 'invoice_number')
                    ->required(),

                TextInput::make('description')
                    ->label('Item Description')
                    ->required()
                    ->maxLength(255),

                TextInput::make('quantity')
                    ->numeric()
                    ->required(),

                TextInput::make('unit_price')
                    ->numeric()
                    ->label('Unit Price')
                    ->prefix('₹')
                    ->required(),

                TextInput::make('tax')
                    ->numeric()
                    ->label('Tax')
                    ->prefix('₹')
                    ->required(),

                TextInput::make('total')
                    ->numeric()
                    ->prefix('₹')
                    ->required()
                    ->hint('Calculated: quantity × unit price + tax'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.invoice_number')
                    ->label('Invoice #')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('quantity')
                    ->sortable(),

                TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->money('INR'),

                TextColumn::make('tax')
                    ->money('INR'),

                TextColumn::make('total')
                    ->money('INR'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInvoiceItems::route('/'),
            'create' => Pages\CreateInvoiceItem::route('/create'),
            'edit' => Pages\EditInvoiceItem::route('/{record}/edit'),
        ];
    }
}
