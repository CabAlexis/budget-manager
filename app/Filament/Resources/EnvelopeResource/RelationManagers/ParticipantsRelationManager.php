<?php

namespace App\Filament\Resources\EnvelopeResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('ratio')
                ->label('Ratio %')
                ->numeric()
                ->minValue(1)
                ->maxValue(100)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Participant'),
                TextColumn::make('pivot.ratio')->label('Ratio %'),
            ]);
    }
}
