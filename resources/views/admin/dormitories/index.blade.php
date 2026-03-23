@extends('layouts.admin')

@section('page_title', 'Dormitories')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">All Dormitories</h3>
    <a href="{{ route('admin.dormitories.create') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        + Add Dormitory
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($dormitories as $dormitory)
    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-start mb-4">
            <div>
                <h4 class="text-lg font-bold text-blue-900">{{ $dormitory->name }}</h4>
                <span class="text-xs px-2 py-1 rounded-full
                    {{ $dormitory->gender == 'male' ? 'bg-blue-100 text-blue-700' :
                       ($dormitory->gender == 'female' ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-700') }}">
                    {{ ucfirst($dormitory->gender) }}
                </span>
            </div>
            <span class="text-xs px-2 py-1 rounded-full
                {{ $dormitory->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $dormitory->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div class="space-y-2 text-sm text-gray-600 mb-4">
            <div class="flex justify-between">
                <span>Total Rooms:</span>
                <span class="font-semibold">{{ $dormitory->rooms_count }}</span>
            </div>
            <div class="flex justify-between">
                <span>Beds Per Room:</span>
                <span class="font-semibold">{{ $dormitory->beds_per_room }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total Beds:</span>
                <span class="font-semibold">{{ $dormitory->total_beds }}</span>
            </div>
            <div class="flex justify-between">
                <span>Occupied:</span>
                <span class="font-semibold text-red-600">{{ $dormitory->occupied_beds }}</span>
            </div>
            <div class="flex justify-between">
                <span>Available:</span>
                <span class="font-semibold text-green-600">{{ $dormitory->available_beds }}</span>
            </div>
        </div>

        {{-- Capacity Bar --}}
        @if($dormitory->total_beds > 0)
        <div class="mb-4">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full"
                     style="width: {{ ($dormitory->occupied_beds / $dormitory->total_beds) * 100 }}%">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                {{ round(($dormitory->occupied_beds / $dormitory->total_beds) * 100) }}% occupied
            </p>
        </div>
        @endif

        @if($dormitory->warden_name)
        <p class="text-xs text-gray-500 mb-4">Warden: {{ $dormitory->warden_name }}</p>
        @endif

        <div class="flex space-x-2">
            <a href="{{ route('admin.dormitories.show', $dormitory) }}"
               class="flex-1 text-center bg-blue-900 text-white py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                View Rooms
            </a>
            <a href="{{ route('admin.dormitories.edit', $dormitory) }}"
               class="flex-1 text-center bg-yellow-500 text-white py-2 rounded-lg text-sm hover:bg-yellow-400 transition">
                Edit
            </a>
            <form action="{{ route('admin.dormitories.destroy', $dormitory) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this dormitory and all its rooms/beds?')">
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
        No dormitories found. Create your first dormitory!
    </div>
    @endforelse
</div>

@endsection