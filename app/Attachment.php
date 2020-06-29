<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['type', 'path'];

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }
}
