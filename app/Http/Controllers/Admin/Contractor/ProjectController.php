<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectController extends Controller
{
    protected $projects;

    public function __construct(ProjectRepositoryInterface $projects)
    {
        $this->projects = $projects;
    }

    public function index()
    {
        $projects = $this->projects->getOpenProjects();
        return view('contractor.projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = $this->projects->find($id);
        return view('contractor.projects.show', compact('project'));
    }
}
