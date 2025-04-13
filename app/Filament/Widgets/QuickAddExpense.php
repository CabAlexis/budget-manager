<?php

namespace App\Filament\Widgets;

use App\Filament\Actions\NowAction;
use App\Models\Envelope;
use App\Models\Expense;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets\Widget;

class QuickAddExpense extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static ?string $heading = 'Ajouter une dépense rapide';

    protected static string $view = 'filament.widgets.quick-add-expense';

    protected static ?int $sort = 0;

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('envelope_id')
                ->label('Enveloppe')
                ->options(Envelope::all()->pluck('name', 'id'))
                ->required(),
            TextInput::make('name')
                ->label('Nom')
                ->required(),
            TextInput::make('amount')
                ->label('Montant (€)')
                ->numeric()
                ->required(),
            DatePicker::make('date')
                ->label('Date')
                ->default(now()->format('yyyy-mm-dd'))
                ->required()
                ->live(),
            Checkbox::make('is_recurring')
                ->label('Dépense récurrente ?'),
        ];
    }

    public function submit(): void
    {
        Expense::create($this->form->getState());

        $this->form->fill();

        Notification::make()
            ->title('Dépense ajoutée avec succès')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Forms\Components\Actions\Action::make('Créer')
                ->action('create')
                ->button()
                ->color('primary')
                ->label('Ajouter'),
        ];
    }

    protected function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Medium;
    }
}
