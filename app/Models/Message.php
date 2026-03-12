<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dialog(): BelongsTo
    {
        return $this->belongsTo(Dialog::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}