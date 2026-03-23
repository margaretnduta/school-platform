@extends('layouts.portal')

@section('page_title', 'My Applications')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">My Admission Applications</h3>
    <a href="{{ route('parent.admissions.create') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        + New Application
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">App. No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Child Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class Applied</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($applications as $app)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-blue-900">{{ $app->application_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $app->full_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $app->applying_for_class }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $app->status == 'pending'  ? 'bg-yellow-100 text-yellow-700' :
                           ($app->status == 'approved' ? 'bg-green-100 text-green-700'  : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($app->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('parent.admissions.show', $app) }}"
                       class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                    No applications yet.
                    <a href="{{ route('parent.admissions.create') }}" class="text-blue-600 hover:underline ml-1">
                        Apply now
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection