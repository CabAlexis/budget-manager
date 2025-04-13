<?php

namespace App\Models;

use App\Casts\EnvelopeAmountRemaining;
use App\Casts\EnvelopeAmountSpent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Envelope extends Model
{
    protected $fillable = [
        'budget_month_id',
        'name',
        'amount_allocated',
        'amount_spent',
    ];

    protected $casts = [
        'amount_spent' => EnvelopeAmountSpent::class,
        'amount_remaining' => EnvelopeAmountRemaining::class,
    ];

    /**
     * Une enveloppe appartient à un BudgetMonth.
     */
    public function budgetMonth(): BelongsTo
    {
        return $this->belongsTo(BudgetMonth::class);
    }

    /**
     * Une enveloppe possède plusieurs dépenses.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
