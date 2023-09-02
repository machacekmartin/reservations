<?php

namespace App\Models;

use App\Traits\BelongsToRestaurant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected function currentReservation(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservations()
                ->whereNull('canceled_at')
                ->where('start_at', '<=', $at ?? now())
                ->where('end_at', '>=', $at ?? now())
                ->first(),
        );
    }
}
