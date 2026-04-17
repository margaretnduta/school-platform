@extends('layouts.teacher')

@section('page_title', 'Student Profile')
@section('page_subtitle', 'Full overview of student performance and records')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Back --}}
    <div class="mb-4">
        <a href="{{ route('teacher.students') }}"
           class="text-sm text-gray-500 hover:text-gray-700 font-medium">
            ← Back to Students
        </a>
    </div>

    {{-- Student Header --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <x-avatar :photo="$student->photo" :name="$student->full_name" size="lg" />
            <div class="min-w-0 flex-1">
                <h3 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h3>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $student->admission_number }} •
                    {{ $student->class ?? 'No Class' }} •
                    {{ ucfirst($student->gender) }}
                </p>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $student->status === 'active' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $examEligible ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        Exam: {{ $examEligible ? '✅ Eligible' : '❌ Not Eligible' }}
                    </span>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-xs text-gray-400">Attendance Rate</p>
                <p class="text-3xl font-bold
                    {{ $attendanceRate >= 75 ? 'text-green-600' :
                       ($attendanceRate >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                    {{ $attendanceRate }}%
                </p>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

        {{-- Attendance --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Present</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $presentDays }}</p>
            <p class="text-xs text-gray-400 mt-0.5">of {{ $totalDays }} days</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Absent</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $absentDays }}</p>
            <p class="text-xs text-gray-400 mt-0.5">days missed</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Meals Taken</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $takenMeals }}</p>
            <p class="text-xs text-gray-400 mt-0.5">of {{ $totalMeals }} (last 30 days)</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Meal Rate</p>
            <p class="text-2xl font-bold mt-1
                {{ $mealRate >= 80 ? 'text-green-600' :
                   ($mealRate >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $mealRate }}%
            </p>
            <p class="text-xs text-gray-400 mt-0.5">last 30 days</p>
        </div>

    </div>

    {{-- Middle Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Personal Info --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h4 class="text-sm font-semibold text-gray-800">Personal Information</h4>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="px-5 py-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Date of Birth</span>
                    <span class="text-sm font-medium text-gray-800">{{ $student->date_of_birth ?? 'N/A' }}</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Phone</span>
                    <span class="text-sm font-medium text-gray-800">{{ $student->phone ?? 'N/A' }}</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Email</span>
                    <span class="text-sm font-medium text-gray-800">{{ $student->email ?? 'N/A' }}</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Guardian</span>
                    <span class="text-sm font-medium text-gray-800">{{ $student->guardian_name }}</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Guardian Phone</span>
                    <span class="text-sm font-medium text-gray-800">{{ $student->guardian_phone }}</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Dormitory</span>
                    <span class="text-sm font-medium text-gray-800">
                        @if($bed)
                            {{ $bed->dormitory->name }} |
                            {{ $bed->room->room_number }} |
                            {{ $bed->bed_number }} ({{ ucfirst($bed->position) }})
                        @else
                            Not Assigned
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Exam Eligibility --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h4 class="text-sm font-semibold text-gray-800">Exam Eligibility</h4>
            </div>
            <div class="p-5">
                {{-- Eligibility Status --}}
                <div class="flex items-center gap-4 p-4 rounded-lg
                    {{ $examEligible ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}
                    mb-4">
                    <span class="text-3xl">{{ $examEligible ? '✅' : '❌' }}</span>
                    <div>
                        <p class="text-sm font-bold
                            {{ $examEligible ? 'text-green-800' : 'text-red-800' }}">
                            {{ $examEligible ? 'Eligible for Exams' : 'Not Eligible for Exams' }}
                        </p>
                        <p class="text-xs mt-0.5
                            {{ $examEligible ? 'text-green-600' : 'text-red-600' }}">
                            {{ $eligibilityMsg }}
                        </p>
                    </div>
                </div>

                {{-- Attendance Progress Bar --}}
                <div class="mb-4">
                    <div class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                        <span>Attendance Rate</span>
                        <span>{{ $attendanceRate }}% / 75% required</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="h-3 rounded-full transition-all
                            {{ $attendanceRate >= 75 ? 'bg-green-500' :
                               ($attendanceRate >= 50 ? 'bg-yellow-400' : 'bg-red-500') }}"
                             style="width: {{ min($attendanceRate, 100) }}%">
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span>0%</span>
                        <span class="text-orange-500 font-semibold">75% min</span>
                        <span>100%</span>
                    </div>
                </div>

                {{-- Breakdown --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <p class="text-lg font-bold text-green-600">{{ $presentDays }}</p>
                        <p class="text-xs text-gray-500">Present</p>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <p class="text-lg font-bold text-red-500">{{ $absentDays }}</p>
                        <p class="text-xs text-gray-500">Absent</p>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                        <p class="text-lg font-bold text-yellow-500">{{ $lateDays }}</p>
                        <p class="text-xs text-gray-500">Late</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Academic Records --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-800">Academic Records — {{ date('Y') }}</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Subject</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Term</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Marks</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Grade</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($academicRecords as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                        {{ $record->subject->name ?? 'N/A' }}
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">
                        {{ ucwords(str_replace('_', ' ', $record->term)) }}
                    </td>
                    <td class="px-4 py-3 text-center text-sm font-bold text-gray-800">
                        {{ $record->marks }} / {{ $record->total_marks }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded text-xs font-bold
                            {{ in_array($record->grade, ['A','A-','B+']) ? 'bg-green-50 text-green-700' :
                              (in_array($record->grade, ['B','B-','C+']) ? 'bg-blue-50 text-blue-700' :
                              (in_array($record->grade, ['C','C-','D+']) ? 'bg-yellow-50 text-yellow-700' :
                                                                           'bg-red-50 text-red-700')) }}">
                            {{ $record->grade }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $record->status == 'pass' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-400">
                        No academic records found for this year.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent Attendance --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-800">Recent Attendance</h4>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($attendanceRecords->take(10) as $record)
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50">
                <span class="text-sm text-gray-700">
                    {{ $record->date instanceof \Carbon\Carbon
                        ? $record->date->format('d M Y')
                        : \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                </span>
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                    {{ $record->status == 'present' ? 'bg-green-50 text-green-700'    :
                      ($record->status == 'absent'  ? 'bg-red-50 text-red-700'      :
                      ($record->status == 'late'    ? 'bg-yellow-50 text-yellow-700' :
                                                      'bg-blue-50 text-blue-700')) }}">
                    {{ ucfirst($record->status) }}
                </span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">
                No attendance records found.
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection