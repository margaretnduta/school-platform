@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-primary-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Upcoming Events</h1>
            <p class="text-lg text-gray-600">Discover and join our exciting school events</p>
        </div>

        <!-- Events Grid -->
        @if ($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="group">
                        <x-card class="h-full hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Event Image -->
                            <div class="relative overflow-hidden h-48 bg-gradient-to-br from-primary-400 to-secondary-400">
                                @if ($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Category Badge -->
                                <div class="absolute top-3 right-3">
                                    <x-badge :color="match($event->category) {
                                        'Sports' => 'success',
                                        'Academic' => 'primary',
                                        'Cultural' => 'secondary',
                                        'Ceremony' => 'warning',
                                        'Social' => 'info',
                                        'Workshop' => 'warning',
                                        default => 'gray'
                                    }">
                                        {{ $event->category }}
                                    </x-badge>
                                </div>

                                <!-- Status Badge -->
                                <div class="absolute top-3 left-3">
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
                            <x-card-body class="pt-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">
                                    {{ $event->title }}
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $event->description }}
                                </p>

                                <!-- Event Meta -->
                                <div class="space-y-2 text-sm text-gray-700 mb-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $event->getFormattedDateAttribute() }}</span>
                                    </div>
                                    
                                    @if ($event->location)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                    @endif

                                    @if ($event->max_participants)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3a6 6 0 016-6h6a6 6 0 016 6h-4m0 0h4"></path>
                                            </svg>
                                            <span>{{ $event->registered_participants }}/{{ $event->max_participants }} registered</span>
                                        </div>
                                    @endif
                                </div>

                                @if ($event->max_participants)
                                    <!-- Participant Progress Bar -->
                                    <div class="mb-4">
                                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                                            <span>Capacity</span>
                                            <span>{{ round(($event->registered_participants / $event->max_participants) * 100) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-2 rounded-full transition-all duration-300" style="width: {{ ($event->registered_participants / $event->max_participants) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </x-card-body>

                            <!-- Footer -->
                            <x-card-footer class="pt-4">
                                <button class="w-full btn btn-primary group-hover:btn-primary transition-all">
                                    Learn More →
                                </button>
                            </x-card-footer>
                        </x-card>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($events->hasPages())
                <div class="flex justify-center">
                    {{ $events->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No events yet</h3>
                <p class="text-gray-600 mt-2">Check back soon for upcoming events!</p>
            </div>
        @endif
    </div>
</div>
@endsection
