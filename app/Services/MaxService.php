<?php

namespace App\Services;

use CURLFile;
use Illuminate\Support\Facades\Log;

class MaxService
{

    public string $token;
    public ?string $message;
    public ?string $firstName;
    public ?string $lastName;
    public string $chat;

    public function __construct($token = null)
    {
        if(isset($token)) {
            $this->token = $token;
        } else {
            $this->token = config('max.token');
        }
    }

    public function setWebhook(string $webhookUrl, string $secret) : array
    {
        $url = "https://platform-api.max.ru/subscriptions";

        $data = [
            "url" => $webhookUrl,
            "update_types" => [
                "message_callback",
                "message_created",
                // "message_edited",
                // "bot_added",
                // "bot_removed",
                // "dialog_muted",
                // "dialog_unmuted",
                // "dialog_cleared",
                // "user_added",
                // "user_removed",
                // "bot_stopped",
                "bot_started",
                // "chat_title_changed",
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

    function sendMessage(string $chat, string $text, array $keyboard = [], $parseMode = 'html'): array
    {
        Log::info($text);
        $url = "https://platform-api.max.ru/messages?chat_id=" . $chat;

        $data = [
            "text" => $text,
            "format" => $parseMode,
            "disable_link_preview" => true
        ];

        if (!empty($keyboard)) {
            $data["attachments"] = [
                [
                    "type" => "inline_keyboard",
                    "payload" => [
                        "buttons" => $keyboard
                    ]
                ],
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

    function sendImage(string $chat, string $imageUrl, string $caption = '', array $keyboard = []): array
    {
        $url = "https://platform-api.max.ru/messages?chat_id=" . $chat;

        $data = [
            "text" => $caption,
            "format" => "html",
            "attachments" => [
                [
                    "type" => "image",
                    "payload" => [
                        "url" => $imageUrl
                    ]
                ]
            ]
        ];

        if (!empty($keyboard)) {
            $data["attachments"][] = [
                "type" => "inline_keyboard",
                "payload" => [
                    "buttons" => $keyboard
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

    public function kickUserFromChannel($user, $chatId = "-70931186387659") {
        $userId = $user->max_user_id;

        $url = "https://platform-api.max.ru/chats/$chatId/members?user_id=$userId";

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "Authorization: $this->token",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        Log::info('Kick User', [
            $response,
            $error
        ]);

        curl_close($ch);
    }

    public function parseSubscribers():array
    {
        $limit = 100;
        $marker = null;
        $allMembers = [];

        do {
            $url = "https://platform-api.max.ru/chats/-70931186387659/members?limit=$limit";

            if ($marker) {
                $url .= "&marker=" . urlencode($marker);
            }

            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: " . $this->token
                ],
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);

            if (!isset($data['members'])) {
                break;
            }

            $allMembers = array_merge($allMembers, $data['members']);

            $marker = $data['marker'] ?? null;

        } while ($marker);

        return $allMembers;
    }

    public function sendFile(string $chat, string $fileToken, string $caption, $type = 'file'): array
    {
        $url = "https://platform-api.max.ru/messages?chat_id=" . $chat;

        $data = [
            "text" => $caption,
            "format" => "html",
            "attachments" => [
                [
                    "type" => $type,
                    "payload" => [
                        "token" => $fileToken
                    ]
                ]
            ]
        ];

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
}