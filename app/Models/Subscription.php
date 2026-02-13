<?php

namespace App\Models;

use App\Consts\SubscriptionStatuses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{

    protected $fillable = [
        'status',
        'card',
        'amount',
        'period',
        'duration',
        'next_payment_at',
        'last_payment_at',
        'user_id',
        'tariff_id',
        'code'
    ];

    protected $hidden = [
        'card'
    ];

    protected $casts = [
        'next_payment_at' => 'datetime',
        'last_payment_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => SubscriptionStatuses::ACTIVE
    ];

    /**
     * Relations
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tariff() : BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scopes
     */
    public function scopeStoped(Builder $query) : Builder
    {
        return $query->where('status', SubscriptionStatuses::STOPPED);
    }

    public function scopeActive(Builder $query) : Builder
    {
        return $query->where('status', SubscriptionStatuses::ACTIVE);
    }

    public function scopeCanceled(Builder $query) : Builder
    {
        return $query->where('status', SubscriptionStatuses::CANCELLED);
    }
}

