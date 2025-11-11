<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectName extends Model
{
    protected $table = 'project_names';
    use HasFactory;

    public function cagetories(): HasMany
    {
        return $this->hasMany(Category::class, 'project_name_id', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_name_id', 'id');
    }


}
