<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project_Name extends Model
{
    protected $table = 'project_names';

    public function cagetories(): HasMany
    {
        return $this->hasMany(Category::class, 'project_name_id', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_name_id', 'id');
    }


}
