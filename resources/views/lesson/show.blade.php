@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('lesson', $lesson) }}
    <style>
        iframe .html5-endscreen {
            display: none;
        }
    </style>
    <div class="m-2" id="vue">
        <div class="my-2 text-center text-3xl">
            {{ $lesson->name }}
        </div>
        <div class="panel">
            @admin
            <div class="panel-header flex justify-end">
                <div class="w-32 m-1">
                    <a class="btn" href="{{route('lessons.edit', ['lesson' => $lesson])}}">
                        <i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a class="btn" href="{{route('lessons.destroy', ['lesson' => $lesson])}}">
                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
            </div>
            @endadmin
            <div class="p-3">
                {!! preg_replace('~<a[^>]*>(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s^<]+)</a>~',
                 "<youtube v-bind:id=\"'$1'\"></youtube>", $lesson->content) !!}
            </div>
        </div>
        <div class="panel">
            <div class="my-2 text-center text-xl">
                Комментарии
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
            {{ Form::model(new App\Comment,
['route' => ['comments.store', $lesson], 'method' => 'post', 'class' => ' m-2', 'ref' => "form"]) }}
            <label v-if="parent_id">
                <input disabled v-model="parent_id" name="parent_id" class="hidden">
                ответ на комментарий #<span>@{{ parent_id }}</span>
                <span @click="parent_id = null" class="href"> отменить</span>
            </label>
            <div class="md:flex justify-center">
            {{ Form::textarea('text', null,
['class' => 'border shadow rounded p-2 m-2 w-full', 'placeholder' => 'write a message...', 'rows' => '3',
'@keydown.enter.exact.prevent', '@keyup.enter.exact' => 'submit']) }}
            {{ Form::submit(('отправить'), ['class' => 'text-3xl lg:text-xl px-4 btn h-12 my-auto']) }}
            </div>
            {{ Form::close() }}

            <div class="m-2">
            @include('partials.replies', ['comments' => $lesson->comments, 'level' => 0])
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("load", function () {
            var app = new Vue({
                el: '#vue',
                data() {
                    return {
                        parent_id: null,
                    };
                },
                methods: {
                    submit : function(){
                        this.$refs.form.submit()
                    }
                }
            });
        });
    </script>
@endsection
