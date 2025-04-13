<?php

namespace App\Models;

use App\Observers\ParticipantObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ParticipantObserver::class])]
class Participant extends Model
{
    protected $fillable = [
        'name',
        'income'

    ];

    public function envelopes()
    {
        return $this->belongsToMany(Envelope::class)
            ->withPivot('ratio');
    }
}
