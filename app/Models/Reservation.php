<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_at',
        'end_at',
        'remind_at',
        'canceled_at',
        'guest_count',
        'fulfilled',
        'note',
        'user_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'remind_at' => 'datetime',
        'canceled_at' => 'datetime',
        'fulfilled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tables(): BelongsToMany
    {
        return $this->belongsToMany(Table::class, 'table_reservation');
    }
}
