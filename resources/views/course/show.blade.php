@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('course', $course) }}
        <div class="text-center text-3xl">
            {{ $course->name }}
        </div>
        @foreach($course->lessons as $model)
            @if($model->is_public || isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'])
            <div class="panel">
                <div class="panel-header flex">
                    <div class="w-full m-1">
                        <a class="href @admin ml-32 @endadmin"
                           href="{{ route('lessons.show', ['lesson' => $model]) }}">{{ $model->name }}</a>
                    </div>

                    @admin
                    @if(!$model->is_public)
                        <i class="fa fa-eye-slash mt-2" aria-hidden="true"></i>
                    @endif
                        <div class="w-32 m-1">
                            <a class="btn" href="{{route('lessons.edit', ['lesson' => $model])}}"><i class="fa fa-edit"
                                                                                                     aria-hidden="true"></i></a>
                            <a class="btn" href="{{route('lessons.destroy', ['lesson' => $model])}}"><i
                                    class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    @endadmin
                </div>

                @if(strlen($model->description))
                <div class="p-3">
                    {!!   $model->description !!}
                </div>
                    @endif
            </div>
            @endif
        @endforeach

    @admin
        <div class="flex">
            <a class="ml-auto mr-auto btn" href="{{route('lessons.create', ['course' => $course])}}">Создать урок</a>
        </div>
    @endadmin
@endsection
