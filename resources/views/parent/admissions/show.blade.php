@extends('layouts.portal')

@section('page_title', 'Application Details')

@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8">

    <div class="flex justify-between items-start mb-6">
        <div>
            <h3 class="text-xl font-bold text-blue-900">{{ $application->full_name }}</h3>
            <p class="text-sm text-gray-500">Application No: {{ $application->application_number }}</p>
            <p class="text-sm text-gray-500">Submitted: {{ $application->created_at->format('d M Y') }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-semibold
            {{ $application->status == 'pending'  ? 'bg-yellow-100 text-yellow-700' :
               ($application->status == 'approved' ? 'bg-green-100 text-green-700'  : 'bg-red-100 text-red-700') }}">
            {{ ucfirst($application->status) }}
        </span>
    </div>

    @if($application->status == 'approved' && $application->student)
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <p class="text-green-700 font-semibold">🎉 Application Approved!</p>
        <p class="text-sm text-gray-600 mt-1">
            Admission Number: <span class="font-bold text-green-700">{{ $application->student->admission_number }}</span>
        </p>
        <p class="text-sm text-gray-600">
            Class Assigned: <span class="font-bold">{{ $application->student->class }}</span>
        </p>
        @if($application->student->dormitory)
        <p class="text-sm text-gray-600">
            Dormitory: <span class="font-bold">{{ $application->student->dormitory }}</span>
        </p>
        @endif
    </div>
    @elseif($application->status == 'rejected')
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <p class="text-red-700 font-semibold">❌ Application Rejected</p>
        <p class="text-sm text-gray-600 mt-1">Reason: {{ $application->rejection_reason }}</p>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <p class="text-yellow-700 font-semibold">⏳ Application Pending Review</p>
        <p class="text-sm text-gray-600 mt-1">Your application is being reviewed. We will notify you once a decision is made.</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Full Name</p>
            <p class="font-semibold">{{ $application->full_name }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Gender</p>
            <p class="font-semibold capitalize">{{ $application->gender }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Date of Birth</p>
            <p class="font-semibold">{{ $application->date_of_birth }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Applying For</p>
            <p class="font-semibold">{{ $application->applying_for_class }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Guardian Name</p>
            <p class="font-semibold">{{ $application->guardian_name }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 uppercase mb-1">Guardian Phone</p>
            <p class="font-semibold">{{ $application->guardian_phone }}</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('parent.admissions.index') }}"
           class="text-gray-500 hover:text-gray-700 text-sm">← Back to Applications</a>
    </div>

</div>

@endsection