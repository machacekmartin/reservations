<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Test page</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @filamentStyles
    </head>

    <body class="antialiased">
        {{ $slot }}

        @filamentScripts
    </body>
</html>
