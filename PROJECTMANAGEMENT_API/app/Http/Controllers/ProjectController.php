<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($id){
//        $userId = auth()->user()->id;
        $workspace = Workspace::find($id);
        $projects = $workspace->projects;
        //$projects = $user->projects;
        if($projects->count()>0){
            $index=0;
            foreach($projects as $project){
                                
                $isAssigned = auth()->user()->projects()->where('project_id','=',$project->id)->count();
                if($isAssigned>0){
                    $project['user_role']=auth()->user()->projects()->where('project_id','=',$project->id)->first()['pivot']['project_role'];
                    $project['activity_done']=$project->activities->where('activity_status', '1')->count();
                    $project['activity_total']=$project->activities->count();    
                }
                else{
                    unset($projects[$index]);
                }
                $index++;
            }
        }
        return response(
            $projects
        , 200);
    }
 
    public function create(Request $request, $id){
        $user = auth()->user();
        $project = Project::create([
            'workspace_id'=>$id,
            'project_name' => $request['project_name'],
            'project_description' => $request['project_description'],
            'project_plan_startDate'=> $request['project_plan_startDate'],
            'project_plan_endDate'=> $request['project_plan_endDate'],
            'project_status'=>$request['project_status']
        ]);
        $user->projects()->attach([$project->id=>['project_role'=>$request['project_role']]]);                            
        
        return response(
            $project
            //'project_role'=>$request['project_role']
        , 200);
    }

    public function show(Request $request, $id){
        $project = auth()->user()->projects()->where('project_id','=',$id)->first();
        $project['user_role'] = $project['pivot']['project_role'];
        $project['users']=$project->leftJoin('project_user', 'project_user.project_id', '=', 'projects.id')
        ->leftJoin('users','project_user.user_id', '=', 'users.id')
        ->select('users.*', 'project_user.project_role as role')->where('projects.id',$id)->get();
        $project['activity_done']=$project->activities->where('activity_status', 'Done')->count();
        $project['activity_total']=$project->activities->count();
        //$activities = $project->activities;
        return response(
            $project,
            //'activities'=>$activities
         200);
    }

    public function update(Request $request, $id){
        $project=Project::find($id);
        if($request->has('project_status')){
            $project->update([
                'project_status' => $request['project_status'],
                'project_real_startDate' => $request['project_real_startDate'],
                'project_real_endDate' => $request['project_real_endDate'],
            ]);
        }
        if($request->has('project_name')){
            $project->update([
                'project_name' => $request['project_name'],
                'project_description' => $request['project_description'],
                'project_plan_startDate' => $request['project_plan_startDate'],
                'project_plan_endDate' => $request['project_plan_endDate'],
                'project_real_startDate' => $request['project_real_startDate'],
                'project_real_endDate' => $request['project_real_endDate'],
            ]);
        }
        return response($project 
        , 200);
    }

    public function destroy($id){
        $user = auth()->user();
        $user->projects()->wherePivot('project_id', '=', $id)->detach();
        $project=Project::find($id);
        $project->activities->tasks->delete();
        $project->activities->delete();
        $project->delete();
        return response([
            'message'=>'Project has been deleted'
        ], 200);
    }
}
