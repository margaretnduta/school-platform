@extends('layouts.admin')

@section('page_title', 'Admissions')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Admissions Applications</h3>
    <a href="{{ route('admin.admissions.create') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        + New Application
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">⏳</div>
        <div>
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $pending->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">✅</div>
        <div>
            <p class="text-sm text-gray-500">Approved</p>
            <p class="text-2xl font-bold text-green-600">{{ $approved->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">❌</div>
        <div>
            <p class="text-sm text-gray-500">Rejected</p>
            <p class="text-2xl font-bold text-red-600">{{ $rejected->count() }}</p>
        </div>
    </div>
</div>

{{-- Pending Applications --}}
<div class="bg-white rounded-xl shadow overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
        <h4 class="font-semibold text-yellow-800">⏳ Pending Applications ({{ $pending->count() }})</h4>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">App. No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applying For</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guardian</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($pending as $application)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-blue-900">{{ $application->application_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $application->full_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500 capitalize">{{ $application->gender }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $application->applying_for_class }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $application->guardian_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.admissions.show', $application) }}"
                       class="bg-blue-900 text-white px-3 py-1 rounded text-xs hover:bg-blue-800">
                        Review
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-6 text-center text-gray-400">No pending applications.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Approved Applications --}}
<div class="bg-white rounded-xl shadow overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
        <h4 class="font-semibold text-green-800">✅ Approved Applications ({{ $approved->count() }})</h4>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">App. No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class Assigned</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adm. Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approved On</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($approved as $application)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-blue-900">{{ $application->application_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $application->full_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $application->student?->class ?? 'N/A' }}</td>
                <td class="px-6 py-4 text-sm text-green-700 font-semibold">
                    {{ $application->student?->admission_number ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $application->reviewed_at?->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.admissions.show', $application) }}"
                       class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-6 text-center text-gray-400">No approved applications yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Rejected Applications --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
        <h4 class="font-semibold text-red-800">❌ Rejected Applications ({{ $rejected->count() }})</h4>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">App. No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rejected On</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($rejected as $application)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-blue-900">{{ $application->application_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $application->full_name }}</td>
                <td class="px-6 py-4 text-sm text-red-600">{{ $application->rejection_reason }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $application->reviewed_at?->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.admissions.show', $application) }}"
                       class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-6 text-center text-gray-400">No rejected applications.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection