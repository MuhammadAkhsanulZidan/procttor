<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{

    public function findUser($id, $email){
        $users = User::select('*')
        ->whereRaw('users.id NOT IN (SELECT user_id FROM project_user WHERE project_user.project_id='.$id .')')
        ->where('users.email', 'LIKE', "%{$email}%")->limit(5)->get();
        //User::select('*')->where('email', 'LIKE', "{$email}%")->orWhere('email', 'LIKE', "{$email}%")->limit(5)->get();
        return response(
            $users
        , 200);
    }

    public function index(Request $request, $id){
        $project = Project::find($id);
        $contributor = $project->users;
        return response([
            'contributor'=>$contributor 
        ], 200);
    }

    public function invite(Request $request, $id){
        $user_ids = $request['ids'];
        foreach($user_ids as $user_id){
        User::find($user_id)->projects()->attach([$id=>['project_role' =>$request["role"]]]);
        }return response([
            'message'=>'user invited'
        ]);
    }

    /*public function invite(Request $request, $id){
        $contributors = $request['contributors'];
        foreach ($contributors as $contributor){
            User::find($contributor["id"])->projects()->attach([$id=>['project_role' =>$contributor["role"]]]);
        } 
    } */
    
    public function update(Request $request, $id){
        User::find($request["userId"])->projects()->updateExistingPivot([$id],['project_role' =>$request["role"]]);
    }

    public function remove(Request $request, $id){
        User::find($request["id"])->projects()->wherePivot('project_id', '=', $id)->detach();
    }
}
