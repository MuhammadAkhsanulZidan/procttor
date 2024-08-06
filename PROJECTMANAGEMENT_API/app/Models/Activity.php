<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $timestamps=false;
    use HasFactory;

    protected $fillable=[
        'project_id',
        'activity_name',
        'activity_description',
        'activity_url',
        'activity_plan_startDate',
        'activity_plan_endDate',
        'activity_real_startDate',
        'activity_real_endDate',
        'activity_status'
    ];

    public function tasks(){
        return $this->HasMany(Task::class);
    }

    public function project(){
        return $this->BelongsTo(Project::class);
    }

}
