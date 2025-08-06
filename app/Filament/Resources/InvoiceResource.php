<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Select, TextInput, DatePicker};
use Filament\Tables\Columns\TextColumn;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'name')
                    ->required(),

                TextInput::make('invoice_number')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                DatePicker::make('invoice_date')
                    ->required(),

                TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('₹')
                    ->required(),

                TextInput::make('tax_amount')
                    ->numeric()
                    ->prefix('₹')
                    ->required(),

                TextInput::make('grand_total')
                    ->numeric()
                    ->prefix('₹')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('INR'),

                TextColumn::make('tax_amount')
                    ->label('Tax')
                    ->money('INR'),

                TextColumn::make('grand_total')
                    ->label('Grand Total')
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
