<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use App\Services\OptionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OptionsController extends Controller
{

    protected $optionsService;

    public function __construct(OptionsService  $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    public function edit(Request $request, Option $option) : void
    {

        $data = $request->validate([
            'value' => ['nullable', 'string', 'max:4096'],
        ]);

        $this->optionsService->set(
            $option->id,
            Arr::get($data, 'value') ?: ''
        );

    }

}
