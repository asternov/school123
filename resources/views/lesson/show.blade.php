@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('lesson', $lesson) }}
<div class=" m-2">
        <div class="panel w-2/3 block mx-auto my-2">
            <div class="panel-header flex">
                <div class="w-full m-2">
                    <a class="href ml-32" href="{{ route('courses.show', ['course' => $lesson]) }}">{{ $lesson->name }}</a>
                </div>
                <div class="w-32 m-2">
                    <a class="btn" href="{{route('courses.edit', ['course' => $lesson])}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a class="btn" href="{{route('courses.destroy', ['course' => $lesson])}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="p-2">
            {!! $lesson->content !!}
            </div>
        </div>
    </div>
@endsection
