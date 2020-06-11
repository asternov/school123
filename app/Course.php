<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
