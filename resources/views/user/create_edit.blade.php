@extends('layouts.default')

@section('content')
    <div class=" flex justify-center h-screen pt-4" id="vue">
        {{ Form::model($user, ['route' => $route, 'method' => 'post']) }}
        {{ Form::label('name', 'Имя', ['class' => 'text-3xl lg:text-xl block text-gray-700 font-bold mb-2'])}}
        {{ Form::text('name', null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4']) }}
        {{ Form::label('email', 'E-Mail адрес', ['class' => 'text-3xl lg:text-xl block text-gray-700 font-bold mb-2']) }}
        {{ Form::email('email', null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-4 leading-tight focus:outline-none focus:shadow-outline']) }}
        {{ Form::label('password', 'Пароль', ['class' => ' text-3xl lg:text-xl block text-gray-700 font-bold mb-2']) }}
        {{ Form::button('Изменить Пароль', ['class' => ($create ? '' : '') . ' pswd-btn text-3xl lg:text-xl block btn', 'v-on:click' => 'isHidden = !isHidden', 'v-if'=>'!isHidden']) }}
        {{ Form::password('password', ['class' => ($create ? '' : '') . ' pswd-fld shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-4 leading-tight focus:outline-none focus:shadow-outline', 'v-if'=>'isHidden']) }}
       {{ Form::label('is_admin', 'Админ', ['class' => 'text-3xl block lg:text-xl text-gray-700 font-bold mb-2']) }}
        {{ Form::checkbox('is_admin', ($user->is_admin ? true : null)) }}
        {{ Form::submit(($create ? 'Создать' : 'Обновить'), ['class' => 'text-3xl lg:text-xl block px-4 btn']) }}

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
    <script>
        new Vue({
            el: '#vue',
            data: {
                name: 'Vue.js',
                isHidden: <?php echo ($create ? 1 : 0)?>
            },
        })
    </script>
@endsection
