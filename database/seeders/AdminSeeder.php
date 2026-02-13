<?php

namespace Database\Seeders;

use App\Consts\Permissions;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create([
            'name' => 'Администратор',
            'permissions' => array_values(Permissions::getAll())
        ]);

        Admin::create([
            'login' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => $role->id
        ]);

    }
}
