<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Text extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'value',
        'hint',
        'index',
        'text_group_id'
    ];

    protected $attributes = [
        'index' => 0
    ];

    /**
     * Relations
     */
    public function textGroup() : BelongsTo
    {
        return $this->belongsTo(TextGroup::class);
    }

}
