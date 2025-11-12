<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UnitRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class UnitController extends Controller
{
    protected $units;

    public function __construct(UnitRepositoryInterface $units)
    {
        $this->units = $units;
    }

    public function index()
    {
        try {
            $units = $this->units->all();
            return view('admin.pages.units.index', compact('units'));
        } catch (Exception $e) {
            Log::error('Unit Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch unit list.');
        }
    }

    public function create()
    {
        return view('admin.pages.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        try {
            $this->units->create($request->all());
            return redirect()->route('admin.units.index')->with('success', 'Unit created successfully!');
        } catch (Exception $e) {
            Log::error('Unit Store Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create unit.');
        }
    }

    public function edit($id)
    {
        try {
            $unit = $this->units->find($id);
            return view('admin.pages.units.edit', compact('unit'));
        } catch (Exception $e) {
            Log::error('Unit Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load unit details.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        try {
            $this->units->update($id, $request->all());
            return redirect()->route('admin.units.index')->with('success', 'Unit updated successfully!');
        } catch (Exception $e) {
            Log::error('Unit Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update unit.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->units->delete($id);
            return redirect()->route('admin.units.index')->with('success', 'Unit deleted successfully!');
        } catch (Exception $e) {
            Log::error('Unit Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete this unit.');
        }
    }
}
