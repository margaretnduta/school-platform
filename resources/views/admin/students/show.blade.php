@extends('layouts.admin')

@section('page_title', 'Student Profile')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow p-8 mb-6">

        <div class="flex justify-between items-start mb-6">

            {{-- Avatar & Name --}}
            <div class="flex items-center space-x-5">
                <x-avatar :photo="$student->photo" :name="$student->full_name" size="20" />
                <div>
                    <h3 class="text-2xl font-bold text-blue-900">{{ $student->full_name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $student->admission_number }}</p>
                    <span class="mt-2 inline-block px-2 py-1 text-xs rounded-full
                        {{ $student->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </div>
            </div>

            <div class="space-x-2">
                <a href="{{ route('admin.students.edit', $student) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-400 transition">
                    Edit
                </a>
                <a href="{{ route('admin.students.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Admission Number</p>
                <p class="font-semibold text-blue-900">{{ $student->admission_number }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Gender</p>
                <p class="font-semibold capitalize">{{ $student->gender }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Date of Birth</p>
                <p class="font-semibold">{{ $student->date_of_birth }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Class</p>
                <p class="font-semibold">{{ $student->class ?? 'Not Assigned' }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Email</p>
                <p class="font-semibold">{{ $student->email ?? 'N/A' }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Phone</p>
                <p class="font-semibold">{{ $student->phone ?? 'N/A' }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Guardian Name</p>
                <p class="font-semibold">{{ $student->guardian_name }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Guardian Phone</p>
                <p class="font-semibold">{{ $student->guardian_phone }}</p>
            </div>

            @if($bed)
            <div class="bg-blue-50 rounded-lg p-4 md:col-span-2">
                <p class="text-xs text-gray-500 uppercase mb-1">Dormitory Assignment</p>
                <p class="font-semibold text-blue-900">
                    🏠 {{ $bed->dormitory->name }} &nbsp;|&nbsp;
                    {{ $bed->room->room_number }} &nbsp;|&nbsp;
                    {{ $bed->bed_number }} ({{ ucfirst($bed->position) }})
                </p>
            </div>
            @endif

            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                <p class="text-xs text-gray-500 uppercase mb-1">Address</p>
                <p class="font-semibold">{{ $student->address ?? 'N/A' }}</p>
            </div>

        </div>
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('admin.attendance.student', $student->id) }}"
           class="bg-white rounded-xl shadow p-5 flex items-center space-x-4 hover:shadow-md transition">
            <span class="text-3xl">✅</span>
            <div>
                <p class="font-semibold text-gray-700">View Attendance</p>
                <p class="text-xs text-gray-400">See full attendance history</p>
            </div>
        </a>
        <a href="{{ route('admin.meals.student', $student->id) }}"
           class="bg-white rounded-xl shadow p-5 flex items-center space-x-4 hover:shadow-md transition">
            <span class="text-3xl">🍽️</span>
            <div>
                <p class="font-semibold text-gray-700">View Meal Profile</p>
                <p class="text-xs text-gray-400">See meal history and stats</p>
            </div>
        </a>
    </div>

</div>

@endsection