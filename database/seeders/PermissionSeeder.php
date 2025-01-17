<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Roles

        $role_admin = Role::updateOrCreate(
            [
                'name' => 'admin',
            ],
            ['name' => 'admin']
        );
        $role_writer = Role::updateOrCreate(
            [
                'name' => 'writer',
            ],
            ['name' => 'writer']
        );
        $role_guest = Role::updateOrCreate(
            [
                'name' => 'guest',
            ],
            ['name' => 'guest']
        );

        // Membuat Permission

        $permission_dashboard = Permission::updateOrCreate(
            [
                'name' => 'view_dashboard',
            ],
            ['name' => 'view_dashboard']
        );

        $permission_chart = Permission::updateOrCreate(
            [
                'name' => 'view_chart_on_dashboard',
            ],
            ['name' => 'view_chart_on_dashboard']
        );

        // add permission roles
        $role_admin->givePermissionTo($permission_dashboard);
        $role_admin->givePermissionTo($permission_chart);

        $role_writer->givePermissionTo($permission_chart);

        // add role to user
        $user_admin = User::find(1);
        $user_writer = User::find(34);

        $user_admin->assignRole(['admin']);
        $user_writer->assignRole(['writer']);

        # example 2 roles
        // $user_admin->assignRole(['admin', 'writer']);
    }
}
