<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    public function project_name(): BelongsTo
    {
        return $this->belongsTo(ProjectName::class);
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class,'category_id','project_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class,'project_name_id','id');
    }
}
