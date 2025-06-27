<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Leonix') }}</title>

        <!-- Fonts: Space Grotesk -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Space Grotesk', sans-serif; }
        </style>
    </head>
    <body class="bg-gradient-to-br from-gray-900 via-indigo-900 to-gray-800 min-h-screen text-white">
        <div class="min-h-screen flex flex-col justify-center items-center">
            <!-- Slot untuk konten utama (form register/login) -->
            {{ $slot }}
        </div>
    </body>
</html>
