<?php

namespace App\Services;

use App\Exceptions\Telegram\NotAllowForBannedException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaxService
{

    public string $token;
    public ?string $message;
    public ?string $firstName;
    public ?string $lastName;
    public string $userId;
    public StatisticService $statisticService;

    public function __construct($token)
    {
        $this->token = $token;
        $this->statisticService = new StatisticService();
    }

    public function setWebhook(string $webhookUrl, string $secret) : array
    {
        $url = "https://platform-api.max.ru/subscriptions";

        $data = [
            "url" => $webhookUrl,
            "update_types" => [
                "message_created",
                "bot_started"
            ],
            "secret" => $secret
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: $this->token",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        return [
            'response' => json_decode($response, true),
            'error' => $error
        ];
    }

    function sendMessage(string $userId, string $text, array $keyboard = []): array
    {
        $url = "https://platform-api.max.ru/messages?user_id=" . $userId;

        $data = [
            "text" => $text
        ];

        if (!empty($keyboard)) {
            $data["attachments"] = [
                [
                    "type" => "inline_keyboard",
                    "payload" => [
                        "buttons" => $keyboard
                    ]
                ]
            ];
        }

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: $this->token",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        return [
            'response' => json_decode($response, true),
            'error' => $error
        ];
    }

    function parseMaxWebhook(array $data): void
    {
        $this->message = $data['message']['body']['text'] ?? null;
        $this->firstName = $data['message']['sender']['first_name'] ?? null;
        $this->lastName = $data['message']['sender']['last_name'] ?? null;
        $this->userId = $data['message']['sender']['user_id'] ?? null;
    }

    public function getOrCreateUser(): User
    {
        return DB::transaction(function () {
            $user = User::query()
                ->where('chat', (string)$this->userId)
                ->where('type', 'max')
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $this->firstName,
                    'username' => $this->lastName,
                    'chat' => $this->userId,
                    'picture' => null,
                    'type' => 'max',
                ]);
                $this->statisticService->onRegister($user);
                $this->statisticService->onActivity($user);
            } else {
                if($user->is_banned) {
                    throw new NotAllowForBannedException;
                }
                if($user->last_activity_at->format('d.m.Y') !== now()->format('d.m.Y')) {
                    $this->statisticService->onActivity($user);
                }

                $user->last_activity_at = now();
                $user->is_alive = true;
                $user->died_at = null;
                $user->save();

            }

            return $user;
        });

    }

}