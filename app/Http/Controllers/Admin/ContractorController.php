<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contractor;
use App\Models\ContractorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractorController extends Controller
{
    public function index()
    {
        $contractors = Contractor::orderBy('created_at', 'desc')->get();
        return view('admin.pages.contractors.index', compact('contractors'));
    }

    public function show($id)
    {
        $contractor = Contractor::with(['categoryRelation', 'documents'])->findOrFail($id);

        return view('admin.pages.contractors.show', compact('contractor'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->orderBy('name')->get();
        return view('admin.pages.contractors.create', compact('categories'));
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

        Contractor::create($validated);

        return redirect()->route('admin.contractors.index')->with('success', 'Contractor created successfully.');
    }


    public function edit($id)
    {
        $contractor = Contractor::with('documents')->findOrFail($id);
        return view('admin.pages.contractors.edit', compact('contractor'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'company_name'  => 'nullable|string|max:255',
            'email'         => 'nullable|email',
            'phone'         => 'nullable|string|max:20',
            'city'          => 'nullable|string|max:255',
            'categories'     => 'nullable|array',
            'categories.*'   => 'exists:categories,id',

            'is_active'     => 'boolean',
        ]);

        $contractor = Contractor::findOrFail($id);

        $contractor->update([
            'name'         => $validated['name'],
            'company_name' => $validated['company_name'] ?? null,
            'email'        => $validated['email'] ?? null,
            'phone'        => $validated['phone'] ?? null,
            'city'         => $validated['city'] ?? null,
            'is_active'    => $validated['is_active'] ?? 0,
        ]);

        if ($request->filled('categories')) {
            $contractor->categories()->sync($request->categories);
        } else {
            $contractor->categories()->sync([]);
        }

        return redirect()
            ->route('admin.contractors.index')
            ->with('success', 'Contractor updated successfully with categories.');
    }



    public function destroy(Contractor $contractor)
    {
        $contractor->delete();
        return back()->with('success', 'Contractor deleted successfully.');
    }

    // 🔄 Toggle Active/Inactive
    public function toggleStatus($id)
    {
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
    }

    public function verify($id)
    {
        $document = ContractorDocument::findOrFail($id);
        $document->update(['is_verified' => true]);

        return back()->with('success', 'Document verified successfully.');
    }
}
