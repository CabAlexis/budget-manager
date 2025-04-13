<?php

namespace App\Filament\Widgets;

use App\Models\BudgetMonth;
use Filament\Widgets\ChartWidget;

class ExpensesEvolutionChart extends ChartWidget
{
    protected static ?int $sort = 4;
    
    protected static ?string $heading = 'Évolution des dépenses';

    protected static ?string $maxHeight = '300px';

    protected static string $color = 'warning';

    protected function getData(): array
    {
        $currentBudget = BudgetMonth::latest()->first();

        if (! $currentBudget) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $dates = [];
        $data = [];

        $startDate = now()->startOfMonth();
        $endDate = now();

        $expenses = $currentBudget->envelopes
            ->flatMap->expenses
            ->groupBy(fn ($expense) => $expense->date->format('Y-m-d'));

        $total = 0;

        foreach ($startDate->toPeriod($endDate) as $date) {
            $dayExpenses = $expenses[$date->format('Y-m-d')] ?? collect();
            $total += $dayExpenses->sum('amount');

            $dates[] = $date->format('d/m');
            $data[] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Dépenses cumulées',
                    'data' => $data,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
