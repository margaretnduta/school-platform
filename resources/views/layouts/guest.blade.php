<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'School Platform') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Modern Auth Container -->
        <div class="min-h-screen grid grid-cols-1 md:grid-cols-2 gap-0">
            
            <!-- Left Side - Gradient Welcome Section (Hidden on Mobile) -->
            <div class="hidden md:flex flex-col justify-between p-12 bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 text-white">
                <div>
                    <!-- Logo and Brand -->
                    <a href="/" class="inline-flex items-center gap-3 mb-16">
                        <div class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center text-2xl font-bold">
                            🏫
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">School Platform</h1>
                            <p class="text-sm text-white/80">Digital Administration</p>
                        </div>
                    </a>

                    <!-- Welcome Content -->
                    <div>
                        <h2 class="text-4xl font-bold mb-4 leading-tight">Welcome back</h2>
                        <p class="text-lg text-white/90 mb-8 leading-relaxed">
                            Manage your school operations with our modern, integrated digital administration platform.
                        </p>
                        
                        <!-- Features List -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-white/30 flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-white/90">Seamless student management</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-white/30 flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-white/90">Real-time attendance tracking</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-white/30 flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-white/90">Comprehensive reporting tools</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-sm text-white/70">
                    <p>&copy; {{ date('Y') }} School Platform. All rights reserved.</p>
                </div>
            </div>

            <!-- Right Side - Auth Form -->
            <div class="flex flex-col justify-center items-center p-6 sm:p-8 md:p-12 lg:p-16 bg-gradient-to-br from-gray-50 to-white">
                <div class="w-full max-w-md">
                    <!-- Mobile Header -->
                    <div class="md:hidden mb-8 text-center">
                        <a href="/" class="inline-flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary-600 to-primary-700 flex items-center justify-center text-white font-bold">
                                🏫
                            </div>
                            <div class="text-left">
                                <h1 class="font-bold text-gray-900">School Platform</h1>
                                <p class="text-xs text-gray-500">Digital Administration</p>
                            </div>
                        </a>
                    </div>

                    <!-- Form Container -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="p-8 sm:p-10">
                            {{ $slot }}
                        </div>
                    </div>

                    <!-- Additional Links -->
                    <div class="mt-6 text-center text-sm text-gray-600">
                        <p>Don't have an account? 
                            <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition">
                                Sign up here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
