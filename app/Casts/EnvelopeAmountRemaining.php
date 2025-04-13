<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class EnvelopeAmountRemaining implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $model->amount_allocated - $model->amount_spent;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
