<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CloudPaymentToken extends Model
{

    protected $fillable = [
        'user_id',
        'hash'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
