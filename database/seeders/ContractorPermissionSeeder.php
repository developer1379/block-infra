<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ContractorPermissionSeeder extends Seeder
{
    public function run()
    {
        // Permissions required for contractors
        $permissions = [
            'view projects',
            'create bids',
            'view bids',   // optional, useful for "My Bids" page
        ];

        // Create permissions if not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Get contractor role
        $contractor = Role::where('name', 'contractor')->first();

        if ($contractor) {
            // Assign only these permissions to contractor
            $contractor->syncPermissions($permissions);
        }
    }
}
