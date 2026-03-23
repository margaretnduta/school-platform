@extends('layouts.admin')

@section('page_title', 'Dormitory Rooms')

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

{{-- Dormitory Header --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-xl font-bold text-blue-900">{{ $dormitory->name }}</h3>
            <p class="text-sm text-gray-500 mt-1">
                {{ ucfirst($dormitory->gender) }} •
                {{ $dormitory->rooms_count }} Rooms •
                {{ $dormitory->beds_per_room }} Beds/Room •
                {{ $dormitory->total_beds }} Total Beds
            </p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-green-600">{{ $dormitory->available_beds }}</p>
            <p class="text-xs text-gray-500">Available Beds</p>
        </div>
    </div>

    {{-- Assign Bed Form --}}
    <div class="mt-6 border-t pt-4">
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Assign Next Available Bed to Student</h4>
        <form action="{{ route('admin.dormitories.assign-bed') }}" method="POST" class="flex space-x-3">
            @csrf
            <input type="hidden" name="dormitory_id" value="{{ $dormitory->id }}">
            <select name="student_id"
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Student</option>
                @foreach(\App\Models\Student::where('status', 'active')->get() as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->full_name }} — {{ $student->admission_number }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                    class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">
                Auto-Assign Bed
            </button>
        </form>
    </div>
</div>

{{-- Rooms Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($rooms as $room)
    <div class="bg-white rounded-xl shadow p-4">

        <div class="flex justify-between items-center mb-3">
            <h4 class="font-semibold text-gray-700">{{ $room->room_number }}</h4>
            <span class="text-xs px-2 py-1 rounded-full
                {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $room->status == 'available' ? $room->available_beds . ' beds free' : 'Full' }}
            </span>
        </div>

        <div class="space-y-2">
            @foreach($room->beds as $bed)
            <div class="flex items-center justify-between p-2 rounded-lg
                {{ $bed->status == 'empty' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                <div>
                    <p class="text-xs font-semibold text-gray-700">
                        {{ $bed->bed_number }} ({{ ucfirst($bed->position) }})
                    </p>
                    @if($bed->student)
                        <p class="text-xs text-gray-500">{{ $bed->student->full_name }}</p>
                    @else
                        <p class="text-xs text-green-600">Available</p>
                    @endif
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full {{ $bed->status == 'empty' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                    @if($bed->status == 'occupied')
                        <form action="{{ route('admin.dormitories.release-bed', $bed) }}" method="POST"
                              onsubmit="return confirm('Release this bed?')">
                            @csrf
                            <button type="submit" class="text-xs text-red-600 hover:underline">Release</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
    @endforeach
</div>

@endsection