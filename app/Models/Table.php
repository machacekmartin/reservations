<?php

namespace App\Models;

use App\Traits\BelongsToRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Table extends Model
{
    use BelongsToRestaurant, HasFactory;

    protected $fillable = [
        'label',
        'available',
        'capacity',
        'location',
    ];

    protected $casts = [
        'location' => 'array',
    ];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'table_reservation')->withTimestamps();
    }

    public function isOccupied(Carbon $at = null): bool
    {
        return $this->reservations()
            ->whereNull('canceled_at')
            ->where('start_at', '<=', $at ?? now())
            ->where('end_at', '>=', $at ?? now())
            ->exists();
    }
}
