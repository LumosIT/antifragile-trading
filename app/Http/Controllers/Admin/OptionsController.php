<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\Telegram\SendMailing;
use App\Models\Mailing;
use App\Models\Option;
use App\Services\OptionsService;
use App\Services\TextsService;
use Dom\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class OptionsController extends Controller
{

    protected $optionsService;

    public function __construct(OptionsService  $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    public function edit(Request $request, Option $option) : void
    {
        if($option->id == 'following_enabled') {
            if(filled($request->input('value'))) {
                $textsService = app(TextsService::class);
                $mailing = Mailing::create([
                    'text' => $textsService->get('announcement'),
                    'stages' => ["0","4","5","6","100"],
                    'tariffs' => ["0"],
                    'type' => 'all',
                    'buttons' => ["buy2"],
                ]);

                SendMailing::dispatch($mailing)->onQueue('telegram');
            }
        }

        $data = $request->validate([
            'value' => ['nullable', 'string', 'max:4096'],
        ]);

        $this->optionsService->set(
            $option->id,
            Arr::get($data, 'value') ?: ''
        );
    }

}
