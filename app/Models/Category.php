<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    public function project_name(): BelongsTo
    {
        return $this->belongsTo(Project_Name::class);
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class,'category_id','project_id');
    }
}
