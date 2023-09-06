<?php

namespace App\Models;

use App\Data\Dimensions;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Reservation|null $currentReservation
 * @property-read Dimensions $dimensions
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
}
