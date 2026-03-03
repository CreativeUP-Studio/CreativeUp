<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'icon', 'is_active'
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}