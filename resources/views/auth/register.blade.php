@extends('layouts.default')

@section('sidebar-content-right')
    <a href="/passwords/reset"><button type="submit" class="btn">
            Восстановить пароль
        </button> </a>
@endsection

@section('content')
    <div class="flex justify-center h-screen pt-4">
        {{ Form::open(['route' => 'register']) }}
        {{ Form::label('name', 'Имя', ['class' => 'label']) }}
        {{ Form::text('name', null, ['class' => 'input']) }}
        {{ Form::label('email', 'E-Mail адрес', ['class' => 'label']) }}
        {{ Form::email('email', null, ['class' => 'input']) }}
        {{ Form::label('password', 'Пароль', ['class' => 'label']) }}
        {{ Form::input('password', 'password', null, ['class' =>'input']) }}
        {{ Form::label('password_confirmation', 'Пароль еще раз', ['class' => 'label']) }}
        {{ Form::input('password', 'password_confirmation',  null, ['class' => 'input']) }}
        <div class="flex justify-center m-2">
        {{ Form::submit('Зарегистрироваться', ['class' => 'btn']) }}
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
