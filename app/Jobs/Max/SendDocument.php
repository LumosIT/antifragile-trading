<?php

namespace App\Jobs\Max;

use App\Models\User;
use App\Services\MaxService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $text;
    protected $filePath;
    protected $type;

    public function __construct(User $user, string $filePath, string $text, string $type = 'file')
    {
        $this->user = $user;
        $this->text = $text;
        $this->filePath = $filePath;
        $this->type = $type;
    }

        public function handle()
        {
            $bot = new MaxService(config('max.support_token'));
            $fullPath = Storage::disk('public')->path($this->filePath);
            $maxHash = $this->uploadFileToMax($fullPath);
            sleep(5);

            $bot->sendFile($this->user->max_support_chat, $maxHash, $this->text, $this->type);
        }

        public function uploadFileToMax(string $filePath): string
        {
            $token = config('max.support_token');

            $uploadResponse = Http::withHeaders([
                'Authorization' => $token,
            ])->post("https://platform-api.max.ru/uploads?type=$this->type");

            $uploadData = $uploadResponse->json();
            $uploadUrl = $uploadData['url'];
            $fileToken = $uploadData['token'] ?? null;

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->attach(
                'data',
                file_get_contents($filePath),
                basename($filePath)
            )->post($uploadUrl);

            if (!$response->successful()) {
                throw new \Exception('Failed to upload file to MAX');
            }

            if ($fileToken) {
                return $fileToken;
            }

            $result = $response->json();

            if (!isset($result['token'])) {
                throw new \Exception('MAX did not return file token');
            }

            return $result['token'];
        }

}