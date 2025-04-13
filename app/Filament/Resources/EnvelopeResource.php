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

        // Clonage des enveloppes récurrentes
        foreach ($previousBudgetMonth->envelopes()->where('is_recurring', true)->get() as $previousEnvelope) {
            $newEnvelope = $budgetMonth->envelopes()->create([
                'name' => $previousEnvelope->name,
                'amount_allocated' => $previousEnvelope->amount_allocated,
                'is_recurring' => true,
            ]);

            // Copier les participants et leurs ratios
            $newEnvelope->participants()->sync(
                $previousEnvelope->participants->pluck('pivot.ratio', 'id')->toArray()
            );

            // Clonage des dépenses récurrentes associées
            foreach ($previousEnvelope->expenses()->where('is_recurring', true)->get() as $expense) {
                $newEnvelope->expenses()->create([
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
