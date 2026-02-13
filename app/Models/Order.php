<?php

namespace App\Models;

use App\Consts\OrderStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{

    protected $fillable = [
        'code',
        'promocode_id',
        'tariff_id',
        'user_id',
        'amount',
        'status'
    ];

    protected $attributes = [
        'status' => OrderStatuses::ACTIVE
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promocode() : BelongsTo
    {
        return $this->belongsTo(Promocode::class)->withTrashed();
    }

    public function tariff() : BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }
}
