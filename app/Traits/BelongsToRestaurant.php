<?php

namespace App\Traits;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToRestaurant
{
    public function getFillable()
    {
        return array_merge($this->fillable, ['restaurant_id']);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
