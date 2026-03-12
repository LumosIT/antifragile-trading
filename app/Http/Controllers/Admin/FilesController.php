<?php

namespace App\Http\Controllers\Admin;

use App\Consts\FileTypes;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\MaxMailing\MaxFilesService;
use App\Services\PathService;
use App\Services\TelegramMailing\TelegramBaseService;
use App\Services\TelegramMailing\TelegramFilesService;
use App\Services\TelegramService;
use App\Utilits\Api\ApiFile;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\Traits\Auth\AdminGuard;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    use AdminGuard;

    protected $telegramService;
    protected $telegramBaseService;
    protected $telegramFilesService;
    protected $pathService;
    protected $maxFilesService;

    public function __construct(
        TelegramService $telegramService,
        TelegramBaseService $telegramBaseService,
        TelegramFilesService $telegramFilesService,
        MaxFilesService $maxFilesService,
        PathService $pathService
    )
    {
        $this->telegramService = $telegramService;
        $this->telegramBaseService = $telegramBaseService;
        $this->telegramFilesService = $telegramFilesService;
        $this->pathService = $pathService;
        $this->maxFilesService = $maxFilesService;
    }

    protected function sendUploadedFileToUs(UploadedFile $file) : string
    {
        $type = $this->getUploadedFileType($file);
        $blob = new \CURLFile(
            $file->getPathname(),
            $file->getMimeType(),
            $file->getClientOriginalName()
        );

        switch($type) {

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

    public function get(Request $request, File $file)
    {
        header('Content-Type', 'application/octet-stream');

        return $this->telegramService->getFile($file->hash);
    }

    public function upload(Request $request)
    {
        $data = $request->validate([
            'file' => ['nullable', 'file', 'max:51200'],
        ], [
            'file.max' => 'Файл весит больше 512Мб'
        ]);

        $file = $data['file'];
        $type = $this->getUploadedFileType($file);

        if ($type == 'photo') {
            $path = $file->store('uploads', 'public');
            $maxHash = 'https://petr-petr.ru' . Storage::url($path);
        } else {
            $maxHash = $this->saveFileInMax($file);
        }

        $hash = $this->sendUploadedFileToUs($file);

        $file = File::create([
            'max_hash' => $maxHash,
            'hash' => $hash,
            'type' => $type,
            'name' => $file->getClientOriginalName()
        ]);

        return AdminPrepare::file($file);
    }
}
