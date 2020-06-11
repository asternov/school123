@extends('layouts.default')

@section('content')
    <div class="input-group hidden flex mb-4 px-2">
        <form method="get"  class="ml-auto mr-auto">
            <input class="form-control shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="search"
                   value="{{ request()->session()->get('search') }}"
                   placeholder="Поиск по имени или email" name="search"
                   type="text" id="search"/>
            <div class="inline-block relative w-64">
                <select name="isConfirmed" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="-1">Подтвержденность</option>
                    <option value="1" {{ request()->session()->get('isConfirmed') == 1 ? 'selected' : '' }}>Да</option>
                    <option value="0" {{ request()->session()->get('isConfirmed') == 0 ? 'selected' : '' }}>Нет</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
            <button type="submit" class="btn btn-warning bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                Искать
            </button>
            <div class="input-group-btn ">

            </div>
        </form>
    </div>
    <div>
    <table class="table-auto mb-4 ml-auto mr-auto table ">
        <thead>
        <tr>
            <th class="px-4 py-2">Id</th>
            <th class="px-4 py-2">Имя</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Админ</th>
            <th class="px-4 py-2">Создан</th>
            <th class="px-4 py-2">Обновлен</th>
            <th class="px-4 py-2">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="border">
                <td class=" px-4 py-2">{{ $user->getAttribute('id') }}</td>
                <td class=" px-4 py-2">{{ $user->getAttribute('name') }}</td>
                <td class=" px-4 py-2">{{ $user->getAttribute('email') }}</td>
                <td class=" px-4 py-2">{{ $user->getAttribute('is_admin') }}</td>
                <td class=" px-4 py-2">{{ $user->getAttribute('created_at')->format('Y-m-d') }}</td>
                <td class=" px-4 py-2">{{ $user->getAttribute('updated_at')->format('Y-m-d') }}</td>
                <td class=" px-4 py-2">{!! '<a  class="btn" href="' . route('users.edit', ['id' => $user->getAttribute('id')])  . '"><i class="fa fa-edit" aria-hidden="true"></i></a>' .
                 '<a  class="btn" href="' . route('users.destroy', ['id' => $user->getAttribute('id')]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>' !!}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <nav class="flex mb-4">
        <ul class="pagination justify-content-end ml-auto mr-auto">
        </ul>
    </nav>
    <div class="flex ">
        <a  class="ml-auto mr-auto btn shadow" href="{{route('users.create')}}">Создать пользователя</a>
    </div>
@endsection
