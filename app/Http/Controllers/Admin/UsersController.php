<?php

namespace App\Http\Controllers\Admin;

use App\Consts\TariffModes;
use App\Jobs\RemoveOffer;
use App\Jobs\Telegram\KickFromChannels;
use App\Jobs\Telegram\SendOffer;
use App\Jobs\Telegram\SendRestartWarning;
use App\Jobs\Telegram\SendSecondStairInvite;
use App\Jobs\Telegram\SendThirdStairInvite;
use App\Jobs\Telegram\SendThirdStairTesting;
use App\Models\Offer;
use App\Models\Tariff;
use App\Models\User;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {
        $data = $request->validate([
            'user_id' => ['nullable','integer'],
            'is_banned' => ['nullable', 'integer'],
            'is_alive' => ['nullable', 'integer'],
            'stage' => ['nullable', 'integer'],
            'tariff_id' => ['nullable', 'integer'],
            'type' => ['nullable', 'string']
        ]);

        $users = User::query()->with('tariff');

        if(Arr::has($data, 'user_id')) {
            $users->where('id', (int)$data['user_id']);
        }

        if(Arr::has($data, 'stage')) {
            $users->where('stage', (int)$data['stage']);
        }

        if(Arr::has($data, 'is_banned')) {
            $users->where('is_banned', (bool)(int)$data['is_banned']);
        }

        if(Arr::has($data, 'is_alive')) {
            $users->where('is_alive', (bool)(int)$data['is_alive']);
        }

        if(Arr::has($data, 'tariff_id')) {
            $users->where('tariff_id', (int)$data['tariff_id']);
        }

        if(Arr::has($data, 'type')) {
            $users->where('type', $data['type']);
        }

        $paginator = new ModernPerfectPaginator($users);
        $paginator->enabledDateFilter();
        $paginator->setAllowedSearchColumns(['id','name', 'username', 'name_2', 'username_2', 'type', 'chat', 'email', 'fio', 'phone']);
        $paginator->setSearchPreparator(function(string $search) {
            return ltrim($search, '@');
        });
        $paginator->setAllowedSortColumns([
            'id',
            'type',
            'name',
            'username',
            'chat',
            'max_chat',
            'stage',
            'email',
            'fio',
            'phone',
            'stage',
            'created_at',
            'last_activity_at',
            'tariff_expired_at',
            'tariff_id'
        ]);

        return $paginator->build($request)->map(function ($user) {
            return AdminPrepare::user($user, true);
        });

    }

    public function changeBalance(Request $request, User $user) : array
    {

        $data = $request->validate([
            'value' => ['required', 'numeric', 'min:0', 'max:99999999999'],
        ]);

        $user->balance = $data['value'];
        $user->save();

        return AdminPrepare::user($user, true);

    }

    public function setTestCompleted(Request $request, User $user) : void
    {

        $data = $request->validate([
            'is_test_completed' => ['required', 'integer']
        ]);

        $user->is_test_completed = (int)$data['is_test_completed'];
        $user->save();

    }

    public function setBanned(Request $request, User $user) : void
    {

        $data = $request->validate([
            'is_banned' => ['required', 'integer']
        ]);

        $user->is_banned = (int)$data['is_banned'];
        $user->save();

    }

    public function edit(Request $request, User $user)
    {
        $data = $request->validate([
            'tariff_id' => ['nullable', 'integer', 'exists:tariffs,id'],
            'tariff_expired_at' => ['required', 'date']
        ]);

        $user->first_payment_at = $user->first_payment_at ?? now();
        $user->meta_is_buy = true;

        if(Arr::get($data, 'tariff_id')) {
            $tariff = Tariff::find(Arr::get($data, 'tariff_id'));
            $user->updateTariff($tariff->id);

            if($tariff->mode === TariffModes::FULL) {
                $user->stage = 3;
            } else {
                $user->stage = 2;
            }
        }

        $user->tariff_id = Arr::get($data, 'tariff_id') ?: null;
        $user->tariff_expired_at = $data['tariff_expired_at'];
        $user->save();
    }

    public function inviteSecondStair(Request $request, User $user) : void
    {
        if(filled($user->tariff_expired_at)) {
            SendSecondStairInvite::dispatch($user)->onQueue('telegram');
        } else {
            throw new Exception('У пользователя нет активного тарифа');
        }
    }

    public function inviteThirdStair(Request $request, User $user) : void
    {
        $user->is_test_completed = true;
        $user->save();

        SendThirdStairInvite::dispatch($user)->onQueue('telegram');
    }

    public function kick(Request $request, User $user) : void
    {
        KickFromChannels::dispatch($user)->onQueue('telegram');
    }

    public function inviteThirdStairTesting(Request $request, User $user) : void
    {
        SendThirdStairTesting::dispatch($user)->onQueue('telegram');
    }

    public function remove(Request $request, User $user) : void
    {
        $user->delete();

        SendRestartWarning::dispatch($user)->onQueue('telegram');
    }

    public function toggleStage(Request $request)
    {
        $id = $request->input('id');
        $target = $request->input('target');

        if (!$id || !in_array($target, ['get', 'remove'])) {
            return response()->json([
                'success' => false,
                'message' => 'Некорректные данные'
            ], 422);
        }

        $user = \App\Models\User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        if ($target === 'get') {
            $user->stage = 100;
        } else {
            $user->stage = 0;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'stage' => $user->stage
        ]);
    }

    public function sendOffer(Request $request, User $user) : void
    {
        $data = $request->validate([
            'tariff_id' => ['required', 'integer', 'exists:tariffs,id'],
        ]);

        $tariff = Tariff::query()->find($data['tariff_id']);

        $user->update([
            'offer_ready' => true
        ]);

        SendOffer::dispatch($user, $tariff)->onQueue('default');
    }

    public function offers(Request $request, $userId)
    {
        $columns = [
            0 => 'id',
            1 => 'tariff_id',
            2 => 'type',
            3 => 'is_deleted',
            4 => 'created_at',
        ];

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDir = $request->input('order.0.dir', 'desc');

        $search = $request->input('search.value');

        $query = Offer::query()
            ->where('user_id', $userId)
            ->with('tariff');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('message_id', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('id', $search);
            });
        }

        $totalData = Offer::where('user_id', $userId)->count();
        $totalFiltered = $query->count();

        $offers = $query
            ->orderBy($orderColumn, $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = [];

        foreach ($offers as $offer) {

            $data[] = [
                'id' => $offer->id,
                'tariff' => $offer->tariff->name ?? '-',
                'type' => $offer->type,
                'is_deleted' => $offer->is_deleted,
                'created_at' => $offer->created_at->format('d.m.Y H:i'),
                'actions' => '<button class="btn btn-sm btn-danger">Удалить</button>'
            ];
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }

    public function removeOffer(Request $request) {
        $offer = Offer::find($request->id);
        $offer->update([
            'is_deleted' => true
        ]);

        RemoveOffer::dispatch($offer)->onQueue('default');

        return response()->json();
    }
}
