<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BudgetMonthResource\Pages;
use App\Filament\Resources\BudgetMonthResource\RelationManagers\EnvelopesRelationManager;
use App\Models\BudgetMonth;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BudgetMonthResource extends Resource
{
    protected static ?string $model = BudgetMonth::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('month')
                            ->label('Mois')
                            ->required()
                            ->options([
                                1 => 'Janvier',
                                2 => 'Février',
                                3 => 'Mars',
                                4 => 'Avril',
                                5 => 'Mai',
                                6 => 'Juin',
                                7 => 'Juillet',
                                8 => 'Août',
                                9 => 'Septembre',
                                10 => 'Octobre',
                                11 => 'Novembre',
                                12 => 'Décembre',
                            ]),
                        TextInput::make('year')
                            ->label('Année')
                            ->numeric()
                            ->required(),
                        TextInput::make('income_total')
                            ->label('Revenus totaux')
                            ->numeric()
                            ->default(0),
                        TextInput::make('saving_goal')
                            ->label('Objectif épargne')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')->label('Mois'),
                TextColumn::make('year')->label('Année'),
                TextColumn::make('income_total')->label('Revenus')->money('EUR'),
                TextColumn::make('saving_goal')->label('Objectif épargne')->money('EUR'),
                TextColumn::make('created_at')->label('Créé le')->dateTime(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            EnvelopesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBudgetMonths::route('/'),
            'create' => Pages\CreateBudgetMonth::route('/create'),
            'edit' => Pages\EditBudgetMonth::route('/{record}/edit'),
        ];
    }
}
