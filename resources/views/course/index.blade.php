@extends('layouts.default')

@section('content')
    {{ Breadcrumbs::render('courses') }}
    <div class=" text-center text-3xl">
        Список курсов
    </div>
    @foreach($models as $model)
        @if($model->is_public || isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'])
        <div class="panel">
            <div class="panel-header flex">
                <div class="w-full m-1">
                    @member($model)
                    <a class="href @admin ml-32 @endadmin"
                       href="{{ route('courses.show', ['course' => $model]) }}">{{ $model->name }}</a>
                    @else
                        @admin
                        <a class="href ml-32"
                           href="{{ route('courses.show', ['course' => $model]) }}">{{ $model->name }}</a>
                        @else
                            <span>{{ $model->name }}</span>
                            @endadmin
                            @endmember
                </div>
                @admin
                @if(!$model->is_public)
                <i class="fa fa-eye-slash mt-2" aria-hidden="true"></i>
                @endif
                <div class="w-32 m-1">
                    <a class="btn" href="{{route('courses.edit', ['course' => $model])}}">
                        <i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a class="btn" href="{{route('courses.destroy', ['course' => $model])}}">
                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
                @endadmin
            </div>
            <div class="p-3">
                {{ $model->description }}
            </div>
            @member($model)
            @else
                <hr>
                <div class="p-3">
                    для записи на курс свяжитесь с Татьяной Терновской +7 912 78 03 897
                </div>
                @endmember
        </div>
        @endif
    @endforeach

    @admin
    <div class="flex">
        <a class="ml-auto mr-auto btn" href="{{route('courses.create')}}">Создать курс</a>
    </div>
    @endadmin
@endsection
