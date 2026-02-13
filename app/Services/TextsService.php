<?php

namespace App\Services;

/**
 * Сервис для работы с текстами
 */

use App\Exceptions\Texts\DumpFileNotFoundException;
use App\Exceptions\Texts\DumpFileWrongDataException;
use App\Exceptions\Texts\TextNotFoundException;
use App\Models\Text;
use Illuminate\Support\Facades\Cache;

class TextsService
{

    /**
     * Сохранить все текста и их значения в файл
     */
    public function export(string $path) : void
    {

        $texts = Text::get();
        $texts = json_encode($texts);

        file_put_contents($path, $texts);

    }

    /**
     * Загрузить все текста и их значения из файла
     */
    public function import(string $path) : void
    {

        if(!file_exists($path)) {
            throw new DumpFileNotFoundException($path);
        }

        $texts = file_get_contents($path);
        $texts = json_decode($texts, true);

        if(is_null($texts)){
            throw new DumpFileWrongDataException;
        }

        \DB::transaction(function () use ($texts) {

            foreach($texts as $text) {
                Text::query()
                    ->where('id', $text['id'])
                    ->update([
                        'value' => $text['value'],
                        'hint' => $text['hint']
                    ]);

            }

        });

        foreach($texts as $text) {
            $this->resetCache($text['id']);
        }

    }

    protected function stripEmptyTags(string $text) : string
    {

        $last = $text;
        while(true){

            $current = preg_replace('/<([a-z]+)\b[^>]*>\s*<\/\1>/ui', '', $last);

            if($current === $last){
                break;
            }

            $last = $current;

        }

        return $current;

    }

    /**
     * Метод для работы с HTML-редактором
     */
    public function normalize(string $text) : string
    {

        $str = $this->stripEmptyTags($text);
        $str = str_replace("</p>", "</p>\n", $str);
        $str = str_replace("</div>", "</div>\n", $str);
        $str = str_replace("&nbsp;", " ", $str);
        $str = strip_tags($str, '<a><b><s><u><i>');

        return $str;

    }

    /**
     * Метод для обработки после HTML-редактора
     */
    public function prepare(string $text) : string
    {
        return strip_tags($text, '<a><b><s><u><i><br><p><div>');
    }

    public function get(string $id, array $vars = [], bool $normalize = true) : string
    {

        $value = Cache::remember(
            $this->getTextCacheKey($id),
            $this->getTextCacheTime(),
            function() use ($id) {

                $row = Text::find($id);

                if (!$row) {
                    throw new TextNotFoundException($id);
                }

                return $row->value ?: '';

            });

        foreach ($vars as $k => $v) {
            $value = str_replace('{' . $k . '}', $v, $value);
        }

        return $normalize ? $this->normalize($value) : $value;

    }

    public function set(string $id, string $value) : void
    {

        $rows = Text::query()
            ->where('id', $id)
            ->update([
                'value' => $value
            ]);

        if(!$rows){
            throw new TextNotFoundException($id);
        }

        Cache::put(
            $this->getTextCacheKey($id),
            $value,
            $this->getTextCacheTime()
        );

    }

    public function resetCache(string $id) : void
    {
        Cache::forget($this->getTextCacheKey($id));
    }

    public function resetCacheAll() : void
    {

        $texts = Text::get();

        foreach($texts as $text) {
            $this->resetCache($text->id);
        }

    }

    protected function getTextCacheKey(string $id) : string
    {
        return 'text_' . $id;
    }

    protected function getTextCacheTime() : int
    {
        return 60 * 60;
    }

}
