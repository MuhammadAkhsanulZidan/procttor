<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        return response([
            //'posts'=> Project::orderBy('created_at', 'desc')->width();
        ],200);
    }
}
