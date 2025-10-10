<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Profiler\Profile;

class Project_Name extends Model
{
    public function category()
    {
        return $this->hasOne(Profile::class);
    }
}
