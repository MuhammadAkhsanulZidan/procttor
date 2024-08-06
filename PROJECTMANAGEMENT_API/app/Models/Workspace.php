<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace extends Model
{
    public $timestamps=false;
    use HasFactory;

    protected $fillable=[
        'workspace_name',
        'workspace_description',
        'workspace_image',
    ];

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('workspace_role');
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
