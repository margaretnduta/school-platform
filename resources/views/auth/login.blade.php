<x-guest-layout>
    <!-- Page Title -->
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
    <p class="text-gray-600 mb-8">Access your school account to manage operations</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold mb-2" />
            <x-text-input 
                id="email" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold mb-2" />
            <x-text-input 
                id="password" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-primary-600 hover:text-primary-700 font-medium transition" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn btn-primary btn-lg">
            Sign In
        </button>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition">
                    Create one
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
