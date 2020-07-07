<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Course;
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => '',
            'content' => '',
            'course_id' => '',
            'is_public' => '',
        ]);

        $model = new Lesson;
        $model->name = $validatedData['name'];
        $model->description = $validatedData['description'];
        $model->content = $validatedData['content'];
        $model->course_id = $validatedData['course_id'];
        $model->is_public = isset($validatedData['is_public']);
        $model->save();


        if ($model->is_public) {
            foreach ($model->course->users as $student) {
                //$model->notifyNewLesson($student);
                Mail::to($student->email)->send(new NewLesson());
            }
        }

        return redirect('lessons/' . $model->id);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => '',
            'content' => '',
            'is_public' => '',
        ]);

        $lesson->name = $validatedData['name'];
        $lesson->description = $validatedData['description'];
        $lesson->content = $validatedData['content'];
        $lesson->is_public = isset($validatedData['is_public']);
        $lesson->save();

        return redirect('lessons/' . $lesson->id);
    }

    public function destroy(Lesson $lesson)
    {
        $course_id = $lesson->course->id;
        $lesson->delete();

        return redirect('courses/' . $course_id);
    }
}
