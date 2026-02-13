<?php

namespace App\Http\Controllers\Admin;

use App\Models\StatisticDay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{


    public function statistic(Request $request) : array
    {

        $data = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ]);

        $from = Carbon::parse($data['from'])->setTime(0, 0, 0);
        $to = Carbon::parse($data['to'])->setTime(23, 59, 59);

        $usersStatistic = DB::table(User::query()->getModel()->getTable())
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('
                COUNT(id) as `count`,
                SUM(`meta_is_accept_rules`) as `meta_is_accept_rules`,
                SUM(`meta_is_buy`) as `meta_is_buy`
            ')
            ->first();


        $usersAliveStatistic = User::query()
            ->whereBetween('created_at', [$from, $to])
            ->where('is_alive', false)
            ->selectRaw('
                AVG(TIMESTAMPDIFF(DAY, created_at, died_at)) as `died_time`
            ')
            ->first();

        $usersBuyStatistic = User::query()
            ->whereBetween('created_at', [$from, $to])
            ->where('meta_is_buy', true)
            ->selectRaw('
                AVG(TIMESTAMPDIFF(DAY, created_at, first_payment_at)) as `first_payment_time`
            ')
            ->first();

        $statisticDaily = StatisticDay::query()
            ->whereBetween('date', [$from, $to])
            ->selectRaw('
                SUM(registers) as registers,
                AVG(activities) as activities,
                SUM(sells) as sells,
                SUM(sells_new) as sells_new,
                SUM(sells_after_cancel) as sells_after_cancel,
                SUM(sells_continues_first) as sells_continues_first,
                SUM(sells_continues) as sells_continues,
                SUM(cancels) as cancels
            ')
            ->first();

        return $statisticDaily->toArray() + (array)$usersStatistic + $usersAliveStatistic->toArray() + $usersBuyStatistic->toArray();

    }


}
