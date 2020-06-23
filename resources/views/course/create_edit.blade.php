@extends('layouts.default')

@section('content')
    <div class=" flex justify-center h-screen pt-4" id="vue">
        {{ Form::model($model, ['route' => $route, 'method' => 'post']) }}
        {{ Form::label('name', 'Название', ['class' => 'label'])}}
        {{ Form::text('name', null, ['class' => 'input']) }}
        {{ Form::label('description', 'Описание', ['class' => 'label'])}}
        {{ Form::text('description', null, ['class' => 'input']) }}
        <br>
        {{ Form::label('is_public', 'Опубликован', ['class' => 'label inline-block']) }}
        {{ Form::checkbox('is_public', ($model->is_public ? $model->is_public : true)) }}

        {{ Form::label('', 'Список участников:', ['class' => 'label']) }}
        @foreach(\App\User::all() as $user)
            <label class="label inline-block mx-2"> {{ $user->name }}
                {{ Form::checkbox('users[]', $user->id, $model->users->contains($user))}}
            </label>
        @endforeach

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
@endsection
