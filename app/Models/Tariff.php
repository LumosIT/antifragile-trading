<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tariff extends Model
{

    protected $fillable = [
        'name',
        'mode',
        'period',
        'duration',
        'price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $attributes = [
        'is_active' => true
    ];

    /**
     * Relations
     */
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function promocodes(): BelongsToMany
    {
        return $this->belongsToMany(Promocode::class, PromocodeTariff::class)
            ->using(PromocodeTariff::class)
            ->withTimestamps();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


}
