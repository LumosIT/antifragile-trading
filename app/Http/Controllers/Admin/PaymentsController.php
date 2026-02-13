<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $payments = Payment::query()->with('user');

        $paginator = new ModernPerfectPaginator($payments);
        $paginator->enabledDateFilter();
        $paginator->setSearchPreparator(function(string $search) {
            return ltrim($search, '@');
        });
        $paginator->setAllowedSearchColumns([
            'user' => ['name', 'username'],
            'hash'
        ]);
        $paginator->setAllowedSortColumns([
            'id',
            'amount',
            'created_at'
        ]);

        return $paginator->build($request)->map(function ($payment) {
            return AdminPrepare::payment($payment);
        });

    }

}
