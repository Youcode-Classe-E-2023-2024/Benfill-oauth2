<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $roles = [
        'admin',
    ];

    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'update-user-role',
        'delete-user'
    ];

    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($this->roles as $role) {
            Role::create(['name' => $role]);
        }

        Role::findByName('admin')->givePermissionTo($this->permissions);
    }
}
