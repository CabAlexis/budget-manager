<?php

namespace App\Observers;

use App\Models\BudgetMonth;

class BudgetMonthObserver
{
    public function created(BudgetMonth $budgetMonth): void
{
    $previousBudgetMonth = BudgetMonth::query()
        ->where(function ($query) use ($budgetMonth) {
            $query->where('year', '<', $budgetMonth->year)
                  ->orWhere(function ($query) use ($budgetMonth) {
                      $query->where('year', $budgetMonth->year)
                            ->where('month', '<', $budgetMonth->month);
                  });
        })
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->first();

    if (! $previousBudgetMonth) {
        return;
    }

    foreach ($previousBudgetMonth->envelopes as $previousEnvelope) {
        foreach ($previousEnvelope->expenses()->where('is_recurring', true)->get() as $expense) {
            $envelope = $budgetMonth->envelopes()
                ->where('name', $previousEnvelope->name)
                ->first();

            if ($envelope) {
                $envelope->expenses()->create([
                    'name' => $expense->name,
                    'amount' => $expense->amount,
                    'date' => now()->startOfMonth(),
                    'note' => 'Dépense récurrente auto-générée',
                    'is_recurring' => true,
                ]);
            }
        }
    }
}

}
