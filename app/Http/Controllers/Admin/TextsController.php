<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use App\Models\StatisticDaily;
use App\Models\Text;
use App\Services\TextsService;
use App\Utilits\Api\ApiError;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TextsController extends Controller
{

    protected $textsService;

    public function __construct(TextsService $textsService)
    {
        $this->textsService = $textsService;
    }


    public function edit(Request $request, Text $text) : void
    {

        $data = $request->validate([
            'value' => ['nullable', 'string'],
        ]);

        $value = Arr::get($data, 'value') ?: '';
        $value = $this->textsService->prepare($value);

        if(Str::length($this->textsService->normalize($value)) > 4096){
            throw new ApiError('Текст слишком длинный');
        }

        $this->textsService->set($text->id, $value);

    }

    public function editHint(Request $request, Text $text) : void
    {

        $data = $request->validate([
            'hint' => ['nullable', 'string', 'max:4096']
        ], [
            'hint.max' => 'Комментарий слишком длинный'
        ]);

        $text->hint = $data['hint'];
        $text->save();

    }

}
