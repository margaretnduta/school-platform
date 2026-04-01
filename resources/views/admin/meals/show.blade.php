@extends('layouts.admin')

@section('page_title', 'Meal Session Details')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-blue-900 capitalize">
                    {{ $meal->session_name }} — {{ $meal->class }}
                </h3>
                <p class="text-sm text-gray-500 mt-1">{{ $meal->date->format('l, d F Y') }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="bg-green-50 rounded-lg p-3">
                    <p class="text-2xl font-bold text-green-600">{{ $meal->taken_count }}</p>
                    <p class="text-xs text-gray-500">Taken</p>
                </div>
                <div class="bg-red-50 rounded-lg p-3">
                    <p class="text-2xl font-bold text-red-500">{{ $meal->not_taken_count }}</p>
                    <p class="text-xs text-gray-500">Not Taken</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adm. No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($meal->records as $index => $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                        {{ $record->student->full_name }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-blue-900">
                        {{ $record->student->admission_number }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $record->status == 'taken' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $record->status == 'taken' ? '✅ Taken' : '❌ Not Taken' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $record->remarks ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.meals.student', $record->student->id) }}"
                           class="text-blue-600 hover:underline text-xs">
                            📊 View Profile
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.meals.report') }}"
           class="text-gray-500 hover:text-gray-700 text-sm">← Back to Report</a>
    </div>

</div>

@endsection