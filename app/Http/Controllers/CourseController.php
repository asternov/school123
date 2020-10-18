<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CourseController extends Controller
{
    public function index(Request $request) {
        $models = Course::all();
        return view('course.index', compact('models'));
    }

    public function show(Request $request, Course $course) {
        return view('course.show', compact('course'));
    }

    public function create(Request $request)
    {
        $model = new Course;
        $route = ['courses.store'];
        $create = true;
        return view('course.create_edit')->with(compact('model', 'route', 'create'), ['user'=> Auth::user()]);
    }

    public function edit(Request $request, Course $course)
    {
        $model = $course;
        $route = ['courses.update', $course->id];
        $create = false;
        return view('course.create_edit')->with(compact('model', 'route', 'create'), ['user'=> Auth::user()]);
    }

    public function store(CourseRequest $request)
    {
        $course = new Course($request->validated());
        $course->save();
        $course->users()->attach($request->post('users'));

        return redirect('courses');
    }

    public function update(CourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        $course->users()->detach();
        $course->users()->attach($request->post('users'));

        return redirect('courses');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect('courses');
    }
}
