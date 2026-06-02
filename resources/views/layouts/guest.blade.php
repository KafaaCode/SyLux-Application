<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Frip Trading') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
        
        <!-- Custom Auth Styles -->
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
        
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-header">
                <h1 class="auth-title">{{ $title ?? 'مرحباً بك' }}</h1>
            </div>

            <div class="auth-form">
                {{ $slot }}
            </div>
        </div>

        <!-- Custom Auth JavaScript -->
        <script src="{{ asset('js/auth.js') }}"></script>
    </body>
</html>
