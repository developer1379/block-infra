<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class WorkController extends Controller
{
    protected $works, $categories, $units;

    public function __construct(
        WorkRepositoryInterface $works,
        CategoryRepositoryInterface $categories,
        UnitRepositoryInterface $units
    ) {
        $this->works = $works;
        $this->categories = $categories;
        $this->units = $units;
    }

    public function index()
    {
        try {
            $works = $this->works->all();
            return view('admin.works.index', compact('works'));
        } catch (Exception $e) {
            Log::error('Work Index Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load works list.');
        }
    }

    public function create()
    {
        $categories = $this->categories->getParentOptions();
        $units = $this->units->all();
        return view('admin.works.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'labor_cost' => 'nullable|numeric',
            'material_cost' => 'nullable|numeric',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'boolean',
        ]);

        try {
            $this->works->create($request->all());
            return redirect()->route('admin.works.index')->with('success', 'Work added successfully!');
        } catch (Exception $e) {
            Log::error('Work Store Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save work record.');
        }
    }

    public function edit($id)
    {
        try {
            $work = $this->works->find($id);
            $categories = $this->categories->getParentOptions();
            $units = $this->units->all();

            return view('admin.works.edit', compact('work', 'categories', 'units'));
        } catch (Exception $e) {
            Log::error('Work Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch work details.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'labor_cost' => 'nullable|numeric',
            'material_cost' => 'nullable|numeric',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'boolean',
        ]);

        try {
            $this->works->update($id, $request->all());
            return redirect()->route('admin.works.index')->with('success', 'Work updated successfully!');
        } catch (Exception $e) {
            Log::error('Work Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update work record.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->works->delete($id);
            return redirect()->route('admin.works.index')->with('success', 'Work deleted successfully!');
        } catch (Exception $e) {
            Log::error('Work Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete this work.');
        }
    }
}

