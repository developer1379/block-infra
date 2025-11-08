<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Projects
            'project.create', 'project.view', 'project.edit', 'project.delete',
            'project.assign_manager', 'project.change_status',

            // Contractors
            'contractor.create', 'contractor.view', 'contractor.edit', 'contractor.delete', 'contractor.assign_project',

            // Materials
            'material.create', 'material.view', 'material.edit', 'material.delete',
            'material.issue', 'material.purchase', 'material.return',

            // Workers & Attendance
            'worker.create', 'worker.view', 'worker.edit', 'worker.delete',
            'attendance.mark', 'attendance.view', 'attendance.edit',

            // Payroll & Finance
            'payroll.generate', 'payroll.view', 'payroll.approve',
            'invoice.create', 'invoice.view', 'invoice.edit', 'invoice.delete',
            'payment.record', 'payment.view',

            // Tasks
            'task.create', 'task.view', 'task.edit', 'task.delete', 'task.update_status',

            // Reports
            'report.view_project', 'report.view_finance', 'report.view_inventory', 'report.export',

            // Users & Roles
            'user.create', 'user.view', 'user.edit', 'user.delete',
            'role.create', 'role.view', 'role.edit', 'role.delete',
            'permission.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
    }
}
