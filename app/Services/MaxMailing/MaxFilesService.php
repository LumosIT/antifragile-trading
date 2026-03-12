<?php

namespace App\Services\MaxMailing;

use App\Services\MaxService;
use App\Services\OptionsService;
use App\Services\PathService;
use CURLFile;
use Illuminate\Support\Facades\Log;

class MaxFilesService {
    
    protected $optionsService;
    protected $pathService;
    protected $maxService;

    public function __construct(OptionsService $optionsService, PathService  $pathService, MaxService $maxService)
    {
        $this->optionsService = $optionsService;
        $this->pathService = $pathService;
        $this->maxService = $maxService;
    }

    //max Enum: "image" "video" "audio" "file"
    public function saveFileInMax(CURLFile $file, string $type): string {
        if($type == 'document') {
            $type = 'file';
        } else if($type === 'photo') {
            $type = 'image';
        }

        $uploadUrl = $this->getUploadUrl($type);

        if(isset($uploadUrl['token'])) {
            return $uploadUrl['token'];
        }

        return $this->uploadFileToUrl($uploadUrl['url'], $file);
    }

    protected function getUploadUrl(string $type): array
    {
        $url = "https://platform-api.max.ru/uploads?type=$type";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: " . config('max.token')
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);

        return [
            'url' => $json['url'],
            'token' => $json['token'] ?? null
        ];
    }

    protected function uploadFileToUrl(string $uploadUrl, CURLFile $file): string
    {
        $ch = curl_init($uploadUrl);
        $postData = [
            "data" => $file
        ];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        $response = json_decode($response, true);

        return $response['token'];
    }
}