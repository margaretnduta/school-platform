@extends('layouts.portal')

@section('page_title', 'Student Dashboard')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-1">Welcome, {{ auth()->user()->name }}! 🎓</h3>
        <p class="text-sm text-gray-500">Track your admission application and school updates here.</p>
    </div>

    @if($application)
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">My Application Status</h4>
        <div class="flex justify-between items-center">
            <div>
                <p class="font-semibold text-blue-900">{{ $application->full_name }}</p>
                <p class="text-sm text-gray-500">{{ $application->application_number }}</p>
                <p class="text-sm text-gray-500">Applying for: {{ $application->applying_for_class }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $application->status == 'pending'  ? 'bg-yellow-100 text-yellow-700' :
                       ($application->status == 'approved' ? 'bg-green-100 text-green-700'  : 'bg-red-100 text-red-700') }}">
                    {{ ucfirst($application->status) }}
                </span>
                <div class="mt-2">
                    <a href="{{ route('student.admissions.show', $application) }}"
                       class="text-blue-600 hover:underline text-sm">View Details</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-4xl mb-4">📋</p>
        <p class="text-gray-600 mb-4">You have not submitted an admission application yet.</p>
        <a href="{{ route('student.admissions.create') }}"
           class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">
            Apply for Admission
        </a>
    </div>
    @endif

</div>

@endsection