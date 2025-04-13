<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-euro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('envelope_id')
                    ->label('Enveloppe')
                    ->relationship('envelope', 'name')
                    ->required(),

                TextInput::make('name')
                    ->label('Nom de la dépense')
                    ->required()
                    ->maxLength(255),

                TextInput::make('amount')
                    ->label('Montant')
                    ->numeric()
                    ->required(),

                DatePicker::make('date')
                    ->label('Date')
                    ->required(),

                Textarea::make('note')
                    ->label('Note')
                    ->maxLength(1000),

                Toggle::make('is_recurring')
                    ->label('Dépense récurrente'),

                Select::make('recurrence_type')
                    ->label('Type de récurrence')
                    ->options([
                        'daily' => 'Quotidien',
                        'weekly' => 'Hebdomadaire',
                        'monthly' => 'Mensuel',
                    ])
                    ->visible(fn ($get) => $get('is_recurring'))
                    ->requiredIf('is_recurring', true),

                DatePicker::make('recurrence_end_date')
                    ->label('Date de fin de récurrence')
                    ->visible(fn ($get) => $get('is_recurring')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom'),
                TextColumn::make('amount')->label('Montant')->money('EUR'),
                TextColumn::make('date')->label('Date')->date(),
                TextColumn::make('envelope.name')->label('Enveloppe'),
            ])
            ->defaultSort('date', 'desc')
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
