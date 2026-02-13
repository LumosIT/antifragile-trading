<?php

namespace App\Http\Controllers\Admin;

use App\Consts\PostTypes;
use App\Models\Post;
use App\Services\PostsService;
use App\Services\TextsService;
use App\Utilits\Api\ApiError;
use App\Utilits\Prepare\AdminPrepare;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{

    protected $postsService;
    protected $textsService;

    public function __construct(PostsService $postsService, TextsService $textsService)
    {
        $this->postsService = $postsService;
        $this->textsService = $textsService;
    }

    public function create(Request $request) : array
    {

        $data = $request->validate([
            'value' => ['required', 'string'],
            'delay' => ['nullable', 'integer', 'min:0', 'max:9999999999'],
            'file_id' => ['nullable', 'integer', 'exists:files,id'],
            'type' => ['required', 'string', Rule::in([PostTypes::FIRST_STAIR, PostTypes::SECOND_STAIR, PostTypes::THIRD_STAIR])],
        ], [
            'value.required' => 'Вы не указали текст',
            'file_id.exists' => 'Файл не найден'
        ]);

        $file_id = Arr::get($data, 'file_id', null);

        $value = $this->postsService->prepare($data['value']);
        $length = $file_id ? 1024 : 4096;

        if(Str::length($this->textsService->normalize($value)) > $length){
            throw new ApiError('Текст слишком длинный');
        }

        $post = Post::create([
            'value' => $data['value'],
            'delay' => $data['delay'],
            'type' => $data['type'],
            'file_id' => $file_id
        ]);

        return AdminPrepare::post($post);

    }

    public function editContent(Request $request, Post $post) : array
    {

        $data = $request->validate([
            'value' => ['required', 'string'],
            'file_id' => ['nullable', 'integer', 'exists:files,id']
        ], [
            'value.required' => 'Вы не указали текст',
            'file_id.exists' => 'Файл не найден'
        ]);

        $file_id = Arr::get($data, 'file_id', null);

        $value = $this->postsService->prepare($data['value']);
        $length = $file_id ? 1024 : 4096;

        if(Str::length($this->textsService->normalize($value)) > $length){
            throw new ApiError('Текст слишком длинный');
        }

        $post->file_id = Arr::get($data, 'file_id', null);
        $post->value = $value;
        $post->save();

        return AdminPrepare::post($post);

    }

    public function editDelay(Request $request, Post $post) : array
    {

        $data = $request->validate([
            'delay' => ['required', 'integer', 'min:0', 'max:9999999999']
        ]);

        $post->delay = $data['delay'];
        $post->save();

        return AdminPrepare::post($post);

    }

    public function remove(Request $request, Post $post) : void
    {
        $post->delete();
    }

    public function setIndexes(Request $request) : void
    {

        $data = $request->validate([
            'data' => ['required', 'array'],
            'data.*.id' => ['required', 'integer'],
            'data.*.index' => ['required', 'integer', 'min:0', 'max:999999999'],
        ]);

        DB::transaction(function () use ($data) {

            foreach($data['data'] as $post){
                Post::query()
                    ->where('id', $post['id'])
                    ->update(['index' => $post['index']]);
            }

        });


    }

}
