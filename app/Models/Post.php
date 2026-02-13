<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{

    protected $fillable = [
        'index',
        'delay',
        'value',
        'file_id',
        'type'
    ];

    protected $attributes = [
        'index' => 0,
    ];

    /**
     * Relations
     */
    public function file() : BelongsTo
    {
        return $this->belongsTo(File::class);
    }

}
