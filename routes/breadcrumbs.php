<?php


// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});


// Home > Courses
Breadcrumbs::for('courses', function ($trail) {
    $trail->parent('home');
    $trail->push('Курсы', route('courses'));
});

// Home > Blog > [Category]
Breadcrumbs::for('course', function ($trail, $course) {
    $trail->parent('courses');
    $trail->push($course->name, route('courses.show', ['course' => $course]));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('lesson', function ($trail, $lesson) {
    $trail->parent('course', $lesson->course);
    $trail->push($lesson->name, route('lessons.show', ['lesson' => $lesson->id]));
});
