<?php

namespace App\Models;

use App\Data\Dimensions;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property-read Reservation|null $currentReservation
 * @property-read Reservation|null $soonestReservation
 * @property-read Dimensions $dimensions
 *
 * @method bool isReservedAt(Carbon $date)
 */
class Table extends Model
{
    use HasFactory;

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

    public function isReservedAt(Carbon $date): bool
    {
        return $this->reservations()
            ->where('canceled_at', null)
            ->where('start_at', '<=', $date)
            ->where('end_at', '>=', $date)
            ->exists();
    }

    public function isReservedBetween(Carbon $from, Carbon $to): bool
    {
        return $this->reservations()
            ->where('canceled_at', null)
            ->where(function ($query) use ($from, $to) {
                $query
                    ->whereBetween('start_at', [$from, $to])
                    ->orWhereBetween('end_at', [$from, $to]);
            })
            ->exists();
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
