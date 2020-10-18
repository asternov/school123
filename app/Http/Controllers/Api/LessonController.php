<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Course;
use App\JSend;
use App\Lesson;
use App\Mail\NewLesson;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Integer;

class LessonController extends Controller
{
    public function index(Request $request) {
        $models = Lesson::all();
        return JSend::success($models);
    }

    public function show(Request $request, Lesson $lesson) {
        return JSend::success($lesson);
    }
}
