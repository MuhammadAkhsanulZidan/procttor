<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'project_id',
        'activity_id',
        'task_id',
        'task_name',
        'task_status'
    ];

    /*
    public function user(){
        return $this->belongsTo(User::class);
    }*/
    
}
