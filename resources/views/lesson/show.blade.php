@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('lesson', $lesson) }}
    <style>
        iframe {
            #pointer-events: none;
        }
    </style>
    <div class="m-2" id="vue">
        <div class="my-2 text-center text-3xl">
            {{ $lesson->name }}
        </div>
        <div class="panel">
            @if ($_COOKIE['is_admin'])
                <div class="panel-header flex justify-end">
                    <div class="w-32 m-1">
                        <a class="btn" href="{{route('lessons.edit', ['lesson' => $lesson])}}">
                            <i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a class="btn" href="{{route('lessons.destroy', ['lesson' => $lesson])}}">
                            <i class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                </div>
            @endif
            <div class="p-3">
                {!! preg_replace('~(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s^<]+)~',
                 "<youtube v-bind:id=\"'$1'\"></youtube>", $lesson->content) !!}
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("load", function () {
            var app = new Vue({
                el: '#vue',
                data() {
                    return {};
                },
                methods: {}
            });
        });
    </script>
@endsection
