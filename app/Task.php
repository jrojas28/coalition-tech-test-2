<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'priority',
        'name',
        'project_id',
        'project_priority',
    ];

    protected $appends = [
        'project_name',
    ];

    public function project() {
       return $this->belongsTo('App\Project');
    }

    public function getProjectNameAttribute() {
        return isset($this->project) ? $this->project->name : "None";
    }
}
