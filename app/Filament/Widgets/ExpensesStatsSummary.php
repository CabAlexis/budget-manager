<?php

namespace App\Filament\Widgets;

use App\Models\BudgetMonth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class ExpensesStatsSummary extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getCards(): array
    {
        $currentBudget = BudgetMonth::latest()->first();

        if (! $currentBudget) {
            return [
                Stat::make('Aucun budget trouvé', 'Créez votre premier budget'),
            ];
        }

        $totalSpent = $currentBudget->envelopes->sum(fn ($envelope) => $envelope->amount_spent);

        $currentDay = now()->day;
        $daysInMonth = now()->daysInMonth;

        $averagePerDay = $totalSpent / $currentDay;
        $estimatedTotal = $averagePerDay * $daysInMonth;

        $budgetExceeded = $estimatedTotal > $currentBudget->income_total;

        return [
            Stat::make('Moyenne / jour', number_format($averagePerDay, 2, ',', ' ') . ' €')
                ->description('Dépense moyenne journalière')
                ->descriptionColor('primary')
                ->extraAttributes(['class' => 'bg-primary-50']),

            Stat::make('Estimation fin de mois', new HtmlString(
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
