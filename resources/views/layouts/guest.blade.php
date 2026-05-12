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
        <header class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <span class="text-blue-700 font-bold text-lg">V</span>
                        </div>
                        <span class="text-white font-bold text-xl hidden sm:inline">VeilleSci Burkina</span>
                    </a>
                    <nav class="hidden md:flex space-x-6">
                        <a href="#" class="text-gray-100 hover:text-white transition">À propos</a>
                        <a href="#" class="text-gray-100 hover:text-white transition">Opportunités</a>
                        <a href="#" class="text-gray-100 hover:text-white transition">Contact</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <a href="/">
                        <x-application-logo class="w-16 h-16 fill-current text-blue-600 mx-auto" />
                    </a>
                    <h1 class="mt-4 text-3xl font-bold text-gray-900">Connectez-vous</h1>
                    <p class="mt-2 text-gray-600">Accédez à votre compte VeilleSci</p>
                </div>

                <!-- Form Container -->
                <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-8">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="mt-6 text-center text-sm">
                    <span class="text-gray-600">Vous n'avez pas de compte? </span>
                    <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">S'inscrire</a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- About -->
                    <div>
                        <h3 class="text-white font-bold text-lg mb-4">VeilleSci Burkina</h3>
                        <p class="text-sm text-gray-400">Une plateforme de veille scientifique pour suivre les opportunités de recherche et d'innovation au Burkina Faso.</p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-white font-bold text-lg mb-4">Liens Rapides</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Accueil</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Opportunités</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">À propos</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-white font-bold text-lg mb-4">Nous Contacter</h3>
                        <p class="text-sm text-gray-400 mb-2">Email: contact@veillesci.bf</p>
                        <p class="text-sm text-gray-400">Téléphone: +226 XX XX XX XX</p>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-800 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-sm text-gray-400">&copy; 2026 VeilleSci Burkina. Tous droits réservés.</p>
                        <div class="flex space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-white transition">Politique de Confidentialité</a>
                            <a href="#" class="text-gray-400 hover:text-white transition">Conditions d'Utilisation</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
