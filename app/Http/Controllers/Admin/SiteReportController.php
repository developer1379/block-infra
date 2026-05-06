<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SiteReportRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SiteReportController extends Controller
{
    protected $reports;

    public function __construct(SiteReportRepositoryInterface $reports)
    {
        $this->reports = $reports;
    }

    public function index()
    {
        try {
            $reports = $this->reports->getAll();
            return view('admin.site-reports.index', compact('reports'));
        } catch (\Exception $e) {
            Log::error('Admin Site Report Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load site reports.');
        }
    }

    public function show($id)
    {
        try {
            $report = $this->reports->find($id);
            return view('admin.site-reports.show', compact('report'));
        } catch (\Exception $e) {
            return back()->with('error', 'Report not found.');
        }
    }

    public function create() { return abort(404); }
    public function store(Request $request) { return abort(404); }
    public function edit($id) { return abort(404); }
    public function update(Request $request, $id) { return abort(404); }
    public function destroy($id) { return abort(404); }
}
