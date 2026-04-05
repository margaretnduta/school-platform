@extends('layouts.admin')

@section('page_title', $event->title)

@section('content')

<div class="max-w-4xl mx-auto">
    <x-card>
        @if($event->image)
        <div class="h-64 bg-gray-200 overflow-hidden rounded-t-xl">
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
        </div>
        @endif

        <x-card-header>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h2>
                <p class="text-gray-600 mt-1">{{ $event->category ?? 'Event' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <x-badge :variant="match($event->status) {
                    'upcoming' => 'primary',
                    'ongoing' => 'success',
                    'completed' => 'gray',
                    'cancelled' => 'danger',
                }">
                    {{ ucfirst($event->status) }}
                </x-badge>
            </div>
        </x-card-header>

        <x-card-body class="space-y-6">
            <!-- Key Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600 mb-1">
                        <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                        </svg>
                        Date & Time
                    </p>
                    <p class="font-semibold text-gray-900">{{ $event->formatted_date }} at {{ $event->formatted_time }}</p>
                </div>

                @if($event->location)
                <div>
                    <p class="text-sm text-gray-600 mb-1">
                        <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        Location
                    </p>
                    <p class="font-semibold text-gray-900">{{ $event->location }}</p>
                </div>
                @endif

                @if($event->organizer)
                <div>
                    <p class="text-sm text-gray-600 mb-1">
                        <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                        Organizer
                    </p>
                    <p class="font-semibold text-gray-900">{{ $event->organizer }}</p>
                </div>
                @endif

                @if($event->max_participants)
                <div>
                    <p class="text-sm text-gray-600 mb-1">
                        <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                        Participants
                    </p>
                    <p class="font-semibold text-gray-900">{{ $event->registered_participants }} / {{ $event->max_participants }}</p>
                </div>
                @endif
            </div>

            <!-- Capacity Bar -->
            @if($event->max_participants)
            <div>
                <p class="text-sm text-gray-600 mb-2">Attendance Rate</p>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-3 rounded-full transition-all" 
                         style="width: {{ (($event->registered_participants / $event->max_participants) * 100) }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ round((($event->registered_participants / $event->max_participants) * 100)) }}% capacity</p>
            </div>
            @endif

            <!-- Short Description -->
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
            </div>

            <!-- Detailed Description -->
            @if($event->detailed_description)
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Details</h3>
                <div class="prose prose-sm max-w-none text-gray-700">
                    {!! nl2br(e($event->detailed_description)) !!}
                </div>
            </div>
            @endif

            <!-- Visibility -->
            <div class="p-6 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm">
                    <strong>Visibility:</strong> 
                    <span class="ml-2">
                        @if($event->is_public)
                            <x-badge variant="success">Public (Visible on Welcome Page)</x-badge>
                        @else
                            <x-badge variant="gray">Private (Hidden from Public)</x-badge>
                        @endif
                    </span>
                </p>
            </div>
        </x-card-body>

        <x-card-footer>
            <a href="{{ route('admin.events.index') }}" class="btn btn-white">
                Back
            </a>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                Edit Event
            </a>
            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>
            </form>
        </x-card-footer>
    </x-card>
</div>

@endsection
