<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project_Name extends Model
{
    public function project_names()
    {
        return $this->hasOne(Category::class);
    }
    protected $table = 'project_names';

}
