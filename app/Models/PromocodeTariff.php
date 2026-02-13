<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PromocodeTariff extends Pivot
{
    public $timestamps = true;
    public $incrementing = true;

    protected $table = 'promocode_tariffs';

    protected $fillable = [
        'promocode_id',
        'tariff_id',
    ];

    /**
     * Relations
     */
    public function tariff() : BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function promocode() : BelongsTo
    {
        return $this->belongsTo(Promocode::class)->withTrashed();
    }
}
