<?php

namespace App\Http\Controllers\Admin;

use App\Consts\FileTypes;
use App\Consts\MailingStatuses;
use App\Jobs\Telegram\SendMailing;
use App\Models\File;
use App\Models\Mailing;
use App\Models\MailingFile;
use App\Services\TextsService;
use App\Utilits\Api\ApiError;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MailingController extends Controller
{

    protected $textsService;

    public function __construct(TextsService $textsService)
    {
        $this->textsService = $textsService;
    }

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $data = $request->validate([
            'status' => ['nullable', 'string']
        ]);

        $items = Mailing::query();

        if(Arr::has($data, 'status')) {
            $items->where('status', $data['status']);
        }

        $paginator = new ModernPerfectPaginator($items);
        $paginator->setAllowedSearchColumns(['text']);
        $paginator->setAllowedSortColumns([
            'id',
            'text',
            'status',
            'users_count',
            'messages_count'
        ]);

        return $paginator->build($request)->map(function ($mailing) {
            return AdminPrepare::mailing($mailing);
        });

    }

    public function create(Request $request) : array
    {

        $data = $request->validate([
            'text' => ['required', 'string', 'max:4096'],
            'stages' => ['required', 'array', 'min:1'],
            'stages.*' => ['required', 'integer'],
            'tariffs' => ['required', 'array', 'min:1'],
            'tariffs.*' => ['required', 'integer'],
            'file_ids' => ['nullable', 'array'],
            'file_ids.*' => ['nullable', 'integer', 'exists:files,id'],
            'buttons' => ['nullable', 'array'],
            'buttons.*' => ['string']
        ], [
            'stages.min' => 'Вы не выбрали ни один сегмент',
            'tariffs.min' => 'Вы не выбрали ни один тариф',
            'file_id.exists' => 'Файл не найден'
        ]);

        $mailing = DB::transaction(function () use ($data) {

            $files_ids = Arr::get($data, 'file_ids') ?: [];
            $files_ids = array_filter($files_ids);

            $files = array_map(function (int $file_id) {
                return File::find($file_id);
            }, $files_ids);

            $files_types = array_map(function (File $file) {
                return $file->type;
            }, $files);

            if(
                (in_array(FileTypes::DOCUMENT, $files_types) || in_array(FileTypes::VOICE, $files_types)) &&
                (in_array(FileTypes::PHOTO, $files_types) || in_array(FileTypes::VIDEO, $files_types))
            ){
                throw new ApiError('Невозможно совместить отправку фото, видео и файлов');
            }

            $buttons = Arr::get($data, 'buttons') ?: [];
            $value = $this->textsService->prepare($data['text']);

            $mailing = Mailing::create([
                'text' => $value,
                'stages' => $data['stages'],
                'tariffs' => $data['tariffs'],
                'buttons' => $buttons
            ]);

            $mailing->files()->attach($files_ids);

            SendMailing::dispatch($mailing)->onQueue('telegram');

            return $mailing;

        });

        return AdminPrepare::mailing($mailing);

    }



    public function stop(Request $request, Mailing $mailing) : array
    {

        if($mailing->status === MailingStatuses::STOPPED || $mailing->status === MailingStatuses::FINISHED) {
            throw new ApiError('Данную рассылку остановить невозможно');
        }

        $mailing->status = MailingStatuses::STOPPED;
        $mailing->save();

        return AdminPrepare::mailing($mailing);

    }

    public function pause(Request $request, Mailing $mailing) : array
    {

        if($mailing->status !== MailingStatuses::IN_PROGRESS) {
            throw new ApiError('Не удалось приостановить рассылку');
        }

        $mailing->status = MailingStatuses::PAUSED;
        $mailing->save();

        return AdminPrepare::mailing($mailing);

    }

    public function play(Request $request, Mailing $mailing) : array
    {

        if($mailing->status !== MailingStatuses::PAUSED) {
            throw new ApiError('Не удалось возобновить рассылку');
        }

        DB::transaction(function () use ($mailing) {

            $mailing->status = MailingStatuses::IN_PROGRESS;
            $mailing->save();

            SendMailing::dispatch($mailing)->onQueue('telegram');

        });

        return AdminPrepare::mailing($mailing);

    }

}
