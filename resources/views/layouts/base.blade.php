<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="antialiased">
        <div class="container mx-auto">
            <div id="app">
                @yield('content')
            </div>
        </div>
    </body>
</html>
