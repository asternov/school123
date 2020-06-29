<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mailgun\Mailgun;

class Lesson extends Model
{
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->whereNull('parent_id')->orderBy('id', 'desc');
    }

    public function attachments()
    {
        return $this->hasMany('App\Attachment');
    }

    public function notifyNewLesson (User $student) {
        $subject = 'Новый урок открыт в курсе' . $this->course->name;
        $text = 'на платфоме MakeMeBeauty School в курсе ' . $this->course->name . ' открылся новый урок ' . $this->name
            . "\n открыть урок " . route('lessons.show', $this);

        $this->sendEmail($student->email, $subject, $text);
    }

    public function sendEmail ($to, $subject, $text) {

        $domain = 'asternov.ru';
        $mg = Mailgun::create(env('MAILGUN_API_KEY'), 'https://api.mailgun.net/v3/' . $domain);
        $mg->messages()->send(''.$domain, [
            'from' => 'MakeMeBeauty School <hello@' . $domain . '>',
            'to' => $to,
            'subject' => $subject,
            'text' => $text,
        ]);
    }
}
