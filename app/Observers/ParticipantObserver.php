<?php

namespace App\Observers;

use App\Models\BudgetMonth;
use App\Models\Participant;

class ParticipantObserver
{
    public function created(Participant $participant): void
    {
        $this->updateTotalIncome();
    }

    public function updated(Participant $participant): void
    {
        $this->updateTotalIncome();
    }

    public function deleted(Participant $participant): void
    {
        $this->updateTotalIncome();
    }

    protected function updateTotalIncome(): void
    {
        $currentBudgetMonth = BudgetMonth::getCurrent();

        $currentBudgetMonth->update([
            'total_income' => Participant::sum('income'),
        ]);
    }
}
