<?php

namespace App\Http\Controllers;

use App\Jobs\TaskCreatedJob;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function loadView(){
        return view('projects');
    }

    public function index()
    {
        $projects = Project::withCount('tasks')->cursorPaginate(5);

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return response()->json($project);
    }

    public function addTask(Request $request, Project $project)
    {
        $task = $project->tasks()->create($request->all());
        dispatch(new TaskCreatedJob($task->load(['assignedUser', 'project'])));
        return response()->json($task);
    }

    public function getProjectTasks($projectId)
    {
        $tasks = Task::with('assignedUser')->where('project_id', $projectId)->get();
        return response()->json($tasks ?? []);
    }

    public function show(Project $project)
    {
        return response()->json(
            $project->load(['tasks'])
        );
    }
    public function destroy(Project $project)
    {

        $project->delete();

        return response()->json("Project deleted");
    }

    public function getUsers(){
        return response()->json(User::select('id','name')->where('role', 'user')->get());
    }



}
