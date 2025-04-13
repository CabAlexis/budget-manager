<?php

namespace App\Filament\Widgets;

use App\Models\BudgetMonth;
use Filament\Widgets\ChartWidget;

class ExpensesByEnvelopeChart extends ChartWidget
{
    protected static ?int $sort = 3;
    
    protected static ?string $heading = 'Répartition des dépenses par enveloppe';

    protected static ?string $maxHeight = '300px';

    protected static string $color = 'primary';

    protected function getData(): array
    {
        $currentBudget = BudgetMonth::latest()->first();

        if (! $currentBudget) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'data' => $currentBudget->envelopes->map(fn ($envelope) => $envelope->amount_spent),
                    'backgroundColor' => [
                        '#F87171',
                        '#60A5FA',
                        '#34D399',
                        '#FBBF24',
                        '#A78BFA',
                        '#F472B6',
                    ],
                ],
            ],
            'labels' => $currentBudget->envelopes->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
