<?php

namespace App\Services;

/**
 * Сервис для работы с настройками
 */

use App\Exceptions\Options\OptionNotFoundException;
use App\Models\Option;
use Illuminate\Support\Facades\Cache;

class OptionsService
{

    public function create(string $id, string $type, string $description, string $value = '') : Option
    {
        return Option::create([
            'id' => $id,
            'type' => $type,
            'value' => $value,
            'description' => $description,
        ]);
    }

    public function get(string $id)
    {

        return Cache::remember(
            $this->getOptionCacheKey($id),
            $this->getOptionCacheTime(),
            function() use ($id){

                $row = Option::find($id);

                if(!$row){
                    throw new OptionNotFoundException($id);
                }

                return $row->value;

            }
        );

    }

    public function set(string $id, $value) : void
    {

        $row = Option::find($id);

        if(!$row){
            throw new OptionNotFoundException($id);
        }

        $row->value = $value;
        $row->save();

        Cache::put(
            $this->getOptionCacheKey($id),
            $row->value,
            $this->getOptionCacheTime()
        );

    }

    public function resetCache(string $id) : void
    {
        Cache::forget($this->getOptionCacheKey($id));
    }

    protected function getOptionCacheKey(string $id) : string
    {
        return 'option_' . $id;
    }

    protected function getOptionCacheTime() : int
    {
        return 60 * 60;
    }

}
