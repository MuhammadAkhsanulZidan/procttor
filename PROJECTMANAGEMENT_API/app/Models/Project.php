<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Activity;

class Project extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'project_name',
        'project_image',
        'project_plan_startDate',
        'project_plan_endDate',
        'project_real_startDate',
        'project_real_startDate',
        'project_status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /*
    public function activities(){
        return $this->hasMany(Activity::class);
    }
    */


}
