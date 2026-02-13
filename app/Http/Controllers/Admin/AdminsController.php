<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $data = $request->validate([
            'role_id' => ['nullable', 'integer', 'exists:roles,id']
        ]);

        $role_id = Arr::get($data, 'role_id') ?: null;

        $admins = Admin::query()->with('role');

        if($role_id){
            $admins->where('role_id', $role_id);
        }

        $paginator = new ModernPerfectPaginator($admins);

        $paginator->setAllowedSortColumns(['id']);
        $paginator->setAllowedSearchColumns(['id', 'login']);

        return $paginator->build($request)->map(function(Admin $admin) {
            return AdminPrepare::admin($admin);
        });

    }

    public function create(Request $request) : array
    {

        $data = $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:admins,login'],
            'password' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ], [
            'login.unique' => 'Данный логин уже занят',
            'role_id.exists' => 'Роль не найдена'
        ]);

        $admin = Admin::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id']
        ]);

        return AdminPrepare::admin($admin);

    }

    public function edit(Request $request, Admin $admin) : array
    {

        $data = $request->validate([
            'password' => ['nullable', 'string', 'max:255'],
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ], [
            'role_id.exists' => 'Роль не найдена'
        ]);

        $password = Arr::get($data, 'password') ?: null;

        if($password){
            $admin->password = Hash::make($password);
        }

        $admin->role_id = $data['role_id'];
        $admin->save();

        return AdminPrepare::admin($admin);

    }

    public function remove(Request $request, Admin $admin) : void
    {

        $admin->delete();

    }

    public function removeTwoFactory(Admin $admin) : void
    {

        $admin->tfa_secret = null;
        $admin->save();

    }

}
