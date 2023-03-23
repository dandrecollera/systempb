<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', env('WEB_TITLE'))</title>

    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"></link>

    @yield('styles')
</head>
<body>
    <header>
        @include('template.header')
    </header>
    <div style="padding-top:10px">
        @yield('content')
    </div>
</body>
</html>