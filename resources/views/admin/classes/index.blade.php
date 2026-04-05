@extends('layouts.admin')

@section('page_title', 'Classes')

@section('content')

@if(session('success'))
    <x-alert variant="success" dismissible>
        <strong>Success!</strong> {{ session('success') }}
    </x-alert>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-gray-600">Manage school classes and assign teachers</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Class
    </a>
</div>

<x-grid cols="3" gap="6">
    @forelse($classes as $class)
    <x-card>
        <x-card-header>
            <div>
                <h4 class="text-lg font-bold text-primary-900">{{ $class->name }}</h4>
                <p class="text-sm text-gray-500">Level: {{ $class->level }}</p>
            </div>
            <x-badge :variant="$class->status == 'active' ? 'success' : 'danger'">
                {{ ucfirst($class->status) }}
            </x-badge>
        </x-card-header>

        <x-card-body>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span class="text-gray-600">Stream:</span>
                    <span class="font-semibold text-gray-900">{{ $class->stream ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Class Teacher:</span>
                    <span class="font-semibold text-gray-900">{{ $class->classTeacher?->full_name ?? 'Not Assigned' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Room:</span>
                    <span class="font-semibold text-gray-900">{{ $class->room_number ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <span class="text-gray-600">Students:</span>
                    <span class="font-semibold text-gray-900">{{ $class->student_count }} / {{ $class->capacity }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Available:</span>
                    <span class="font-semibold {{ $class->available_spots > 0 ? 'text-success-600' : 'text-danger-600' }}">
                        {{ $class->available_spots }} spots
                    </span>
                </div>
            </div>
        </x-card-body>

        {{-- Capacity Bar --}}
        @if($class->capacity > 0)
        <x-card-body>
            <div class="space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Capacity</span>
                    <span class="font-semibold">{{ round(($class->student_count / $class->capacity) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2 rounded-full transition-all" 
                         style="width: {{ min(($class->student_count / $class->capacity) * 100, 100) }}%">
                    </div>
                </div>
            </div>
        </x-card-body>
        @endif

        <x-card-footer>
            <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-primary btn-sm">
                View Students
            </a>
            <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-white btn-sm">
                Edit
            </a>
            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Delete this class?')" class="inline">
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
                <p class="text-gray-500">No classes found. Create your first class to get started.</p>
            </x-card-body>
        </x-card>
    </div>
    @endforelse
</x-grid>

@endsection