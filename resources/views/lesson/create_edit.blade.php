@extends('layouts.default')

@section('content')
    @if ($create)
        {{ Breadcrumbs::render('course', $course) }}
    @else
        {{ Breadcrumbs::render('lesson', $model) }}
        @endif

    <div class=" sm:flex sm:justify-center h-screen p-2 pt-4" id="vue">
        {{ Form::model($model, ['route' => $route, 'method' => 'post']) }}
        {{ Form::text('course_id', (isset($course) ? $course->id : $model->course->id), ['class' => 'hidden']) }}
        {{ Form::label('name', 'Название', ['class' => 'label'])}}
        {{ Form::text('name', null, ['class' => 'input']) }}
        {{ Form::label('description', 'Описание', ['class' => 'label'])}}
        {{ Form::text('description', null, ['class' => 'input']) }}
        {{ Form::label('content', 'содержание', ['class' => 'label'])}}
        <input :value="content" name="content" class="hidden">
        <example-component v-bind:editor-data="content" v-on:update="content = $event"></example-component>
        <br>
        {{ Form::label('is_public', 'Опубликован', ['class' => 'label inline-block']) }}
        {{ Form::checkbox('is_public', ($model->is_public ? $model->is_public : true)) }}
        <div class="flex justify-center m-2">
        {{ Form::submit(($create ? 'Создать' : 'Обновить'), ['class' => 'text-3xl lg:text-xl block px-4 btn']) }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ Form::close() }}
    </div>

    <script>
        window.addEventListener("load", function(){
        var app = new Vue({
            el: '#vue',
            data() {
                return {
                    content: '<?= $model->content?>',
                    output: 'asd'
                };
            },
        });
        });
    </script>
@endsection
