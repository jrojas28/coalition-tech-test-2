<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

class TaskController extends Controller
{
    public function index() {
        $data = [
            'projects' => Project::all(),
            'tasks' => Task::query()->orderBy('priority')->get(),
        ];
        return view('tasks.form', $data);
    }

    public function api__store(Request $request) {
        $lastPriorityTask = Task::query()->orderBy('priority')->get()->last();
        if(!isset($lastPriorityTask))
            $request['priority'] = 1;
        else 
            $request['priority'] = $lastPriorityTask->priority + 1;
        if($request->has('project_id')) {
            $project = Project::find($request['project_id']);
            if(isset($project) && count($project->tasks) > 0) {
                $lastProjectPriorityTask = $project->tasks()->orderBy('project_priority')->get()->last();
                $request['project_priority'] = isset($lastProjectPriorityTask->project_priority) ? $lastProjectPriorityTask->project_priority + 1 : 1;
            }
            else {
                $request['project_priority'] = 1;
            }
        }
        $task = Task::create($request->all());
        return response()->json($task);
    }

    public function api__update(Request $request) {
        $priority = 1;
        $priorities = [1];
        if($request['project'] == 0) {
            foreach($request['ids'] as $id) {
                $task = Task::find($id);
                $task->update(['priority' => $priority]);
                $priority++;
                $priorities[] = $priority;
            }
        }
        //Otherwise, we're talking about project priority.
        else {
            foreach($request['ids'] as $id) {
                $task = Task::find($id);
                $task->update(['project_priority' => $priority]);
                $priority++;
                $priorities[] = $priority;
            }
        }
        return response()->json($priorities);
    }

    public function api__tasks() {
        return response()->json(Task::query()->orderBy('priority')->get()->toArray());
    }
}
