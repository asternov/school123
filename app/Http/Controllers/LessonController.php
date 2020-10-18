<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Course;
use App\Http\Requests\LessonRequest;
use App\Lesson;
use App\Mail\NewLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Integer;

class LessonController extends Controller
{
    public function index(Request $request) {
        $models = Lesson::all();
        return view('lesson.index', compact('models'));
    }

    public function show(Request $request, Lesson $lesson) {
        return view('lesson.show', compact('lesson'));
    }

    public function create(Request $request, Course $course)
    {
        $model = new Lesson;
        $route = ['lessons.store'];
        $create = true;
        return view('lesson.create_edit')->with(compact('model', 'route', 'create', 'course'));
    }

    public function edit(Request $request, Lesson $lesson)
    {
        $model = $lesson;
        $route = ['lessons.update', $lesson->id];
        $create = false;
        return view('lesson.create_edit')->with(compact('model', 'route', 'create'), ['user'=> Auth::user()]);
    }

    public function store(LessonRequest $request)
    {
        $model = new Lesson($request->validated());
        $model->save();

        if ($model->is_public) {
            foreach ($model->course->users as $student) {
                Mail::to($student->email)->send(new NewLesson());
            }
        }

        return redirect('lessons/' . $model->id);
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return redirect('lessons/' . $lesson->id);
    }

    public function destroy(Lesson $lesson)
    {
        $course_id = $lesson->course->id;
        $lesson->delete();

        return redirect('courses/' . $course_id);
    }
}
