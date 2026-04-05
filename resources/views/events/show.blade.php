@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Events
        </a>

        <!-- Main Event Card -->
        <x-card class="shadow-lg">
            <!-- Event Image -->
            @if ($event->image)
                <div class="w-full h-96 overflow-hidden bg-gradient-to-br from-primary-400 to-secondary-400">
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-full h-96 bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center">
                    <svg class="w-24 h-24 text-white opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif

            <!-- Event Content -->
            <x-card-body>
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex items-start justify-between mb-4 gap-4 flex-wrap">
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                            <p class="text-gray-600 text-lg">{{ $event->description }}</p>
                        </div>
                        <div class="flex gap-2">
                            <x-badge :color="match($event->status) {
                                'upcoming' => 'primary',
                                'ongoing' => 'success',
                                'completed' => 'gray',
                                'cancelled' => 'danger',
                                default => 'gray'
                            }">
                                {{ Str::headline($event->status) }}
                            </x-badge>
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
                    </div>

                    @if (!$event->is_public)
                        <x-alert type="warning" dismissible>
                            <span class="font-semibold">Private Event:</span> This event is private and not listed publicly.
                        </x-alert>
                    @endif
                </div>

                <!-- Event Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                    <!-- Date & Time -->
                    <div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-100">
                                    <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Event Date & Time</h3>
                                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $event->getFormattedDateAttribute() }}</p>
                                @if ($event->event_date)
                                    <p class="text-gray-600">{{ $event->event_date->format('g:i A') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    @if ($event->location)
                        <div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary-100">
                                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Location</h3>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $event->location }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Organizer -->
                    @if ($event->organizer)
                        <div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-success-100">
                                        <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Organizer</h3>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $event->organizer }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Capacity -->
                    @if ($event->max_participants)
                        <div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-warning-100">
                                        <svg class="h-6 w-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3a6 6 0 016-6h6a6 6 0 016 6h-4m0 0h4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Participants</h3>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $event->registered_participants }}/{{ $event->max_participants }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Capacity Progress (if applicable) -->
                @if ($event->max_participants)
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Event Capacity</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>{{ $event->registered_participants }} registered</span>
                                <span>{{ round(($event->registered_participants / $event->max_participants) * 100) }}% full</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-3 rounded-full transition-all duration-300" style="width: {{ ($event->registered_participants / $event->max_participants) * 100 }}%"></div>
                            </div>
                            @if ($event->getAvailableSpotsAttribute() > 0)
                                <p class="text-sm text-success-600 font-medium mt-2">✓ {{ $event->getAvailableSpotsAttribute() }} spots available</p>
                            @else
                                <p class="text-sm text-danger-600 font-medium mt-2">✕ Event is full</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Description Section -->
                @if ($event->detailed_description)
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">About This Event</h3>
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($event->detailed_description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Action Button -->
                <div class="pt-6 border-t border-gray-200">
                    @if ($event->isUpcoming())
                        @if ($event->getAvailableSpotsAttribute() > 0)
                            <button class="btn btn-primary btn-lg w-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Register for Event
                            </button>
                        @else
                            <button class="btn btn-gray btn-lg w-full opacity-50 cursor-not-allowed" disabled>
                                Event is Full
                            </button>
                        @endif
                    @elseif ($event->status === 'ongoing')
                        <x-alert type="success" dismissible>
                            <span class="font-semibold">Event is happening now!</span> Join us for this live event.
                        </x-alert>
                    @else
                        <x-alert type="info" dismissible>
                            This event has already concluded. Thank you for your interest!
                        </x-alert>
                    @endif
                </div>
            </x-card-body>
        </x-card>
    </div>
</div>
@endsection
