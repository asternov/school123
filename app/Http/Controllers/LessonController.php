<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);

        $model = new Lesson;
        $model->setAttribute('name',  $validatedData['name']);
        $model->setAttribute('description',  $validatedData['description']);
        $model->setAttribute('content',  $validatedData['content']);
        $model->setAttribute('course_id',  $validatedData['course_id']);
        $model->save();

        return redirect('courses/' . $model->course_id);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => '',
            'content' => '',
        ]);

        $lesson->setAttribute('name',  $validatedData['name']);
        $lesson->setAttribute('description',  $validatedData['description']);
        $lesson->setAttribute('content',  $validatedData['content']);
        $lesson->save();

        return redirect('courses/' . $lesson->course->id);
    }

    public function destroy(Lesson $lesson)
    {
        $course_id = $lesson->course->id;
        $lesson->delete();

        return redirect('courses/' . $course_id);
    }
}
