@extends('layouts.admin')

@section('page_title', 'Events')

@section('content')

@if(session('success'))
    <x-alert variant="success" dismissible>
        <strong>Success!</strong> {{ session('success') }}
    </x-alert>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-gray-600">Manage school events and activities</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Create Event
    </a>
</div>

<x-grid cols="3" gap="6">
    @forelse($events as $event)
    <x-card>
        @if($event->image)
        <div class="relative overflow-hidden rounded-t-xl h-48 bg-gray-200">
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
            <div class="absolute top-3 right-3">
                <x-badge :variant="match($event->status) {
                    'upcoming' => 'primary',
                    'ongoing' => 'success',
                    'completed' => 'gray',
                    'cancelled' => 'danger',
                }">
                    {{ ucfirst($event->status) }}
                </x-badge>
            </div>
        </div>
        @else
        <div class="h-48 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center rounded-t-xl">
            <svg class="w-16 h-16 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        @endif

        <x-card-body>
            <h4 class="font-bold text-lg text-gray-900 mb-2 truncate-2">{{ $event->title }}</h4>
            
            <div class="space-y-2 text-sm text-gray-600 mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path></svg>
                    <span>{{ $event->formatted_date }} at {{ $event->formatted_time }}</span>
                </div>
                
                @if($event->location)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    <span class="truncate">{{ $event->location }}</span>
                </div>
                @endif

                @if($event->max_participants)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    <span>{{ $event->registered_participants }}/{{ $event->max_participants }} registered</span>
                </div>
                @endif

                @if($event->category)
                <div class="flex items-center gap-2">
                    <span class="text-xs px-2 py-1 rounded-full bg-primary-100 text-primary-700">
                        {{ $event->category }}
                    </span>
                </div>
                @endif
            </div>

            <p class="text-sm text-gray-700 line-clamp-2">{{ $event->description }}</p>
        </x-card-body>

        <x-card-footer>
            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-primary btn-sm">
                View
            </a>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-white btn-sm">
                Edit
            </a>
            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>
        </x-card-footer>
    </x-card>
    @empty
    <div class="col-span-3">
        <x-card>
            <x-card-body class="text-center py-12">
                <p class="text-gray-500">No events created yet. Create your first event to get started.</p>
            </x-card-body>
        </x-card>
    </div>
    @endforelse
</x-grid>

@if($events->hasPages())
<div class="mt-6 flex justify-center">
    {{ $events->links() }}
</div>
@endif

@endsection
