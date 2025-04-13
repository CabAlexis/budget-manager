<?php

namespace App\Filament\Widgets;

use App\Models\BudgetMonth;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\HtmlString;

class ExpensesStatsSummary extends BaseWidget
{
    protected function getCards(): array
    {
        $currentBudget = BudgetMonth::latest()->first();

        if (! $currentBudget) {
            return [
                Card::make('Aucun budget trouvé', 'Créez votre premier budget'),
            ];
        }

        $totalSpent = $currentBudget->envelopes->sum(fn ($envelope) => $envelope->amount_spent);

        $currentDay = now()->day;
        $daysInMonth = now()->daysInMonth;

        $averagePerDay = $totalSpent / $currentDay;
        $estimatedTotal = $averagePerDay * $daysInMonth;

        $budgetExceeded = $estimatedTotal > $currentBudget->income_total;

        return [
            Card::make('Moyenne / jour', number_format($averagePerDay, 2, ',', ' ') . ' €')
                ->description('Dépense moyenne journalière')
                ->descriptionColor('primary')
                ->extraAttributes(['class' => 'bg-primary-50']),

            Card::make('Estimation fin de mois', new HtmlString(
                '<span class="' . ($budgetExceeded ? 'text-danger-600' : 'text-success-600') . '">' .
                number_format($estimatedTotal, 2, ',', ' ') . ' €' .
                '</span>'
            ))
                ->description($budgetExceeded ? 'Attention risque de dépassement' : 'Budget maîtrisé')
                ->descriptionColor($budgetExceeded ? 'danger' : 'success')
                ->extraAttributes([
                    'class' => $budgetExceeded ? 'bg-danger-50' : 'bg-success-50',
                ]),
        ];
    }
}
