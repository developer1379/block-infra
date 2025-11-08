<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();

        return view('admin.pages.roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('admin.pages.roles.create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:100', 'regex:/^[A-Za-z0-9 _-]+$/', 'unique:roles,name'],
            'permissions'  => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        DB::beginTransaction();
        try {
            Log::info('🟢 Creating new role', [
                'role_name' => $validated['name'],
                'permissions_selected' => $validated['permissions'] ?? [],
            ]);

            $role = Role::create(['name' => trim($validated['name'])]);
            $role->syncPermissions($validated['permissions'] ?? []);

            DB::commit();

            Log::info('✅ Role created successfully', [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'permissions_assigned' => $role->permissions->pluck('name')->toArray(),
            ]);

            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('❌ Failed to create role', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Failed to create role.');
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $assigned    = $role->permissions()->pluck('id')->toArray();

        return view('admin.pages.roles.edit', [
            'role'        => $role,
            'permissions' => $permissions,
            'assigned'    => $assigned,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        try {
            \Log::info('🟡 Updating role', [
                'role_id' => $role->id,
                'old_name' => $role->name,
                'new_name' => $validated['name'],
                'incoming_permissions' => $validated['permissions'] ?? [],
            ]);

            $role->update([
                'name' => trim($validated['name']),
                'guard_name' => 'web', // ensure consistency
            ]);

            // Convert IDs → Names before syncing
            $permissions = Permission::whereIn('id', $validated['permissions'] ?? [])
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($permissions);

            \Log::info('✅ Role updated successfully', [
                'role_id' => $role->id,
                'final_permissions' => $role->permissions->pluck('name')->toArray(),
            ]);

            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Throwable $e) {
            \Log::error('❌ Failed to update role', [
                'role_id' => $role->id,
                'error_message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Failed to update role. ' . $e->getMessage());
        }
    }


    public function destroy(Role $role)
    {
        try {
            Log::warning('🗑️ Deleting role', [
                'role_id' => $role->id,
                'role_name' => $role->name,
            ]);

            $role->delete();

            Log::info('✅ Role deleted successfully', [
                'role_id' => $role->id,
                'role_name' => $role->name,
            ]);

            return back()->with('success', 'Role deleted.');
        } catch (\Throwable $e) {
            Log::error('❌ Failed to delete role', [
                'role_id' => $role->id,
                'error_message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Failed to delete role.');
        }
    }
}
