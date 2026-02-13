<?php

namespace App\Models;

use App\Consts\MailingStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mailing extends Model
{

    protected $fillable = [
        'text',
        'messages_count',
        'errors_count',
        'users_count',
        'last_user_id',
        'status',
        'stages',
        'tariffs',
        'buttons'
    ];

    protected $casts = [
        'stages' => 'array',
        'tariffs' => 'array',
        'buttons' => 'array'
    ];

    protected $attributes = [
        'status' => MailingStatuses::CREATED,
        'messages_count' => 0,
        'errors_count' => 0,
        'users_count' => 0
    ];

    public function files() : BelongsToMany
    {
        return $this->belongsToMany(File::class, MailingFile::class)
            ->using(MailingFile::class)
            ->withTimestamps();
    }

}
