<?php

namespace App\Http\Controllers;

use App\Jobs\TaskCreatedJob;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $projects = Task::with('project')->cursorPaginate(5);

        return response()->json($projects);
    }

}
