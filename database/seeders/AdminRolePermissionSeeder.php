<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::findByName('admin', 'web');

        $permissions = [
            'view contractors',
            'create contractors',
            'edit contractors',
            'toggle contractor status',
        ];

        foreach ($permissions as $perm) {
            Permission::findOrCreate($perm, 'web');
        }

        $role->syncPermissions($permissions);
    }
}
