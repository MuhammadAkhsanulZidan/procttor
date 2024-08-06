<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    // public function index($id){
    //     $workspace = Workspace::find($id);
    //     $projects = $workspace->leftJoin('projects', 'workspaces.id', '=', 'projects.workspace_id')
    //     ->select('projects.*', 'workspaces.workspace_name as workspace_name')->get();
    //     return response([
    //         $projects
    //     ], 200);
    // }

    
    public function index($id){
        $project = Project::find($id);
        $activities = $project->activities;
        foreach($activities as $activity){
            $activity['task_done']=$activity->tasks->where('task_status','=','1')->count();
            $activity['task_total']=$activity->tasks->count();
            }
        return response(
            $activities
        , 200);
    }

    public function create(Request $request, $id){
        //$project = Project::find($id);
        $activity = Activity::create([
            'project_id'=>$id,
            'activity_name'=>$request['activity_name'],
            'activity_description'=>$request['activity_description'],
            'activity_plan_startDate'=>$request['activity_plan_startDate'],
            'activity_plan_endDate'=>$request['activity_plan_endDate'],
            'activity_status'=>$request['activity_status']
        ]);

        return response(
           $activity, 200
        );
        //$project->activities()->attach([$activity->id]);
    }

    public function show(Request $request, $id){
        $activity = Activity::find($id);
        $activity['task_done']=$activity->tasks->where('task_status','=','1')->count();
        $activity['task_total']=$activity->tasks->count();
        $activity['tasks'] = $activity->tasks;
        return response(
            $activity
        , 200);
    }

    public function update(Request $request, $id){
        $activity = Activity::find($id);
        if($request->has('activity_status')){
            $activity->update([
                'activity_status' => $request['activity_status'],
                'activity_real_startDate' => $request['activity_real_startDate'],
                'activity_real_endDate' => $request['activity_real_endDate']
            ]);
        }
        if($request->has('activity_url')){
            $activity->update([
                'activity_url' => $request['activity_url']
            ]);
        }
        if($request->has('activity_name')){
            $activity->update([
            'activity_name'=>$request['activity_name'],
            'activity_description'=>$request['activity_description'],
            'activity_plan_startDate'=>$request['activity_plan_startDate'],
            'activity_plan_endDate'=>$request['activity_plan_endDate'],
            'activity_real_startDate' => $request['activity_real_startDate'],
            'activity_real_endDate' => $request['activity_real_endDate'],
            ]);
        }
        return response($activity
        , 200);
    }

    
    public function destroy($id){
        $activity=Activity::find($id);
        $activity->tasks->delete();
        $activity->delete();
        return response([
            'message'=>'Workspace has been deleted'
        ], 200);
    }

}
