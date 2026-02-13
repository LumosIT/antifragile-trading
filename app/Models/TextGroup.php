<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TextGroup extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * Relations
     */
    public function texts() : HasMany
    {
        return $this->hasMany(Text::class);
    }

}
