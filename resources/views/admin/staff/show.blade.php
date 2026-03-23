@extends('layouts.admin')

@section('page_title', 'Staff Profile')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-700">Staff Profile</h3>
        <div class="space-x-2">
            <a href="{{ route('admin.staff.edit', $staff) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-400 transition">Edit</a>
            <a href="{{ route('admin.staff.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Staff Number</p>
            <p class="font-semibold text-blue-900">{{ $staff->staff_number }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Full Name</p>
            <p class="font-semibold">{{ $staff->full_name }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Role</p>
            <p class="font-semibold">{{ $staff->role_name }}</p>
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
            <p class="text-xs text-gray-500 uppercase mb-1">Status</p>
            <span class="px-2 py-1 text-xs rounded-full
                {{ $staff->status === 'active' ? 'bg-green-100 text-green-700' :
                   ($staff->status === 'on_leave' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                {{ ucfirst(str_replace('_', ' ', $staff->status)) }}
            </span>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">National ID</p>
            <p class="font-semibold">{{ $staff->national_id ?? 'N/A' }}</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
            <p class="text-xs text-gray-500 uppercase mb-1">Address</p>
            <p class="font-semibold">{{ $staff->address ?? 'N/A' }}</p>
        </div>

    </div>
</div>

@endsection