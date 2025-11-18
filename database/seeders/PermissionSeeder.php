<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // All system permissions
        $permissions = [

            // Project Permissions
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',

            // Bid Permissions
            'view bids',
            'create bids',
            'edit bids',
            'delete bids',
            'award bids',

            // Contractors (optional)
            'view contractors',
            'create contractors',
            'edit contractors',
            'delete contractors',
        ];

        // Create permissions if not exists
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Assign ALL permissions to admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Get ALL permissions from DB
        $allPermissions = Permission::pluck('name')->toArray();

        // Sync all permissions to admin role
        $admin->syncPermissions($allPermissions);
    }
}
