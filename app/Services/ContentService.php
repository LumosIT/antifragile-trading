<?php

namespace App\Services;

use App\Models\Text;

class ContentService
{
    public static function getContent($key, $replace = false) : string {
        if($replace) {  
            return str_replace("<br>", "", Text::where('id', $key)->first()->value ?? '');
        }
        
        return Text::where('id', $key)->first()->value ?? '';
    }
}