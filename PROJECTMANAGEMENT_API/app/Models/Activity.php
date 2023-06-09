<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'project_id',
        'activity_name',
        'activity_url',
        'activity_plan_startDate',
        'activity_plan_endDate',
        'activity_real_startDate',
        'activity_real_startDate',
        'activity_status'
    ];

    /*
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }*/
}
