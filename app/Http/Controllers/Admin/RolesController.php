<?php

namespace App\Http\Controllers\Admin;

use App\Consts\Permissions;
use App\Models\Role;
use App\Utilits\Api\ApiError;
use App\Utilits\Prepare\AdminPrepare;
use App\Utilits\TableGenerator\Modern\ModernPerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{

    public function list(Request $request) : PerfectPaginatorResponse
    {

        $paginator = new ModernPerfectPaginator(
            Role::query()
        );

        $paginator->setAllowedSortColumns(['id']);

        return $paginator->build($request)->map(function(Role $role) {
            return AdminPrepare::role($role);
        });

    }

    protected function validateData(Request $request) : array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'string', 'min:1', Rule::in(array_values(Permissions::getAll()))],
        ], [
            'permissions.required' => 'Вы не указали права',
            'permissions.*.min' => 'Вы не указали права'
        ]);
    }

    public function create(Request $request) : array
    {

        $data = $this->validateData($request);

        $role = Role::create([
            'name' => $data['name'],
            'permissions' => $data['permissions']
        ]);

        return AdminPrepare::role($role);

    }

    public function edit(Request $request, Role $role) : array
    {

        $data = $this->validateData($request);

        $role->name = $data['name'];
        $role->permissions = $data['permissions'];
        $role->save();

        return AdminPrepare::role($role);

    }

    public function remove(Request $request, Role $role) : void
    {

        if($role->admins()->first()){
            throw new ApiError('Вы пытаетесь удалить роль, у которой есть сотрудники');
        }

        $role->delete();

    }

}
