<?php

namespace App\Models;

use App\Models\User;
use App\Models\Activity;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    public $timestamps=false;
    use HasFactory;

    protected $fillable=[
        'workspace_id',
        'project_name',
        'project_description',
        'project_image',
        'project_plan_startDate',
        'project_plan_endDate',
        'project_real_startDate',
        'project_real_endDate',
        'project_status'
    ];

    /*
    The user that belong to the project
    */

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('project_role');
    }

    public function workspace(){
        return $this->belongsTo(Workspace::class);
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }


}
