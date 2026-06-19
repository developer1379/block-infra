<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contractor;
use App\Models\ContractorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ContractorController extends Controller
{
    public function index()
    {
        try {
            $contractors = Contractor::orderBy('created_at', 'desc')->get();
            return view('admin.contractors.index', compact('contractors'));
        } catch (Exception $e) {
            Log::error('Contractor Index Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load contractors list.');
        }
    }

    public function show($id)
    {
        try {
            $contractor = Contractor::with(['categoryRelation', 'documents'])->findOrFail($id);
            return view('admin.contractors.show', compact('contractor'));
        } catch (Exception $e) {
            Log::error('Contractor Show Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load contractor details.');
        }
    }

    public function create()
    {
        try {
            $categories = Category::where('is_active', 1)->orderBy('name')->get();
            return view('admin.contractors.create', compact('categories'));
        } catch (Exception $e) {
            Log::error('Contractor Create Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load contractor creation form.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        try {
            Contractor::create($validated);
            return redirect()->route('admin.contractors.index')->with('success', 'Contractor created successfully.');
        } catch (Exception $e) {
            Log::error('Contractor Store Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create contractor.');
        }
    }


    public function edit($id)
    {
        try {
            $contractor = Contractor::with('documents')->findOrFail($id);
            return view('admin.contractors.edit', compact('contractor'));
        } catch (Exception $e) {
            Log::error('Contractor Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load contractor for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        $contractor = Contractor::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'company_name'  => 'nullable|string|max:255',
            'email'         => 'nullable|email|unique:users,email,' . ($contractor->user_id ?? 'NULL') . ',id',
            'phone'         => 'nullable|string|max:20',
            'city'          => 'nullable|string|max:255',
            'categories'     => 'nullable|array',
            'categories.*'   => 'exists:categories,id',
            'is_active'     => 'boolean',
            'password'      => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $contractor->update([
                'name'         => $validated['name'],
                'company_name' => $validated['company_name'] ?? null,
                'email'        => $validated['email'] ?? null,
                'phone'        => $validated['phone'] ?? null,
                'city'         => $validated['city'] ?? null,
                'is_active'    => $validated['is_active'] ?? 0,
            ]);

            // Also update the associated User if it exists
            if ($contractor->user) {
                $userData = [
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                ];
                if (!empty($validated['password'])) {
                    $userData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
                }
                $contractor->user->update($userData);
            }

            if ($request->filled('categories')) {
                $contractor->categories()->sync($request->categories);
            } else {
                $contractor->categories()->sync([]);
            }

            return redirect()
                ->route('admin.contractors.index')
                ->with('success', 'Contractor updated successfully.');
        } catch (Exception $e) {
            Log::error('Contractor Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update contractor.');
        }
    }

    public function destroy(Contractor $contractor)
    {
        try {
            $contractor->delete();
            return back()->with('success', 'Contractor deleted successfully.');
        } catch (Exception $e) {
            Log::error('Contractor Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete contractor.');
        }
    }

    // 🔄 Toggle Active/Inactive
    public function toggleStatus($id)
    {
        try {
            $contractor = Contractor::findOrFail($id);
            $contractor->is_active = !$contractor->is_active;
            $contractor->save();

            Log::info('🔁 Contractor status changed', [
                'contractor_id' => $contractor->id,
                'new_status' => $contractor->is_active,
            ]);

            return response()->json([
                'success' => true,
                'status' => $contractor->is_active ? 'active' : 'inactive'
            ]);
        } catch (Exception $e) {
            Log::error('Contractor Toggle Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to toggle status.'], 500);
        }
    }

    public function verify($id)
    {
        try {
            $document = ContractorDocument::findOrFail($id);
            $document->update(['is_verified' => true]);
            return back()->with('success', 'Document verified successfully.');
        } catch (Exception $e) {
            Log::error('Document Verify Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to verify document.');
        }
    }
}

