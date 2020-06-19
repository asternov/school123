@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('lesson', $lesson) }}
    <style>
        iframe {
            #pointer-events: none;
        }
    </style>
<div class="m-2" id="vue">
        <div class="panel">
            <div class="panel-header flex">
                <div class="w-full m-1">
                    <a class="href ml-32" href="{{ route('courses.show', ['course' => $lesson]) }}">{{ $lesson->name }}</a>
                </div>
                <div class="w-32 m-1">
                    <a class="btn" href="{{route('lessons.edit', ['lesson' => $lesson])}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a class="btn" href="{{route('lessons.destroy', ['lesson' => $lesson])}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="p-3" >
                {!! preg_replace('~(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s]+)~', "<youtube v-bind:id=\"'$1'\"></youtube>", str_replace('</p>', ' </p>', $lesson->content)) !!}
            </div>
        </div>
    </div>


    <script>
        //v-html="content.replace(youtubeRegExp, youtubePlugin)"
        window.addEventListener("load", function(){
            var app = new Vue({
                el: '#vue',
                data() {
                    return {
                        link: '<?= 'https://www.youtube.com/watch?v=WqUhCy_KIv4'?>',
                        content: '<?= $lesson->content?>',
                    };
                },
                methods: {
                    youtubePlugin() {
                        return 'youtube';
                    }
                }
            });
        });
    </script>
@endsection
