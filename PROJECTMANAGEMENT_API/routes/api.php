<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
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
    Route::post('/logout', [AuthController::class, 'logout']);
    
    //project
    /*
    Route::get('/projects', [ProjectController::class, 'index']); //get all projects
    Route::get('/projects', [ProjectController::class, 'store']); //create project
    Route::get('/projects/{id}', [ProjectController::class, 'show']); //get single project
    Route::get('/projects/{id}', [ProjectController::class, 'update']); //update a project
    Route::get('/projects/{id}', [ProjectController::class, 'destroy']); // delete a projects

    //activity
    Route::get('/activities', [ProjectController::class, 'index']); //get all activities
    Route::get('/activities', [ProjectController::class, 'store']); //create activity
    Route::get('/activities/{id}', [ProjectController::class, 'show']); //get single activity
    Route::get('/activities/{id}', [ProjectController::class, 'update']); //update an activity
    Route::get('/activities/{id}', [ProjectController::class, 'destroy']); // delete an activity

    //task
    Route::get('/tasks', [ProjectController::class, 'index']); //get all tasks
    Route::get('/tasks', [ProjectController::class, 'store']); //create a task
    Route::get('/tasks/{id}', [ProjectController::class, 'show']); //get single task
    Route::get('/tasks/{id}', [ProjectController::class, 'update']); //update a task
    Route::get('/tasks/{id}', [ProjectController::class, 'destroy']); // delete a task*/

});