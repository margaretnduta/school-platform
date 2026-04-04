<x-app-layout>
    <x-slot name="header">
        <h2 class="text-heading">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <x-card>
                    <x-card-body>
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="divider-sm"></div>
                        <nav class="space-y-2">
                            <a href="#" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-sm">Account</a>
                            <a href="#" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-sm">Security</a>
                            <a href="#" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium text-sm">Preferences</a>
                        </nav>
                    </x-card-body>
                </x-card>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-card>
                    <x-card-header>
                        <h3 class="text-lg font-semibold text-gray-900">Profile Information</h3>
                    </x-card-header>
                    <x-card-body>
                        @include('profile.partials.update-profile-information-form')
                    </x-card-body>
                </x-card>

                <x-card>
                    <x-card-header>
                        <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                    </x-card-header>
                    <x-card-body>
                        @include('profile.partials.update-password-form')
                    </x-card-body>
                </x-card>

                <x-card class="border-danger-200">
                    <x-card-header class="bg-danger-50">
                        <h3 class="text-lg font-semibold text-danger-900">Danger Zone</h3>
                    </x-card-header>
                    <x-card-body>
                        @include('profile.partials.delete-user-form')
                    </x-card-body>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
