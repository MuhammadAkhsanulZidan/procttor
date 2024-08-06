<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\User;

class WorkspaceMemberController extends Controller
{
    public function findUser($id, $email){
        $users = User::select('*')
        ->whereRaw('users.id NOT IN (SELECT user_id FROM user_workspace WHERE user_workspace.workspace_id='.$id .')')
        ->where('users.email', 'LIKE', "%{$email}%")->limit(5)->get();
        //User::select('*')->where('email', 'LIKE', "{$email}%")->orWhere('email', 'LIKE', "{$email}%")->limit(5)->get();
        return response(
            $users
        , 200);
    }

    public function invite(Request $request, $id){
        $user_ids = $request['ids'];
        foreach($user_ids as $user_id){
        User::find($user_id)->workspaces()->attach([$id=>['workspace_role' =>$request["role"]]]);
        return response([
            'message'=>'user invited', 200
        ]);
    }}

    /*public function invite(Request $request, $id){
        $contributors = $request['contributors'];
        foreach ($contributors as $contributor){
            User::find($contributor["id"])->projects()->attach([$id=>['project_role' =>$contributor["role"]]]);
        } 
    } */
    
    public function update(Request $request, $id){
        User::find($request["userId"])->workspaces()->updateExistingPivot([$id],['workspace_role' =>$request["role"]]);
    }

    public function remove(Request $request, $id){
        User::find($request["id"])->workspaces()->wherePivot('workspace_id', '=', $id)->detach();
    }

}
