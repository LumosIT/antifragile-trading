<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'code',
        'value',
        'type',
        'expired_at',
        'max_uses',
        'current_uses',
        'only_first_payment',
        'bonus_duration',
        'bonus_period'
    ];

    protected $appends = [
        'is_available'
    ];

    protected $attributes = [
        'current_uses' => 0,
        'only_first_payment' => false
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'only_first_payment' => 'boolean'
    ];

    /**
     * Relations
     */
    public function tariffs() : BelongsToMany
    {
        return $this->belongsToMany(Tariff::class, PromocodeTariff::class)
            ->using(PromocodeTariff::class)
            ->withTimestamps();
    }

    /**
     * Appends
     */
    public function getIsAvailableAttribute() : bool
    {
        return $this->current_uses <= $this->max_uses &&
            (!$this->expired_at || $this->expired_at > now());
    }


}
