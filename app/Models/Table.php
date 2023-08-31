<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Table extends Model
{
    use HasFactory;

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

    public function isOccupied(Carbon $when = null): bool
    {
        return $this->reservations()
            ->whereNull('canceled_at')
            ->where('start_at', '<=', $when ?? now())
            ->where('end_at', '>=', $when ?? now())
            ->exists();
    }
}
