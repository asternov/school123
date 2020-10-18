<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    protected $fillable = [
        'text' => 'required',
        'parent_id' => '',
        'user_id' => '',
    ];

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->addMinutes(auth()->user()->timezone_utc)->format('Y-m-d H:i');
    }
}
