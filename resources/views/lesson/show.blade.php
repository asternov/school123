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
                {!! preg_replace('~(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s^<]+)~',
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
['route' => ['comments.store', $lesson], 'method' => 'post', 'class' => 'flex justify-center mr-2', 'ref' => "form"]) }}
            {{ Form::textarea('text', null,
['class' => 'border shadow rounded p-2 m-2 w-full', 'placeholder' => 'write a message...', 'rows' => '3',
'@keydown.enter.exact.prevent', '@keyup.enter.exact' => 'submit']) }}
            {{ Form::submit(('отправить'), ['class' => 'text-3xl lg:text-xl px-4 btn h-12 my-auto']) }}
            {{ Form::close() }}

            @foreach($lesson->comments as $comment)
                <div class="m-2  ">
                    <div class="flex justify-between">
                    <div>{{ $comment->user->name }}:</div>
                    <div>{{ $comment->created_at }}</div>
                    </div>
                    <div class="bg-gray-300 rounded p-2">
                        {!! str_replace("\n", '<br>', $comment->text) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        window.addEventListener("load", function () {
            var app = new Vue({
                el: '#vue',
                data() {
                    return {};
                },
                methods: {
                    submit : function(){
                        this.$refs.form.submit()
                    }
                }
            });
        });
    </script>

    <script>
        var playerFrame = document.currentScript.previousElementSibling.children[0].children[0];

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player(playerFrame, {
                videoId: 'M7lc1UVf-VE',
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.ENDED) {
                document.getElementById("playerWrap").classList.add("shown");
            }
        }

        document.getElementById("playerWrap").addEventListener("click", function() {
            player.seekTo(0);
            document.getElementById("playerWrap").classList.remove("shown");
        });
    </script>
@endsection
