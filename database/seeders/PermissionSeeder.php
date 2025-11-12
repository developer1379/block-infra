<?php

// database/seeders/PermissionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Categories
            'view categories', 'create categories', 'edit categories', 'delete categories',

            // Works
            'view works', 'create works', 'edit works', 'delete works',

            // Units
            'view units', 'create units', 'edit units', 'delete units',

            // Contractors
            'view contractors', 'create contractors', 'edit contractors', 'delete contractors',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo($permissions);
    }
}
