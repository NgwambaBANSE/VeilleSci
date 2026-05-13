<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VeilleSci Burkina') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <!-- Header -->

        <!-- Main Content -->
        <main class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <a href="/">
                    </a>
                    <h1 class="mt-4 text-3xl font-bold text-gray-900">Connectez-vous</h1>
                    <p class="mt-2 text-gray-600">Accédez à votre compte VeilleSci</p>
                    
                </div>

                <!-- Form Container -->
                <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-8">
                        {{ $slot }}
                    </div>
                    <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
                        <span class="px-6 py-8">Vous n'avez pas de compte? </span>
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">S'inscrire</a>
                    </div>
                </div>
                <!-- Footer Links -->
            </div>
        </main>

        <!-- Footer -->

    </body>
</html>
