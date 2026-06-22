<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SiteReportRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SiteReportController extends Controller
{
    protected $reports;
    protected $projects;

    public function __construct(
        SiteReportRepositoryInterface $reports,
        ProjectRepositoryInterface $projects
    ) {
        $this->reports = $reports;
        $this->projects = $projects;
    }

    public function index()
    {
        try {
            $contractor = Auth::user()->contractor;
            $reports = \App\Models\DailySiteReport::where('contractor_id', $contractor->id)->with('project')->latest()->paginate(10);
            return view('contractor.site-reports.index', compact('reports'));
        } catch (\Exception $e) {
            Log::error('Contractor Site Report Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load reports.');
        }
    }

    public function create()
    {
        $contractor = Auth::user()->contractor;
        // Only show projects awarded to this contractor
        $projects = \App\Models\Project::where('contractor_id', $contractor->id)->get();
        $materials = \App\Models\Material::orderBy('name')->get();
        return view('contractor.site-reports.create', compact('projects', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'report_date' => 'required|date',
            'weather_condition' => 'required|string',
            'work_summary' => 'required|string',
            'challenges' => 'nullable|string',
            'next_day_plan' => 'nullable|string',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'photos.*' => 'nullable|image|max:10240',
            'materials' => 'nullable|array',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.milestone_id' => 'nullable|exists:project_milestones,id',
            'materials.*.quantity' => 'required|numeric|min:0.01'
        ]);

        try {
            $contractor = Auth::user()->contractor;
            $data = $request->except('photos');
            $data['contractor_id'] = $contractor->id;

            $report = $this->reports->create($data);

            // Handle Photo Uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('site-reports/photos', 'public');
                    \App\Models\SitePhoto::create([
                        'report_id' => $report->id,
                        'photo_path' => $path
                    ]);
                }
            }

            // Update project current progress
            \App\Models\Project::where('id', $request->project_id)->update([
                'current_progress' => $request->progress_percentage
            ]);

            // Handle Material Consumption Logs
            if ($request->has('materials')) {
                foreach ($request->materials as $mat) {
                    \App\Models\MaterialInventory::create([
                        'project_id' => $request->project_id,
                        'material_id' => $mat['id'],
                        'milestone_id' => $mat['milestone_id'] ?? null,
                        'quantity' => $mat['quantity'],
                        'type' => 'consumption',
                        'entry_date' => $request->report_date,
                        'notes' => 'Logged via Daily Site Report #' . $report->id
                    ]);
                }
            }

            return redirect()->route('contractor.site-reports.index')->with('success', 'Daily site report submitted.');
        } catch (\Exception $e) {
            Log::error('Contractor Site Report Store Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to submit report.')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $contractor = Auth::user()->contractor;
            $report = \App\Models\DailySiteReport::where('contractor_id', $contractor->id)
                ->with(['project', 'photos', 'contractor'])
                ->findOrFail($id);

            return view('contractor.site-reports.show', compact('report'));
        } catch (\Exception $e) {
            Log::error('Contractor Site Report Show Error: ' . $e->getMessage());
            return redirect()->route('contractor.site-reports.index')->with('error', 'Unable to load report details.');
        }
    }
}
