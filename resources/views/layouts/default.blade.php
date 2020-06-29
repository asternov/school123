<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon"/>

</head>

<body class="background-color">
<div class="h-full min-h-screen background-color">

    <nav id="header" class="flex items-center justify-between flex-wrap blue p-4 header-color">
        <div class="block sm:hidden">
            <button onclick="document.getElementById('collapsable').classList.toggle('smmax:hidden')"
                    class="btn-white">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>
                        Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                </svg>
            </button>
        </div>
        <div class="smmax:hidden w-full block  justify-between sm:flex items-center" id="collapsable">
            <div class="smmax:inline-block">
                <a href="{{ route('/') }}" class="text-2xl text-white">MMB</a>
            </div>

            @if (Auth::check())
                <div class="text-sm smmax:pt-1 smmax:inline-block ml-12">
                    @admin
                    <a href="{{ route('courses') }}" class="btn-white">
                        Курсы
                    </a>
                    <a href="{{ route('users') }}" class="btn-white mx-2">
                        Пользователи
                    </a>
                    @endadmin
                </div>
            @endif
            @if (Auth::check())
                <div class="flex smmax:pt-3">
                    @if(Auth::user()->is_admin)
                    <label class="label inline-block m-2 text-black"> Админ
                        <input @admin checked @endadmin @click="admin" type="checkbox">
                    </label>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn-white">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            @else
                <div class="flex">
                    <a href="/auth/forgot_password" class="btn-white mx-2 hidden">
                        Forgot password
                    </a>
                    <a href="{{ route('register') }}" class="btn-white">
                        Регистрация
                    </a>
                    <a href="{{ route('login') }}" class="btn-white mx-2">
                        Вход
                    </a>
                </div>
            @endif
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</div>
<notifications group="foo" :classes="'mt-2 mr-2 notification'"/>
</body>
</html>

<script>
    window.addEventListener("load", function () {
        window.headerApp = new Vue({
            el: '#header',
            data() {
                return {
                };
            },
            methods: {
                setCookie(name, value, days) {
                    var expires = "";
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                        expires = "; expires=" + date.toUTCString();
                    }
                    document.cookie = name + "=" + (value || "") + expires + "; path=/";
                },
                getCookie(name) {
                    var nameEQ = name + "=";
                    var ca = document.cookie.split(';');
                    for (var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                    }
                    return null;
                },
                admin() {
                    this.setCookie('is_admin', !this.getCookie('is_admin'), 30)
                    window.location.reload(true);
                }
            },
            mounted() {
            }
        });
    });
</script>
