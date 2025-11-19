<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name', 'GameTradingMarketplace') }}</title>
    <link href="/resources/css/app.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <nav class="bg-white shadow-sm">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="/" class="font-bold">{{ config('app.name') }}</a>
            <div>
                @auth
                    <a href="{{ route('items.index') }}" class="mr-4">Items</a>
                    <a href="{{ route('profile.edit') }}" class="mr-4">Profile</a>
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="mr-4">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button class="text-sm">Logout</button></form>
                @else
                    <a href="{{ route('login') }}" class="mr-4">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="container mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 p-3 mb-4">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
