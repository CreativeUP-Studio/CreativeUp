<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStep extends Model
{
    protected $fillable = [
        'project_id', 'title', 'description', 'order',
        'image1', 'image2', 'image3',
        'image1_device', 'image2_device', 'image3_device',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
