<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function index(){
        $user = auth()->user();
        $workspaces = $user->workspaces;
        foreach($workspaces as $workspace){
         $workspace['user_role'] = $workspace['pivot']['workspace_role'];
        }
        return response(
            $workspaces 
        , 200);
    }

    public function create(Request $request){
        $user = auth()->user();
        $workspace = Workspace::create([
            'workspace_name' => $request['workspace_name'],
            'workspace_description' => $request['workspace_description'],
//            'workspace_image'=>$request['workspace_image']
        ]);
        $user->workspaces()->attach([$workspace->id=>['workspace_role'=>$request['workspace_role']]]);                            
        $workspace['workspace_role']=$request['workspace_role'];
        return response(
            $workspace
            //'workspace_role'=>$request['workspace_role'] 
        , 200);
    }
    
    public function show(Request $request, $id){
        $workspace=Workspace::find($id);
        $workspace['user_role'] = auth()->user()->workspaces()->where('workspace_id','=',$id)->first()['pivot']['workspace_role'];
        $workspace['users'] = $workspace->leftJoin('user_workspace', 'user_workspace.workspace_id', '=', 'workspaces.id')
        ->leftJoin('users','user_workspace.user_id', '=', 'users.id')
        ->select('users.*', 'user_workspace.workspace_role as role')->where('workspaces.id',$id)->get();
        return response(
            $workspace    
        , 200);
    }

    public function update(Request $request, $id){
        $workspace=Workspace::find($id);
        $workspace->update([
            'workspace_name' => $request['workspace_name'],
            'workspace_description' => $request['workspace_description'],
        ]);
        return response(
            $workspace
        , 200);
    }

    public function destroy($id){
        $user = auth()->user();
        $user->workspaces()->wherePivot('workspace_id', '=', $id)->detach();
        $workspace=Workspace::find($id);
        //$workspace->projects->activities->delete;
        $workspace->delete();
        return response([
            'message'=>'Workspace has been deleted'
        ], 200);
    }




}
