<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProjectPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create module-specific permissions (optional)
        $permissions = [
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',

            'view bids',
            'award bids',
        ];

        // Create the permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {

            // Get ALL permissions in the system
            $allPermissions = Permission::pluck('id')->toArray();

            // Assign ALL permissions to admin
            $adminRole->syncPermissions($allPermissions);
        }
    }
}
