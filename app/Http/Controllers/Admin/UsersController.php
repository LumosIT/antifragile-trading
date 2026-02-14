<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\Telegram\KickFromChannels;
use App\Jobs\Telegram\SendClearMenu;
use App\Jobs\Telegram\SendOffer;
use App\Jobs\Telegram\SendRestartWarning;
use App\Jobs\Telegram\SendSecondStairInvite;
use App\Jobs\Telegram\SendThirdStairInvite;
use App\Jobs\Telegram\SendThirdStairTesting;
use App\Models\Fund;
use App\Models\StatisticDaily;
use App\Models\Tariff;
use App\Models\User;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UsersController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $data = $request->validate([
            'is_banned' => ['nullable', 'integer'],
            'is_alive' => ['nullable', 'integer'],
            'stage' => ['nullable', 'integer'],
            'tariff_id' => ['nullable', 'integer'],
            'type' => ['nullable', 'string']
        ]);

        $users = User::query()->with('tariff');

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
        $paginator->setAllowedSearchColumns(['username', 'type', 'chat', 'email', 'fio', 'phone', 'name']);
        $paginator->setSearchPreparator(function(string $search) {
            return ltrim($search, '@');
        });
        $paginator->setAllowedSortColumns([
            'id',
            'type',
            'name',
            'username',
            'chat',
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

    public function edit(Request $request, User $user) : void
    {

        $data = $request->validate([
            'tariff_id' => ['nullable', 'integer', 'exists:tariffs,id'],
            'tariff_expired_at' => ['required', 'date']
        ]);

        $user->tariff_id = Arr::get($data, 'tariff_id') ?: null;
        $user->tariff_expired_at = $data['tariff_expired_at'];
        $user->spam_stage = 0;
        $user->last_spam_at = null;
        $user->save();

    }

    public function inviteSecondStair(Request $request, User $user) : void
    {
        SendSecondStairInvite::dispatch($user)->onQueue('telegram');
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

    public function sendOffer(Request $request, User $user) : void
    {

        $data = $request->validate([
            'tariff_id' => ['required', 'integer', 'exists:tariffs,id'],
        ]);

        $tariff = Tariff::query()->find($data['tariff_id']);

        SendOffer::dispatch($user, $tariff)->onQueue('telegram');

    }

}
