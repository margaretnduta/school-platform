@extends('layouts.admin')

@section('page_title', 'Staff Profile')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-6">

        <div class="flex items-center gap-4">
            <x-avatar :photo="$staff->photo" :name="$staff->full_name" size="lg" />
            <div>
                <h3 class="text-xl font-bold text-blue-900">{{ $staff->full_name }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $staff->staff_number }}</p>
                <p class="text-sm text-gray-500">{{ $staff->role_name }}</p>
                <span class="mt-2 inline-block px-2 py-1 text-xs rounded-full
                    {{ $staff->status === 'active'   ? 'bg-green-100 text-green-700'   :
                      ($staff->status === 'on_leave' ? 'bg-yellow-100 text-yellow-700' :
                                                       'bg-red-100 text-red-700') }}">
                    {{ ucfirst(str_replace('_', ' ', $staff->status)) }}
                </span>
            </div>
        </div>

        <div class="flex gap-2 flex-shrink-0">
            <a href="{{ route('admin.staff.edit', $staff) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-400 transition text-sm">
                Edit
            </a>
            <a href="{{ route('admin.staff.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm">
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Staff Number</p>
            <p class="font-semibold text-blue-900">{{ $staff->staff_number }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Department</p>
            <p class="font-semibold">{{ $staff->department ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Subject</p>
            <p class="font-semibold">{{ $staff->subject ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Email</p>
            <p class="font-semibold">{{ $staff->email }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Phone</p>
            <p class="font-semibold">{{ $staff->phone ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Gender</p>
            <p class="font-semibold capitalize">{{ $staff->gender }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Employment Type</p>
            <p class="font-semibold capitalize">{{ str_replace('_', ' ', $staff->employment_type) }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Joining Date</p>
            <p class="font-semibold">{{ $staff->joining_date }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">National ID</p>
            <p class="font-semibold">{{ $staff->national_id ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Date of Birth</p>
            <p class="font-semibold">{{ $staff->date_of_birth ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 sm:col-span-2">
            <p class="text-xs text-gray-500 uppercase mb-1">Address</p>
            <p class="font-semibold">{{ $staff->address ?? 'N/A' }}</p>
        </div>

    </div>
</div>

@endsection