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

Breadcrumbs::for('lesson', function ($trail, $lesson) {
    $trail->parent('course', $lesson->course);
    $trail->push($lesson->name, route('lessons.show', $lesson));
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
