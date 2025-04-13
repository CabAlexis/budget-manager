<?php

namespace App\Observers;

use App\Models\Expense;

class ExpenseObserver
{
    public function created(Expense $expense): void
    {
        if (! $expense->envelope) {
            return;
        }

        foreach ($expense->envelope->participants as $participant) {
            $amountForParticipant = $expense->amount * ($participant->pivot->ratio / 100);

            // Ici : future table ExpenseParticipant / Stats / Reporting / Log etc.
        }
    }
}
