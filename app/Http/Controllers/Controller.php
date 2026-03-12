<?php

namespace App\Http\Controllers;

use App\Consts\FileTypes;
use App\Services\MaxMailing\MaxFilesService;
use App\Services\PathService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\UploadedFile;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function successResponse($message, $object = [], $code = 200)
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
        ], $object), $code);
    }

    public static function errorResponse($message, $object = [], $code = 202)
    {
        return response()->json(array_merge([
            'success' => false,
            'message' => $message,
        ], $object), $code);
    }

    protected function getUploadedFileType(UploadedFile $file) : string
    {
        $path = $file->getClientOriginalName();
        $pathService = app(PathService::class);

        switch(true){

            case $pathService->isVoice($path):
                return FileTypes::VOICE;

            case $pathService->isVideo($path):
                return FileTypes::VIDEO;

            case $pathService->isPicture($path):
                return FileTypes::PHOTO;

            default:
                return FileTypes::DOCUMENT;
        }
    }

    protected function saveFileInMax(UploadedFile $file): string
    {
        $type = $this->getUploadedFileType($file);
        $blob = new \CURLFile(
            $file->getPathname(),
            $file->getMimeType(),
            $file->getClientOriginalName()
        );

        $maxFilesService = app(MaxFilesService::class);

        return $maxFilesService->saveFileInMax($blob, $type);
    }
}
