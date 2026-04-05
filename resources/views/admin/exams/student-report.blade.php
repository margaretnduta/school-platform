@extends('layouts.admin')

@section('page_title', 'Student Report')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.exams.show', $exam) }}" class="text-primary-600 hover:text-primary-700 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Analysis
    </a>
    <h1 class="text-3xl font-bold text-gray-900">📈 Student Statistics Report</h1>
    <p class="text-gray-600 mt-1">{{ $student->full_name }} - {{ $exam->name }}</p>
</div>

<!-- Student Info & Eligibility -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <x-card>
        <x-card-body>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">👤 Student Information</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Full Name:</span>
                    <span class="font-semibold text-gray-900">{{ $student->full_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Admission Number:</span>
                    <span class="font-semibold text-gray-900">{{ $student->admission_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email:</span>
                    <span class="font-semibold text-gray-900">{{ $student->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Class:</span>
                    <span class="font-semibold text-gray-900">{{ $student->class }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Gender:</span>
                    <span class="font-semibold text-gray-900">{{ $student->gender }}</span>
                </div>
            </div>
        </x-card-body>
    </x-card>

    <x-card :class="$isEligible ? 'border-l-4 border-success-500' : 'border-l-4 border-danger-500'">
        <x-card-body>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">✅ Exam Eligibility</h3>
            <div class="space-y-4">
                <div class="text-center p-4 rounded-lg" :class="$isEligible ? 'bg-success-50' : 'bg-danger-50'">
                    <p class="text-sm font-medium" :class="$isEligible ? 'text-success-700' : 'text-danger-700'">
                        {{ $isEligible ? 'ELIGIBLE FOR EXAM' : 'NOT ELIGIBLE FOR EXAM' }}
                    </p>
                    <p class="text-3xl font-bold mt-2" :class="$isEligible ? 'text-success-600' : 'text-danger-600'">
                        {{ number_format($attendancePercentage, 1) }}%
                    </p>
                    <p class="text-xs text-gray-600 mt-1">Attendance Rate</p>
                </div>
                
                <div class="text-center text-sm">
                    <p class="text-gray-600">Requirement: 80% or higher</p>
                    @if (!$isEligible)
                        <p class="text-danger-600 font-semibold mt-1">
                            Shortfall: {{ number_format(80 - $attendancePercentage, 1) }}%
                        </p>
                    @endif
                </div>
            </div>
        </x-card-body>
    </x-card>
</div>

<!-- Exam Results if Eligible -->
@if ($isEligible && $results->count() > 0)
    <!-- Results Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-card>
            <x-card-body class="text-center">
                <p class="text-gray-600 text-sm font-medium">Total Subjects</p>
                <p class="text-4xl font-bold text-primary-600 mt-2">{{ $results->count() }}</p>
            </x-card-body>
        </x-card>

        <x-card>
            <x-card-body class="text-center">
                <p class="text-gray-600 text-sm font-medium">Total Marks</p>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalMarks }}</p>
                <p class="text-xs text-gray-500 mt-1">out of {{ $results->count() * 100 }}</p>
            </x-card-body>
        </x-card>

        <x-card>
            <x-card-body class="text-center">
                <p class="text-gray-600 text-sm font-medium">Average Percentage</p>
                <p class="text-4xl font-bold text-success-600 mt-2">{{ number_format($averagePercentage, 1) }}%</p>
            </x-card-body>
        </x-card>

        <x-card>
            <x-card-body class="text-center">
                <p class="text-gray-600 text-sm font-medium">Grade Distribution</p>
                <div class="flex justify-center gap-1 mt-2">
                    @foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $grade)
                        @if (isset($gradeBreakdown[$grade]))
                            <span class="px-2 py-1 rounded bg-primary-100 text-primary-700 text-xs font-semibold">
                                {{ $grade }}: {{ $gradeBreakdown[$grade] }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </x-card-body>
        </x-card>
    </div>

    <!-- Detailed Results Table -->
    <x-card>
        <x-card-header>
            <h3 class="text-lg font-semibold text-gray-900">📊 Subject-wise Results</h3>
        </x-card-header>
        <x-card-body>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Subject</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Marks</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Percentage</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Grade</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results->sortByDesc('marks_obtained') as $result)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-semibold text-gray-900">{{ $result->subject }}</td>
                                <td class="px-4 py-4 text-center text-gray-900">
                                    <span class="font-semibold">{{ $result->marks_obtained }}/{{ $result->total_marks }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $result->percentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ number_format($result->percentage, 1) }}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <x-badge :color="match($result->grade) {
                                        'A' => 'success',
                                        'B' => 'primary',
                                        'C' => 'warning',
                                        'D', 'E' => 'danger',
                                        'F' => 'danger',
                                        default => 'gray'
                                    }">
                                        {{ $result->grade }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600">{{ $result->comments }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card-body>
    </x-card>
@elseif ($results->count() == 0)
    <x-card>
        <x-card-body class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">📋 No exam results recorded for this student yet</p>
            <p class="text-gray-400">Results will appear here once they are uploaded</p>
        </x-card-body>
    </x-card>
@else
    <x-card>
        <x-card-body class="text-center py-12">
            <p class="text-danger-600 text-lg mb-4">⚠️ Student is not eligible to sit for this exam</p>
            <p class="text-gray-500">Attendance must be 80% or higher to be eligible for exams</p>
        </x-card-body>
    </x-card>
@endif

@endsection
