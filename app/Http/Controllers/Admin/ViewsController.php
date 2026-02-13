<?php

namespace App\Http\Controllers\Admin;

use App\Consts\PostTypes;
use App\Models\Admin;
use App\Models\Option;
use App\Models\Post;
use App\Models\Promocode;
use App\Models\Role;
use App\Models\Tariff;
use App\Models\Text;
use App\Models\TextGroup;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ViewsController extends Controller
{

    public function login() : View
    {
        return view('admin.pages.auth.login');
    }

    public function profile() : View
    {
        return view('admin.pages.profile.index', [
            'admin' => $this->admin()
        ]);
    }

    public function roles() : View
    {
        return view('admin.pages.roles.index');
    }

    public function rolesEdit(Role $role) : View
    {
        return view('admin.pages.roles.form', [
            'role' => $role
        ]);
    }

    public function rolesCreate() : View
    {
        return view('admin.pages.roles.form');
    }

    public function admins() : View
    {
        return view('admin.pages.admins.index', [
            'roles' => Role::query()->orderBy('name')->get()
        ]);
    }

    public function adminsEdit(Admin $admin) : View
    {
        return view('admin.pages.admins.form', [
            'admin' => $admin,
            'roles' => Role::query()->orderBy('name')->get()
        ]);
    }

    public function adminsCreate() : View
    {
        return view('admin.pages.admins.form', [
            'roles' => Role::query()->orderBy('name')->get()
        ]);
    }

    public function users() : View
    {
        return view('admin.pages.users.index', [
            'tariffs' => Tariff::query()->orderBy('name')->get()
        ]);
    }

    public function usersEdit(User $user) : View
    {
        return view('admin.pages.users.info', [
            'user' => $user,
            'tariffs' => Tariff::query()->active()->orderBy('price')->get()
        ]);
    }

    public function tariffs() : View
    {
        return view('admin.pages.tariffs.index');
    }

    public function tariffsCreate() : View
    {
        return view('admin.pages.tariffs.form', []);
    }

    public function tariffsEdit(Tariff $tariff) : View
    {
        return view('admin.pages.tariffs.form', [
            'tariff' => $tariff
        ]);
    }


    public function promocodes()
    {
        return view('admin.pages.promocodes.index');
    }

    public function promocodesCreate()
    {
        return view('admin.pages.promocodes.form', [
            'tariffs' => Tariff::query()->orderBy('name')->get()
        ]);
    }

    public function promocodesEdit(Promocode $promocode)
    {
        return view('admin.pages.promocodes.form', [
            'promocode' => $promocode,
            'tariffs' => Tariff::query()->orderBy('name')->get()
        ]);
    }

    public function payments()
    {
        return view('admin.pages.payments.index');
    }

    public function texts()
    {
        return view('admin.pages.texts.form', [
            'textGroups' => TextGroup::query()->orderBy('name')->get(),
            'texts' => Text::query()->orderBy('index', 'asc')->get()
        ]);
    }

    public function options()
    {
        return view('admin.pages.options.form', [
            'options' => Option::query()->orderBy('id')->get()
        ]);
    }

    public function mailing()
    {
        return view('admin.pages.mailing.index', [
            'tariffs' => Tariff::query()
                ->orderBy('name')
                ->get()
        ]);
    }

    public function mailingCreate()
    {
        return view('admin.pages.mailing.form', [
            'without_tariff_count' => User::query()
                ->whereNull('tariff_id')
                ->count(),
            'tariffs' => Tariff::query()
                ->withCount('users')
                ->orderBy('name')
                ->get(),
            'stages_count' => User::query()
                ->whereNotNull('stage')
                ->selectRaw('count(id) as `count`, `stage`')
                ->groupBy('stage')
                ->get()
                ->pluck('count', 'stage')
        ]);
    }

    public function statistic()
    {
        return view('admin.pages.statistic.statistic');
    }

    public function posts(Request $request, string $type)
    {

        $types = [
            PostTypes::FIRST_STAIR => 'Первая ступень',
            PostTypes::SECOND_STAIR => 'Вторая ступень',
            PostTypes::THIRD_STAIR => 'Третья ступень'
        ];

        if(!array_key_exists($type, $types)){
            return abort(404);
        }

        return view('admin.pages.posts.form', [
            'type' => $type,
            'allTypes' => $types,
            'posts' => Post::query()
                ->where('type', $type)
                ->orderBy('index', 'asc')
                ->with('file')
                ->get()
        ]);
    }

}
