<x-guest-layout>
    <!-- Page Title -->
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Your Account</h2>
    <p class="text-gray-600 mb-8">Register to apply for admission or track your child's progress</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('I am a')" class="text-gray-700 font-semibold mb-2" />
            <select name="role" id="role"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition bg-white"
                    required>
                <option value="">Select your role...</option>
                <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>
                    👨‍👩‍👧‍👦 Parent — Applying for my child
                </option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                    🎓 Student — Applying for myself
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Full Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-semibold mb-2" />
            <x-text-input 
                id="name" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                type="text"
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="John Doe"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-xs text-gray-600 mt-2">At least 8 characters with numbers and letters</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold mb-2" />
            <x-text-input 
                id="password_confirmation" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn btn-primary btn-lg">
            Create Account
        </button>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition">
                    Sign in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>