<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectName extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'project_names';
    use HasFactory;

    /**
     * @return HasMany
     */
    public function cagetories(): HasMany
    {
        return $this->hasMany(Category::class, 'project_name_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_name_id', 'id');
    }


}
