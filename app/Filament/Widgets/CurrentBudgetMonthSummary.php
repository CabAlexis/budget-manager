<?php

namespace App\Filament\Widgets;

use App\Models\BudgetMonth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CurrentBudgetMonthSummary extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $currentBudget = BudgetMonth::latest()->first();
    
        if (! $currentBudget) {
            return [
                Stat::make('Aucun budget trouvé', 'Créez votre premier budget'),
            ];
        }
    
        $totalSpent = $currentBudget->envelopes->sum(fn ($envelope) => $envelope->amount_spent);
        $remaining = $currentBudget->income_total - $totalSpent;
    
        return [
            Stat::make('Revenus', number_format($currentBudget->income_total, 2, ',', ' ') . ' €')
                ->description('Total des revenus pour ce mois')
                ->descriptionColor('success'),
        
            Stat::make('Dépensé', number_format($totalSpent, 2, ',', ' ') . ' €')
                ->description('Total des dépenses réalisées')
                ->descriptionColor('warning'),
        
            Stat::make('Reste', number_format($remaining, 2, ',', ' ') . ' €')
                ->description('Fonds restants')
                ->descriptionColor('danger'),
        ];
    }
    
}
