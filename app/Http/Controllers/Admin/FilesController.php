<?php

namespace App\Http\Controllers\Admin;

use App\Consts\FileTypes;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\PathService;
use App\Services\TelegramMailing\TelegramBaseService;
use App\Services\TelegramMailing\TelegramFilesService;
use App\Services\TelegramService;
use App\Utilits\Api\ApiFile;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\Traits\Auth\AdminGuard;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FilesController extends Controller
{
    use AdminGuard;

    protected $telegramService;
    protected $telegramBaseService;
    protected $telegramFilesService;
    protected $pathService;

    public function __construct(
        TelegramService $telegramService,
        TelegramBaseService $telegramBaseService,
        TelegramFilesService $telegramFilesService,
        PathService $pathService
    )
    {
        $this->telegramService = $telegramService;
        $this->telegramBaseService = $telegramBaseService;
        $this->telegramFilesService = $telegramFilesService;
        $this->pathService = $pathService;
    }

    protected function getUploadedFileType(UploadedFile $file) : string
    {

        $path = $file->getClientOriginalName();

        switch(true){

            case $this->pathService->isVoice($path):
                return FileTypes::VOICE;

            case $this->pathService->isVideo($path):
                return FileTypes::VIDEO;

            case $this->pathService->isPicture($path):
                return FileTypes::PHOTO;

            default:
                return FileTypes::DOCUMENT;

        }

    }

    protected function sendUploadedFileToUs(UploadedFile $file) : string
    {

        $type = $this->getUploadedFileType($file);
        $blob = new \CURLFile(
            $file->getPathname(),
            $file->getMimeType(),
            $file->getClientOriginalName()
        );

        switch($type){

            case FileTypes::VIDEO:
                return $this->telegramFilesService->saveVideo($blob);

            case FileTypes::PHOTO:
                return $this->telegramFilesService->savePhoto($blob);

            case FileTypes::VOICE:
                return $this->telegramFilesService->saveVoice($blob);

            default:
                return $this->telegramFilesService->saveDocument($blob);


        }

    }

    public function get(Request $request, File $file) : ApiFile
    {

        header('Content-Type', 'application/octet-stream');

        echo $this->telegramService->getFile($file->hash);

    }



    public function upload(Request $request)
    {

        $data = $request->validate([
            'file' => ['nullable', 'file', 'max:51200'],
        ], [
            'file.max' => 'Файл весит больше 50Мб'
        ]);

        $file = $data['file'];

        $type = $this->getUploadedFileType($file);
        $hash = $this->sendUploadedFileToUs($file);

        $file = File::create([
            'hash' => $hash,
            'type' => $type,
            'name' => $file->getClientOriginalName()
        ]);

        return AdminPrepare::file($file);

    }

}
