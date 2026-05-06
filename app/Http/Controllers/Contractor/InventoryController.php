<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialInventory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index()
    {
        try {
            $contractor = Auth::user()->contractor;
            
            // Get all projects awarded to this contractor
            $projects = Project::where('contractor_id', $contractor->id)->get();
            $projectIds = $projects->pluck('id')->toArray();

            // Get recent inventory logs for these projects
            $inventoryLogs = MaterialInventory::with(['project', 'material'])
                ->whereIn('project_id', $projectIds)
                ->latest('entry_date')
                ->paginate(15);

            // Get materials for the dropdown
            $materials = Material::orderBy('name')->get();

            return view('contractor.inventory.index', compact('projects', 'inventoryLogs', 'materials'));
        } catch (\Exception $e) {
            Log::error('Contractor Inventory Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load material logs.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0.01',
            'type' => 'required|in:purchase,consumption,adjustment',
            'unit_price' => 'nullable|numeric|min:0',
            'vendor_name' => 'nullable|string|max:255',
            'entry_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        try {
            $contractor = Auth::user()->contractor;
            
            // Verify project belongs to contractor
            $project = Project::where('id', $request->project_id)
                ->where('contractor_id', $contractor->id)
                ->firstOrFail();

            MaterialInventory::create($request->all());

            return redirect()->route('contractor.inventory.index')->with('success', 'Material log added successfully.');
        } catch (\Exception $e) {
            Log::error('Contractor Inventory Store Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to save material log.')->withInput();
        }
    }
}
