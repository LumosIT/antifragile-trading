<?php

namespace App\Models;

use App\Consts\UserStages;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'id',
        'name',
        'username',
        'chat',
        'picture',
        'balance',
        'parent_id',
        'tariff_id',

        'is_banned',
        'is_alive',
        'is_test_completed',

        'last_activity_at',
        'last_spam_at',
        'tariff_expired_at',
        'first_payment_at',
        'test_started_at',
        'died_at',
        'remaining_notify_at',
        'subscription_notify_at',
        'continue_notify_at',
        'test_suggested_at',


        //Telegram data
        'memory',
        'spam_stage',
        'start_key',

        //Meta data
        'stage',
        'email',
        'phone',
        'fio',

        //Meta targets
        'meta_is_accept_rules',
        'meta_is_buy',
        'meta_is_pre_form_filled',

        'type',
    ];

    protected $attributes = [
        'username' => null,
        'picture' => null,
        'balance' => 0,

        'email' => null,
        'phone' => null,
        'fio' => null,

        'is_banned' => false,
        'is_alive' => true,
        'is_test_completed' => false,

        'meta_is_accept_rules' => false,
        'meta_is_buy' => false,
        'meta_is_pre_form_filled' => false,

        'stage' => UserStages::NOT_START,

        'memory' => null,
        'spam_stage' => 0
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'is_alive' => 'boolean',
        'is_test_completed' => 'boolean',
        'meta_is_accept_rules' => 'boolean',
        'meta_is_buy' => 'boolean',
        'meta_is_pre_form_filled' => 'boolean',
        'last_activity_at' => 'datetime',
        'tariff_expired_at' => 'datetime',
        'first_payment_at' => 'datetime',
        'died_at' => 'datetime',
        'last_spam_at' => 'datetime',
        'test_started_at' => 'datetime',
        'remaining_notify_at' => 'datetime',
        'subscription_notify_at' => 'datetime',
        'continue_notify_at' => 'datetime',
        'test_suggested_at' => 'datetime'
    ];

    protected $appends = [
    ];

    /**
     * Relations
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function followers() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function subscriptions() : HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription() : HasOne
    {
        return $this->hasOne(Subscription::class)
            ->active()
            ->latestOfMany();
    }

    public function tariff() : BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function cloudPaymentTokens() : HasMany
    {
        return $this->hasMany(CloudPaymentToken::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Scopes
     */
    public function scopeAlive($query)
    {
        return $query->where('is_alive', true);
    }

    public function scopeIsBuy($query)
    {
        return $query->where('meta_is_buy', true);
    }


}
