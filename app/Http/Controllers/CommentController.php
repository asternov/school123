<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Lesson;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Lesson $lesson)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $lesson->comments()->create($data);
        return redirect('lessons/' . $lesson->id);
    }
}
