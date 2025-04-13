<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnvelopeResource\Pages;
use App\Models\Envelope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EnvelopeResource extends Resource
{
    protected static ?string $model = Envelope::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('budget_month_id')
                    ->label('Budget du mois')
                    ->relationship('budgetMonth', 'month')
                    ->required(),
                TextInput::make('name')
                    ->label('Nom de l\'enveloppe')
                    ->required()
                    ->maxLength(255),
                TextInput::make('amount_allocated')
                    ->label('Montant alloué')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom'),
                TextColumn::make('amount_allocated')->label('Budget')->money('EUR'),
                TextColumn::make('amount_spent')->label('Dépensé')->money('EUR'),
                TextColumn::make('budgetMonth.year')->label('Année'),
                TextColumn::make('budgetMonth.month')->label('Mois'),
            ])
            ->defaultSort('id', 'desc')
            ->filters([])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnvelopes::route('/'),
            'create' => Pages\CreateEnvelope::route('/create'),
            'edit' => Pages\EditEnvelope::route('/{record}/edit'),
        ];
    }
}
