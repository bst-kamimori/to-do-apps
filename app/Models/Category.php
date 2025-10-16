<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function project_names()
    {
        return $this->belongsTo(Projects_Name::class);
    }

    public function operations()
    {
        return $this->hasOne(Operation::class);
    }
}
