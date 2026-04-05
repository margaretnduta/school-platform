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
                    <h1 class="text-lg font-bold text-gray-900">School Platform</h1>
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

    {{-- Hero Carousel --}}
    <div class="relative w-full overflow-hidden bg-black" x-data="heroCarousel()" x-init="init()" style="height: 600px;">
        <!-- Carousel Slides Container -->
        <div class="relative w-full h-full">
            <!-- Slide 1 -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="{ 'opacity-100': currentSlide === 0, 'opacity-0 pointer-events-none': currentSlide !== 0 }">
                <img src="{{ asset('images/carousel/slide-1.jpg') }}" alt="Slide 1" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="relative h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mx-auto text-center text-white">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 mb-6">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span class="text-sm font-medium">Welcome to the Future of School Management</span>
                        </div>
                        <h2 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">Digital Administration Made Simple</h2>
                        <p class="text-white/90 text-lg md:text-xl mb-8 leading-relaxed">A modern, integrated platform for managing school admissions, attendance, academics, dormitories, and more — designed specifically for Kenyan secondary schools.</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('register') }}" class="btn btn-white btn-lg">Apply for Admission</a>
                            <a href="#features" class="btn btn-primary-outline btn-lg">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="{ 'opacity-100': currentSlide === 1, 'opacity-0 pointer-events-none': currentSlide !== 1 }">
                <img src="{{ asset('images/carousel/slide-2.jpg') }}" alt="Slide 2" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="relative h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mx-auto text-center text-white">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 mb-6">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span class="text-sm font-medium">For Students & Parents</span>
                        </div>
                        <h2 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">Easy Admission Process</h2>
                        <p class="text-white/90 text-lg md:text-xl mb-8 leading-relaxed">Apply online for school admission with a streamlined digital process. Track your application status in real-time and get instant updates.</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('register') }}" class="btn btn-white btn-lg">Apply for Admission</a>
                            <a href="#features" class="btn btn-primary-outline btn-lg">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="{ 'opacity-100': currentSlide === 2, 'opacity-0 pointer-events-none': currentSlide !== 2 }">
                <img src="{{ asset('images/carousel/slide-3.jpg') }}" alt="Slide 3" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="relative h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mx-auto text-center text-white">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 mb-6">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span class="text-sm font-medium">For School Administration</span>
                        </div>
                        <h2 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">Comprehensive Management Tools</h2>
                        <p class="text-white/90 text-lg md:text-xl mb-8 leading-relaxed">Manage students, staff, classes, dormitories, attendance, meals, and academic records all in one centralized platform.</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('register') }}" class="btn btn-white btn-lg">Apply for Admission</a>
                            <a href="#features" class="btn btn-primary-outline btn-lg">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <button @click="prev()" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 p-3 rounded-full bg-white/20 hover:bg-white/30 text-white transition-all duration-200 backdrop-blur-sm" aria-label="Previous slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button @click="next()" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 p-3 rounded-full bg-white/20 hover:bg-white/30 text-white transition-all duration-200 backdrop-blur-sm" aria-label="Next slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dot Navigation -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 flex gap-2">
                <button @click="currentSlide = 0" class="transition-all duration-300 rounded-full" :class="{ 'bg-white w-3 h-3': currentSlide === 0, 'bg-white/50 w-2 h-2': currentSlide !== 0 }" aria-label="Go to slide 1"></button>
                <button @click="currentSlide = 1" class="transition-all duration-300 rounded-full" :class="{ 'bg-white w-3 h-3': currentSlide === 1, 'bg-white/50 w-2 h-2': currentSlide !== 1 }" aria-label="Go to slide 2"></button>
                <button @click="currentSlide = 2" class="transition-all duration-300 rounded-full" :class="{ 'bg-white w-3 h-3': currentSlide === 2, 'bg-white/50 w-2 h-2': currentSlide !== 2 }" aria-label="Go to slide 3"></button>
            </div>
        </div>

        <!-- Alpine.js Carousel Script -->
        <script>
            function heroCarousel() {
                return {
                    currentSlide: 0,
                    autoPlayInterval: null,
                    init() {
                        this.startAutoPlay();
                    },
                    next() {
                        this.currentSlide = (this.currentSlide + 1) % 3;
                        this.restartAutoPlay();
                    },
                    prev() {
                        this.currentSlide = (this.currentSlide - 1 + 3) % 3;
                        this.restartAutoPlay();
                    },
                    startAutoPlay() {
                        this.autoPlayInterval = setInterval(() => {
                            this.currentSlide = (this.currentSlide + 1) % 3;
                        }, 5000);
                    },
                    restartAutoPlay() {
                        clearInterval(this.autoPlayInterval);
                        this.startAutoPlay();
                    }
                }
            }
        </script>
    </div>
                    },
                    restartAutoPlay() {
                        clearInterval(this.interval);
                        this.startAutoPlay();
                    }
                }
            }
        </script>
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

    {{-- Events Section --}}
    @if ($upcomingEvents->count() > 0)
        <section class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="container-fluid">
                <div class="text-center mb-16">
                    <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Upcoming School Events</h3>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Stay updated with our exciting school events and activities.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    @foreach ($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="group">
                            <x-card class="h-full hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <!-- Event Image -->
                                <div class="relative overflow-hidden h-40 bg-gradient-to-br from-primary-400 to-secondary-400">
                                    @if ($event->image)
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Status Badge -->
                                    <div class="absolute top-2 right-2">
                                        <x-badge :color="match($event->status) {
                                            'upcoming' => 'primary',
                                            'ongoing' => 'success',
                                            'completed' => 'gray',
                                            'cancelled' => 'danger',
                                            default => 'gray'
                                        }">
                                            {{ ucfirst($event->status) }}
                                        </x-badge>
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <x-card-body>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">
                                        {{ $event->title }}
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $event->description }}
                                    </p>

                                    <!-- Event Meta -->
                                    <div class="space-y-1 text-xs text-gray-700">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $event->getFormattedDateAttribute() }}</span>
                                        </div>
                                        
                                        @if ($event->location)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ $event->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </x-card-body>

                                <!-- Footer -->
                                <x-card-footer class="pt-3">
                                    <button class="w-full text-sm btn btn-primary btn-sm group-hover:btn-primary transition-all">
                                        Learn More →
                                    </button>
                                </x-card-footer>
                            </x-card>
                        </a>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('events.index') }}" class="btn btn-primary btn-lg">
                        View All Events
                    </a>
                </div>
            </div>
        </section>
    @endif

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