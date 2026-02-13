<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticDay extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'date',
        'registers',
        'activities',
        'sells',
        'sells_new',
        'sells_after_cancel',
        'sells_continues_first',
        'sells_continues',
        'cancels'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected $attributes = [
        'registers' => 0,
        'activities' => 0,
        'sells' => 0,
        'sells_new' => 0,
        'sells_after_cancel' => 0,
        'sells_continues_first' => 0,
        'sells_continues' => 0,
        'cancels' => 0,
    ];

}



