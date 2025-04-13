<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ParticipantsSummary extends BaseWidget
{
    protected static ?string $heading = 'Participants & Revenu Global';

    public function table(Table $table): Table
    {
        return $table
            ->query(Participant::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Nom'),
                TextColumn::make('income')
                    ->label('Revenu')
                    ->money('EUR'),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('income')
                            ->numeric()
                            ->required(),
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('income')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ]),
            ])
            ->paginated(false);
    }

    public function getHeading(): string
    {
        $totalIncome = Participant::sum('income');

        return 'Participants — Revenu Global : ' . number_format($totalIncome, 2, ',', ' ') . ' €';
    }
}
