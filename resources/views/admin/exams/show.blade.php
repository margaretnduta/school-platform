@extends('layouts.admin')

@section('page_title', 'Analyze Exam')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.exams.index') }}" class="text-primary-600 hover:text-primary-700 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Exams
    </a>
    <h1 class="text-3xl font-bold text-gray-900">📊 Exam Analysis</h1>
    <p class="text-gray-600 mt-1">{{ $exam->name }} - {{ $exam->level }} Stream {{ $exam->stream }}</p>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <x-card>
        <x-card-body class="text-center">
            <p class="text-gray-600 text-sm font-medium">Total Students</p>
            <p class="text-5xl font-bold text-primary-600 mt-2">{{ count($eligible) + count($ineligible) }}</p>
        </x-card-body>
    </x-card>

    <x-card class="border-l-4 border-success-500">
        <x-card-body class="text-center">
            <p class="text-gray-600 text-sm font-medium">Eligible Students</p>
            <p class="text-5xl font-bold text-success-600 mt-2">{{ count($eligible) }}</p>
            <p class="text-xs text-gray-500 mt-1">80%+ attendance</p>
        </x-card-body>
    </x-card>

    <x-card class="border-l-4 border-danger-500">
        <x-card-body class="text-center">
            <p class="text-gray-600 text-sm font-medium">Ineligible Students</p>
            <p class="text-5xl font-bold text-danger-600 mt-2">{{ count($ineligible) }}</p>
            <p class="text-xs text-gray-500 mt-1">Below 80% attendance</p>
        </x-card-body>
    </x-card>
</div>

<!-- Eligible Students Section -->
<x-card class="mb-8">
    <x-card-header class="bg-gradient-to-r from-success-50 to-success-100 border-b-2 border-success-300">
        <div>
            <h3 class="text-lg font-semibold text-success-900">✅ Eligible Students ({{ count($eligible) }})</h3>
            <p class="text-sm text-success-700 mt-1">Students with 80% or higher attendance</p>
        </div>
    </x-card-header>
    <x-card-body>
        @if (count($eligible) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Admission No.</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Attendance</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eligible as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-4 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item['student']->full_name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item['student']->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-900">{{ $item['student']->admission_number }}</td>
                                <td class="px-4 py-4 text-center">
                                    <x-badge color="success">
                                        {{ number_format($item['attendance'], 1) }}%
                                    </x-badge>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('admin.exams.student-report', [$exam, $item['student']]) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                        View Report
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">No eligible students found</p>
        @endif
    </x-card-body>
</x-card>

<!-- Ineligible Students Section -->
<x-card>
    <x-card-header class="bg-gradient-to-r from-danger-50 to-danger-100 border-b-2 border-danger-300">
        <div>
            <h3 class="text-lg font-semibold text-danger-900">❌ Ineligible Students ({{ count($ineligible) }})</h3>
            <p class="text-sm text-danger-700 mt-1">Students with below 80% attendance</p>
        </div>
    </x-card-header>
    <x-card-body>
        @if (count($ineligible) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Admission No.</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Attendance</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Shortfall</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ineligible as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-4 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item['student']->full_name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item['student']->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-900">{{ $item['student']->admission_number }}</td>
                                <td class="px-4 py-4 text-center">
                                    <x-badge color="danger">
                                        {{ number_format($item['attendance'], 1) }}%
                                    </x-badge>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="text-red-600 font-semibold">{{ number_format(80 - $item['attendance'], 1) }}%</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">All students are eligible!</p>
        @endif
    </x-card-body>
</x-card>

@endsection
