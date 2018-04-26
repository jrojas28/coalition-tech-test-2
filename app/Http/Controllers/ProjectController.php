<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Task;

class ProjectController extends Controller
{
    public function index() {
        $data = [
            'projects' => Project::all(),
        ];
        return view('projects.form', $data);
    }

    public function api__store(Request $request) {
        $project = Project::create($request->all());
        return response()->json($project);
    }

    public function api__tasks(Project $project) {
        return response()->json($project->tasks()->orderBy('project_priority')->get()->toArray());
    }
}
