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
}
