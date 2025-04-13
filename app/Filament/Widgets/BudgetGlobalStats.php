<?php

namespace App\Filament\Widgets;

use App\Models\BudgetMonth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BudgetGlobalStats extends BaseWidget
{
    protected static ?string $pollingInterval = '2s';

    protected function getStats(): array
    {
        $budgetMonth = BudgetMonth::getCurrent();

        $totalIncome = $budgetMonth->income_total;
        $totalSpent = $budgetMonth->envelopes->flatMap->expenses->sum('amount');
        $totalRemaining = $totalIncome - $totalSpent;

        $stats = [
            Stat::make('Solde restant', number_format($totalRemaining, 2, ',', ' ') . ' €')
                ->description('Revenus totaux : ' . number_format($totalIncome, 2, ',', ' ') . ' €')
                ->color($totalRemaining < 0 ? 'danger' : 'success'),
        ];

        foreach ($budgetMonth->envelopes as $envelope) {
            $spent = $envelope->expenses()->sum('amount');
            $remaining = $envelope->amount_allocated - $spent;

            $stats[] = Stat::make($envelope->name, number_format($remaining, 2, ',', ' ') . ' €')
                ->description('Total : ' . number_format($envelope->amount_allocated, 2, ',', ' ') . ' €')
                ->color($remaining < 0 ? 'danger' : 'primary');
        }

        return $stats;
    }
}
