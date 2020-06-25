<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function course()
    {
        return $this->belongsTo('App\Course');
    }


    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');;
    }
}
