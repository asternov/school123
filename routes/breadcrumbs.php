<?php


// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная страница', route('/'));
});

Breadcrumbs::for('courses', function ($trail) {
    $trail->parent('home');
    $trail->push('Курсы', route('courses'));
});

Breadcrumbs::for('course', function ($trail, $course) {
    $trail->parent('courses');
    $trail->push($course->name, route('courses.show', $course));
});

Breadcrumbs::for('course.edit', function ($trail, $course) {
    $trail->parent('course', $course);
    $trail->push('редактирование', route('courses', $course));
});

Breadcrumbs::for('course.create', function ($trail) {
    $trail->parent('course');
    $trail->push('Создание', route('users'));
});

Breadcrumbs::for('lesson', function ($trail, $lesson) {
    $trail->parent('course', $lesson->course);
    $trail->push($lesson->name, route('lessons.show', $lesson));
});

Breadcrumbs::for('lesson.edit', function ($trail, $lesson) {
    $trail->parent('lesson', $lesson);
    $trail->push('редактирование', route('lessons', $lesson));
});

Breadcrumbs::for('lesson.create', function ($trail) {
    $trail->parent('lesson');
    $trail->push('Создание', route('users'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Пользователи', route('users'));
});

Breadcrumbs::for('user', function ($trail, $user) {
    $trail->parent('users');
    $trail->push($user->name, route('users'));
});

Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('user', $user);
    $trail->push('редактирование', route('users', $user));
});

Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users');
    $trail->push('Создание', route('users'));
});
