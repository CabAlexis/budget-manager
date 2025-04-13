<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetMonth extends Model
{
    protected $fillable = [
        'month',
        'year',
        'income_total',
        'saving_goal',
    ];

    /**
     * Un BudgetMonth possède plusieurs enveloppes.
     */
    public function envelopes(): HasMany
    {
        return $this->hasMany(Envelope::class);
    }

    public static function getPrevious(BudgetMonth $budgetMonth): ?self
    {
        return self::query()
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
    }

    public static function getCurrent(): self
    {
        return self::query()
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->firstOrFail();
    }
}
