<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Digital Administration Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-white">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="container-fluid flex justify-between items-center py-4">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary-600 to-primary-700 flex items-center justify-center text-white font-bold">
                    🏫
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">{{ config('app.name', 'Platform') }}</h1>
                    <p class="text-xs text-gray-500">Digital Administration</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-white btn-sm">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    Register
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="gradient-primary text-white py-24 px-4 sm:px-6 lg:px-8">
        <div class="container-fluid text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 mb-6">
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                <span class="text-sm font-medium">Welcome to the Future of School Management</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Digital Administration Made Simple
            </h2>
            <p class="text-white/90 text-lg md:text-xl mb-8 leading-relaxed">
                A modern, integrated platform for managing school admissions, attendance, academics,
                dormitories, and more — designed specifically for Kenyan secondary schools.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="btn btn-white btn-lg">
                    Apply for Admission
                </a>
                <a href="#features" class="btn btn-primary-outline btn-lg">
                    Learn More
                </a>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container-fluid">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Powerful Features for Everyone</h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Streamline operations with comprehensive tools designed for parents, students, and administrators.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <x-card>
                    <x-card-body class="text-center">
                        <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center text-3xl mx-auto mb-4">
                            👨‍👩‍👦
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">For Parents</h4>
                        <p class="text-gray-600 leading-relaxed">
                            Register and apply for your child's admission directly through our portal. 
                            Track academic progress, attendance records, and fee statements in real-time.
                        </p>
                    </x-card-body>
                </x-card>

                <x-card>
                    <x-card-body class="text-center">
                        <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-success-100 to-success-200 flex items-center justify-center text-3xl mx-auto mb-4">
                            🎓
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">For Students</h4>
                        <p class="text-gray-600 leading-relaxed">
                            Apply for admission independently. View your results, access timetables, 
                            and stay updated with school announcements after enrollment.
                        </p>
                    </x-card-body>
                </x-card>

                <x-card>
                    <x-card-body class="text-center">
                        <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center text-3xl mx-auto mb-4">
                            👨‍💼
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">For Administration</h4>
                        <p class="text-gray-600 leading-relaxed">
                            Manage admissions, classes, dormitories, attendance, meal tracking, 
                            and generate comprehensive reports - all in one centralized platform.
                        </p>
                    </x-card-body>
                </x-card>

            </div>
        </div>
    </section>

    {{-- Key Modules --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="container-fluid">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Core Modules</h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Everything you need to run your school efficiently and effectively.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                $modules = [
                    ['icon' => '📋', 'title' => 'Admissions', 'desc' => 'Streamlined online application process'],
                    ['icon' => '👥', 'title' => 'Student Mgmt', 'desc' => 'Complete student information system'],
                    ['icon' => '📚', 'title' => 'Academics', 'desc' => 'Subject, class, and performance tracking'],
                    ['icon' => '✅', 'title' => 'Attendance', 'desc' => 'Real-time attendance marking and reports'],
                    ['icon' => '🛏️', 'title' => 'Dormitories', 'desc' => 'Room and bed allocation management'],
                    ['icon' => '🍽️', 'title' => 'Meals', 'desc' => 'Meal check-in and tracking'],
                    ['icon' => '👥', 'title' => 'Staff Mgmt', 'desc' => 'Complete staff profiles and roles'],
                    ['icon' => '📊', 'title' => 'Analytics', 'desc' => 'Comprehensive reporting dashboards'],
                ];
                @endphp

                @foreach($modules as $module)
                    <x-card>
                        <x-card-body>
                            <div class="text-3xl mb-3">{{ $module['icon'] }}</div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $module['title'] }}</h4>
                            <p class="text-sm text-gray-600">{{ $module['desc'] }}</p>
                        </x-card-body>
                    </x-card>
                @endforeach

            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="container-fluid text-center max-w-2xl mx-auto">
            <h3 class="text-4xl md:text-5xl font-bold mb-4">Ready to Get Started?</h3>
            <p class="text-xl text-white/90 mb-8">
                Join schools across Kenya simplifying their digital administration today.
            </p>
            <a href="{{ route('register') }}" class="btn btn-white btn-lg">
                Create Your Account
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="container-fluid">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-white font-semibold mb-4">{{ config('app.name', 'Platform') }}</h4>
                    <p class="text-sm">Digital administration platform designed for Kenyan schools.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Platform') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>

</body>
</html>