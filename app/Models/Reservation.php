<?php

namespace App\Models;

use App\Builders\ReservationBuilder;
use App\Enums\ReservationStatus;
use App\Traits\BelongsToRestaurant;
use Database\Factories\ReservationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property User $user
 * @property ReservationStatus $status
 *
 * @method static ReservationBuilder query()
 * @method static ReservationFactory factory($count = null, $state = [])
 */
class Reservation extends Model
{
    use BelongsToRestaurant, HasFactory;

    protected $fillable = [
        'start_at',
        'end_at',
        'remind_at',
        'canceled_at',
        'arrived_at',
        'status',
        'guest_count',
        'fulfilled',
        'note',
        'reminded',
        'user_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'remind_at' => 'datetime',
        'canceled_at' => 'datetime',
        'arrived_at' => 'datetime',
        'reminded' => 'boolean',
        'status' => ReservationStatus::class,
    ];

    public function newModelQuery(): ReservationBuilder
    {
        $builder = new ReservationBuilder($this->newBaseQueryBuilder());

        return $builder->setModel($this);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tables(): BelongsToMany
    {
        return $this->belongsToMany(Table::class, 'table_reservation')->withTimestamps();
    }
}
