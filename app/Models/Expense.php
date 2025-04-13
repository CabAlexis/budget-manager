<?php

namespace App\Models;

use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ExpenseObserver::class])]
class Expense extends Model
{
    protected $fillable = [
        'envelope_id',
        'name',
        'amount',
        'date',
        'note',
        'is_recurring',
        'recurrence_type',
        'recurrence_end_date',
    ];

    protected $casts = [
        'date' => 'date',
    ];
    
    /**
     * Une dépense appartient à une enveloppe.
     */
    public function envelope(): BelongsTo
    {
        return $this->belongsTo(Envelope::class);
    }
}
