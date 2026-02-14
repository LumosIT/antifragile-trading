<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MaxService;
use Illuminate\Support\Facades\Log;

class MaxController extends Controller
{
    public function webhook(Request $request)
    {
        $data = $request->all();
        Log::info('RAW MAX', $data);

        $service = new MaxService('f9LHodD0cOL4WelEHFKocxVJBKpI-HUEFoPKS1t9PubnaEQnJdaGPAhqJ3R3gCN5_g7JcoNvsWb-CWrD8hEc');
        $service->parseMaxWebhook($data);
        $user = $service->getOrCreateUser();

        Log::info('user', [$user]);

        $keyboard = [
            [
                [
                    "type" => "link",
                    "text" => "Открыть сайт",
                    "url" => "https://example.com"
                ]
            ]
        ];

        $service->sendMessage($user->chat, "Нажми кнопку:", $keyboard);


        return response()->json(['ok' => true]);
    }

    public function setWebhook()
    {
        $service = new MaxService('f9LHodD0cOL4WelEHFKocxVJBKpI-HUEFoPKS1t9PubnaEQnJdaGPAhqJ3R3gCN5_g7JcoNvsWb-CWrD8hEc');
        $response = $service->setWebhook("https://petr-petr.ru/services/max/webhook", "my_secret_key_123");

        return response()->json($response);
    }
}
