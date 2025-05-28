<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ipChat</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
        <style>
            [v-cloak] {
                display: none;
            }
        </style>
        @stack('styles')
    </head>
    <body>
        <nav class="bg-dark navbar">
            <a href="{{ route('dashboard') }}">
                <h4 class="text-light">ipChat</h4>
            </a>
            <div>
                <a href="{{ route('user_logout') }}" class="btn btn-light btn-sm px-3 font-weight-bold">Logout</a>
            </div>
        </nav>
        <div>
            @yield('user-content')
        </div>
    </body>
    <script src="{{ asset('assets/js/vue.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    @stack('scripts')
</html>
