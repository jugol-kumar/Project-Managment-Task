<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::post('/projects/{project}/tasks', [ProjectController::class, 'addTask']);
    Route::get('/projects/{project}/tasks', [ProjectController::class, 'getProjectTasks']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);
    Route::get('/users', [ProjectController::class, 'getUsers']);

    Route::get('/user-tasks', [TaskController::class, 'index']);
});
