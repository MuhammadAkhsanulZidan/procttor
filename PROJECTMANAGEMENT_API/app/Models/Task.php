<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps=false;
    use HasFactory;

    protected $fillable=[
        'activity_id',
        'task_name',
        'task_status'
    ];

    public function activity(){
        return $this->BelongsTo(Activity::class);
    }    
}
