<?php

namespace App\Models;

use App\Casts\OptionValueCast;
use App\Consts\OptionTypes;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'description',
        'value',
        'type'
    ];

    protected $casts = [
        'value' => OptionValueCast::class
    ];

    protected $attributes = [
        'type' => OptionTypes::STRING
    ];



}
