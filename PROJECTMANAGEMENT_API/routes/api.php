<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\WorkspaceMemberController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//public routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']],function(){

    //user
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //workspace
    Route::get('/workspaces', [WorkspaceController::class, 'index']);
    Route::post('/workspaces', [WorkspaceController::class, 'create']);
    Route::get('/workspaces/{id}', [WorkspaceController::class, 'show']); //show a project
    Route::put('/workspaces/{id}', [WorkspaceController::class, 'update']); //update a project
    Route::delete('/workspaces/{id}', [WorkspaceController::class, 'destroy']); // delete a projects

    //Workspace member
    Route::get('workspaces/{id}/findusers/{email}', [WorkspaceMemberController::class, 'findUser']);
    Route::post('/workspaces/{id}/workspacemembers', [WorkspaceMemberController::class, 'invite']);
    Route::put('/workspaces/{id}/workspacemembers', [WorkspaceMemberController::class, 'update']);
    Route::delete('/workspaces/{id}/workspacemembers', [WorkspaceMemberController::class, 'remove']);

    //project
    Route::get('/workspaces/{id}/projects', [ProjectController::class, 'index']);
    Route::post('/workspaces/{id}/projects', [ProjectController::class, 'create']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']); //show a project
    Route::put('/projects/{id}', [ProjectController::class, 'update']); //update a project
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']); // delete a project

    //project member
    Route::get('/projects/{id}/findusers/{email}', [ProjectMemberController::class, 'findUser']);
    Route::get('/projects/{id}/projectmembers', [ProjectMemberController::class, 'index']);
    Route::post('/projects/{id}/projectmembers', [ProjectMemberController::class, 'invite']);
    Route::put('/projects/{id}/projectmembers', [ProjectMemberController::class, 'update']);
    Route::delete('/projects/{id}/projectmembers', [ProjectMemberController::class, 'remove']);

    //activity
    Route::get('/projects/{id}/activities', [ActivityController::class, 'index']); //get all activities
    Route::post('/projects/{id}/activities', [ActivityController::class, 'create']); //create activity
    Route::get('/activities/{id}', [ActivityController::class, 'show']); //get single activity
    Route::put('/activities/{id}', [ActivityController::class, 'update']); //update single activity
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy']); // delete a projects

    //task
    Route::get('/activities/{id}/tasks', [TaskController::class, 'index']); //get all tasks
    Route::post('/activities/{id}/tasks', [TaskController::class, 'create']); //create a task
    Route::get('/tasks/{id}', [TaskController::class, 'show']); //get single task
    Route::put('/tasks/{id}', [TaskController::class, 'update']); //update a task
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // delete a task*/

});