<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    public function index()
    {
        return view('admin.pages.actions.index');
    }

    public function data(Request $request)
    {
        $query = Action::query()->with('client');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from,
                $request->date_to
            ]);
        }

        if ($request->filled('user_search')) {
            $search = $request->input('user_search');

            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('name_2', 'like', "%{$search}%")
                ->orWhere('username_2', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        }

        $total = $query->count();

        $actions = $query
            ->with(['client', 'client.tariff'])
            ->orderBy('id', 'desc')
            ->skip($request->start)
            ->take($request->length)
            ->get();

        $data = $actions->map(function ($item) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'action' => $item->action,
                'channel' => $item->channel,
                'created_at' => $item->created_at->format('d.m.Y H:i'),
                'user_info' => $item->client ? (
                    $item->client->type == 'telegram' 
                        ? $item->client->name . ' (' . $item->client->username . ') | ' 
                        . $item->client->name_2 . ' (' . $item->client->username_2 . ')' 
                        : $item->client->name_2 . ' (' . $item->client->username_2 . ') | ' 
                        . $item->client->name . ' (' . $item->client->username . ')'
                ) : '—',
                'tariff_info' => $item->client->tariff ? (
                    ($item->client->tariff ? $item->client->tariff->name : '—') 
                    . '<br> Истекает: ' 
                    . ($item->client->tariff_expired_at ? $item->client->tariff_expired_at->format('d.m.Y') : '—')
                ) : '—',
            ];
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => Action::count(),
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }
}