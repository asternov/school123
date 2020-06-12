@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('courses') }}
<div class="m-2">
    @foreach($models as $model)
        <div class="panel">
            <div class="panel-header flex">
                <div class="w-full m-1">
                <a class="href ml-32" href="{{ route('courses.show', ['course' => $model]) }}">{{ $model->name }}</a>
                </div>
                    <div class="w-32 m-1">
                <a class="btn" href="{{route('courses.edit', ['course' => $model])}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                <a class="btn" href="{{route('courses.destroy', ['course' => $model])}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </div>
            </div>
            <div class="p-3">
            {{ $model->description }}
            </div>
        </div>
    @endforeach
    </div>
    <div class="flex">
        <a  class="ml-auto mr-auto btn" href="{{route('courses.create')}}">Создать курс</a>
    </div>
@endsection
