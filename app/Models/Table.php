<?php

namespace App\Models;

use App\Data\Dimensions;
use App\Traits\HasReservationUtilities;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Reservation|null $currentReservation
 * @property-read Reservation|null $soonestReservation
 * @property-read Dimensions $dimensions
 */
class Table extends Model
{
    use HasFactory, HasReservationUtilities;

    protected $fillable = [
        'label',
        'available',
        'capacity',
        'dimensions',
    ];

    protected $casts = [
        'dimensions' => Dimensions::class,
        'available' => 'boolean',
    ];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'table_reservation')->withTimestamps();
    }

    protected function currentReservation(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservations()
                ->where('canceled_at', null)
                ->where('start_at', '<=', now())
                ->where('end_at', '>=', now())
                ->first()
        );
    }

    protected function soonestReservation(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservations()
                ->whereNull('canceled_at')
                ->where('start_at', '>=', now())
                ->orderBy('start_at', 'asc')
                ->first()
        );
    }
}
