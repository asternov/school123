<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Http\Controllers\Controller;
use App\JSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CourseController extends Controller
{
    public function index(Request $request) {
        $models = Course::all();
        return Jsend::success($models);
    }

    public function show(Request $request, Course $course) {
        return Jsend::success($course);
    }
}
