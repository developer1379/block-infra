<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('admin.pages.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.pages.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name',
        ]);

        try {
            Permission::create(['name' => trim($validated['name'])]);
            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission created successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to create permission.');
        }
    }

    public function edit(Permission $permission)
    {
        return view('admin.pages.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'required','string','max:100',
                Rule::unique('permissions','name')->ignore($permission->id)
            ],
        ]);

        try {
            $permission->update(['name' => trim($validated['name'])]);
            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission updated successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to update permission.');
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return back()->with('success', 'Permission deleted.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to delete permission.');
        }
    }
}
