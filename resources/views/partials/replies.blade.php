@foreach($comments as $comment)
    <div class="flex">
        <div class="mt-8 flex">
            @for ($i = 0; $i < $level; $i++)
                |<fa icon="line" class="m-1"></fa>
                @endfor
        </div>
        <div class="w-full">
        <div class="flex justify-between">
            <div>{{ $comment->user->name }}: </div>
            <div>{{ $comment->created_at }} <span class="href" @click="parent_id = '{{ $comment->id }}'">ответить</span></div>
        </div>
        <div class="bg-gray-300 rounded p-2">
            {!! str_replace("\n", '<br>', $comment->text) !!}
        </div>
        </div>
    </div>
    @include('partials.replies', ['comments' => $comment->replies, 'level' => $level+1])
@endforeach
