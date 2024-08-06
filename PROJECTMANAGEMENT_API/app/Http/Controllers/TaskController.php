<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Activity;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($id){
        $activity = Activity::find($id);
        $tasks = $activity->tasks;
        return response(
            $tasks
        , 200);
    }

    public function create(Request $request, $id){
        $task = Task::create([
            'activity_id'=>$id,
            'task_name'=>$request['task_name'],
            'task_status'=>'0'
        ]);
        return response($task
        , 200);
        //$activity->tasks()->attach([$task->id]);
    }

    public function show(Request $request, $id){
        $task = Task::find($id);
        return response(
            $task
        , 200);
    }

    public function update(Request $request, $id){
        $task = Task::find($id);
        if($request->has('task_status')){
            $task->update([
                'task_status' => $request['task_status']
            ]);
        }
        if($request->has('task_name')){
        $task->update([
            'task_name' => $request['task_name']
        ]);
        }
        return response([
            $task
        ], 200);
    }

    public function destroy($id){
        $task=Task::find($id);
        $task->delete();
        return response([
            'message'=>'Workspace has been deleted'
        ], 200);
    }
}
