<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MaterialRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    protected $materials;

    public function __construct(MaterialRepositoryInterface $materials)
    {
        $this->materials = $materials;
    }

    public function index()
    {
        try {
            $materials = $this->materials->getAll();
            return view('admin.materials.index', compact('materials'));
        } catch (\Exception $e) {
            Log::error('Admin Material Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load materials.');
        }
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        try {
            $this->materials->create($request->only(['name', 'unit', 'price', 'description']));
            return redirect()->route('admin.materials.index')->with('success', 'Material created successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Material Store Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create material.')->withInput();
        }
    }

    public function edit($id)
    {
        $material = $this->materials->find($id);
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        try {
            $material = \App\Models\Material::findOrFail($id);
            $material->update($request->only(['name', 'unit', 'price', 'description']));
            return redirect()->route('admin.materials.index')->with('success', 'Material updated successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Material Update Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update material.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $material = \App\Models\Material::findOrFail($id);
            $material->delete();
            return redirect()->route('admin.materials.index')->with('success', 'Material deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Material Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete material.');
        }
    }
}
