<?php

namespace App\Services;

/**
 * Сервис для работы с текстами
 */

use App\Exceptions\Posts\DumpFileNotFoundException;
use App\Exceptions\Posts\DumpFileWrongDataException;
use App\Models\Post;

class PostsService
{

    protected $textsService;

    public function __construct(TextsService $textsService)
    {
        $this->textsService = $textsService;
    }

    /**
     * Сохранить все текста и их значения в файл
     */
    public function export(string $path) : void
    {

        $posts = Post::get();
        $posts = json_encode($posts);

        file_put_contents($path, $posts);

    }

    /**
     * Загрузить все текста и их значения из файла
     */
    public function import(string $path) : void
    {

        if(!file_exists($path)) {
            throw new DumpFileNotFoundException($path);
        }

        Post::query()->delete();

        $posts = file_get_contents($path);
        $posts = json_decode($posts, true);

        if(is_null($posts)){
            throw new DumpFileWrongDataException;
        }

        \DB::transaction(function () use ($posts) {

            foreach($posts as $post) {

                Post::create([
                    'index' => $post['index'],
                    'delay' => $post['delay'],
                    'value' => $post['value'],
                    'type' => $post['type']
                ]);

            }

        });

    }

    /**
     * Метод для работы с HTML-редактором
     */
    public function normalize(string $text) : string
    {
        return $this->textsService->normalize($text);
    }

    /**
     * Метод для обработки после HTML-редактора
     */
    public function prepare(string $text) : string
    {
        return $this->textsService->prepare($text);
    }

}
