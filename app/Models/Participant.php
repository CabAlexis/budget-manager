<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public function envelopes()
    {
        return $this->belongsToMany(Envelope::class)
            ->withPivot('ratio');
    }
}
