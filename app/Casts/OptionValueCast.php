<?php

namespace App\Casts;

use App\Consts\OptionTypes;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class OptionValueCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if($model->type === OptionTypes::BOOLEAN){
            return (bool)(int)$value;
        }

        if($model->type === OptionTypes::NUMBER){
            return (float)$value;
        }

        return $value ?: '';
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {

        if($model->type === OptionTypes::BOOLEAN){
            $value = (bool)$value;
        }elseif($model->type === OptionTypes::NUMBER){
            $value = (float)$value;
        }else{
            $value = (string)$value;
        }

        return $value;
    }
}
