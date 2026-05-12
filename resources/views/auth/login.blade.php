<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" class="block text-sm font-semibold text-gray-700 mb-2" />
            <x-text-input 
                id="email" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="vous@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de Passe')" class="block text-sm font-semibold text-gray-700 mb-2" />

            <x-text-input 
                id="password" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                id="remember_me" 
                type="checkbox" 
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer" 
                name="remember">
            <label for="remember_me" class="ms-3 text-sm text-gray-600 cursor-pointer hover:text-gray-700">
                {{ __('Me souvenir de moi') }}
            </label>
        </div>

        <!-- Submit and Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            @if (Route::has('password.request'))
                <a 
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium transition" 
                    href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                {{ __('Se Connecter') }}
            </x-primary-button>
        </div>

        <!-- Sign Up Link -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Pas encore inscrit? 
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">
                    Créer un compte
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
