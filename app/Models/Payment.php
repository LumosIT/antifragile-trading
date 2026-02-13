<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'hash',
        'subscription_id',
        'amount',
        'user_id'
    ];

    /**
     * Relations
     */
    public function subscription() : BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
