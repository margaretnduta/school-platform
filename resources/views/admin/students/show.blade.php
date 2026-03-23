@extends('layouts.admin')

@section('page_title', 'Student Profile')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow p-8">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Student Profile</h3>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Admission Number</p>
                <p class="font-semibold text-blue-900">{{ $student->admission_number }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Full Name</p>
                <p class="font-semibold">{{ $student->full_name }}</p>
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
                <p class="text-xs text-gray-500 uppercase mb-1">Dormitory</p>
                <p class="font-semibold">{{ $student->dormitory ?? 'Not Assigned' }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Guardian Name</p>
                <p class="font-semibold">{{ $student->guardian_name }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Guardian Phone</p>
                <p class="font-semibold">{{ $student->guardian_phone }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Status</p>
                <span class="px-2 py-1 text-xs rounded-full
                    {{ $student->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($student->status) }}
                </span>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase mb-1">Email</p>
                <p class="font-semibold">{{ $student->email ?? 'N/A' }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                <p class="text-xs text-gray-500 uppercase mb-1">Address</p>
                <p class="font-semibold">{{ $student->address ?? 'N/A' }}</p>
            </div>

        </div>
    </div>
</div>

@endsection