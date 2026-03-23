@extends('layouts.admin')

@section('page_title', 'Classes')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">All Classes</h3>
    <a href="{{ route('admin.classes.create') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        + Add Class
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($classes as $class)
    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-start mb-3">
            <div>
                <h4 class="text-lg font-bold text-blue-900">{{ $class->name }}</h4>
                <p class="text-sm text-gray-500">Level: {{ $class->level }}</p>
            </div>
            <span class="text-xs px-2 py-1 rounded-full
                {{ $class->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ ucfirst($class->status) }}
            </span>
        </div>

        <div class="space-y-2 text-sm text-gray-600 mb-4">
            <div class="flex justify-between">
                <span>Stream:</span>
                <span class="font-semibold">{{ $class->stream ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Class Teacher:</span>
                <span class="font-semibold">{{ $class->classTeacher?->full_name ?? 'Not Assigned' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Room:</span>
                <span class="font-semibold">{{ $class->room_number ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Students:</span>
                <span class="font-semibold">{{ $class->student_count }} / {{ $class->capacity }}</span>
            </div>
            <div class="flex justify-between">
                <span>Available Spots:</span>
                <span class="font-semibold {{ $class->available_spots > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $class->available_spots }}
                </span>
            </div>
        </div>

        {{-- Capacity Bar --}}
        @if($class->capacity > 0)
        <div class="mb-4">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full"
                     style="width: {{ min(($class->student_count / $class->capacity) * 100, 100) }}%">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                {{ round(($class->student_count / $class->capacity) * 100) }}% full
            </p>
        </div>
        @endif

        <div class="flex space-x-2">
            <a href="{{ route('admin.classes.show', $class) }}"
               class="flex-1 text-center bg-blue-900 text-white py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                View Students
            </a>
            <a href="{{ route('admin.classes.edit', $class) }}"
               class="flex-1 text-center bg-yellow-500 text-white py-2 rounded-lg text-sm hover:bg-yellow-400 transition">
                Edit
            </a>
            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST"
                  onsubmit="return confirm('Delete this class?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-400 transition">
                    Del
                </button>
            </form>
        </div>

    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-gray-400">
        No classes found. Create your first class!
    </div>
    @endforelse
</div>

@endsection