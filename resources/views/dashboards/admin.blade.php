@extends('layouts.admin')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Welcome back — here is what is happening today')

@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

    {{-- Students --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Students</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $studentCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Active enrolled students</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                🎓
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <a href="{{ route('admin.students.index') }}"
               class="text-xs font-semibold text-blue-700 hover:text-blue-800 transition-colors">
                View all students →
            </a>
        </div>
    </div>

    {{-- Staff --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Staff</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $staffCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Teachers & administrators</p>
            </div>
            <div class="w-11 h-11 bg-green-50 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                👨‍🏫
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <a href="{{ route('admin.staff.index') }}"
               class="text-xs font-semibold text-green-700 hover:text-green-800 transition-colors">
                View all staff →
            </a>
        </div>
    </div>

    {{-- Classes --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Classes</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $classCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Active school classes</p>
            </div>
            <div class="w-11 h-11 bg-purple-50 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                🏫
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <a href="{{ route('admin.classes.index') }}"
               class="text-xs font-semibold text-purple-700 hover:text-purple-800 transition-colors">
                View all classes →
            </a>
        </div>
    </div>

    {{-- Pending Admissions --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending Admissions</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingAdmissions }}</p>
                <p class="text-xs text-gray-400 mt-1">Awaiting review</p>
            </div>
            <div class="w-11 h-11 rounded-lg flex items-center justify-center text-xl flex-shrink-0
                        {{ $pendingAdmissions > 0 ? 'bg-orange-50' : 'bg-gray-50' }}">
                📋
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <a href="{{ route('admin.admissions.index') }}"
               class="text-xs font-semibold text-orange-700 hover:text-orange-800 transition-colors">
                Review admissions →
            </a>
        </div>
    </div>

</div>

{{-- Middle Row --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

    {{-- Exam Stats --}}
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-800">Exam Overview</h3>
            <a href="{{ route('admin.exams.index') }}"
               class="text-xs text-blue-700 hover:text-blue-800 font-semibold transition-colors">
                View all →
            </a>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="text-sm">📅</span>
                    <span class="text-xs font-medium text-gray-700">Upcoming</span>
                </div>
                <span class="text-lg font-bold text-blue-700">{{ $upcomingExams->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="text-sm">🔴</span>
                    <span class="text-xs font-medium text-gray-700">Ongoing</span>
                </div>
                <span class="text-lg font-bold text-green-700">{{ $ongoingExams }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="text-sm">✅</span>
                    <span class="text-xs font-medium text-gray-700">Completed</span>
                </div>
                <span class="text-lg font-bold text-gray-700">{{ $completedExams }}</span>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="space-y-2">
            <a href="{{ route('admin.students.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg border border-gray-100
                      hover:bg-blue-50 hover:border-blue-200 transition-colors group">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-sm flex-shrink-0">
                    ➕
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800 group-hover:text-blue-800">Add New Student</p>
                    <p class="text-xs text-gray-400">Register a new student</p>
                </div>
            </a>
            <a href="{{ route('admin.staff.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg border border-gray-100
                      hover:bg-green-50 hover:border-green-200 transition-colors group">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-sm flex-shrink-0">
                    👤
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800 group-hover:text-green-800">Add New Staff</p>
                    <p class="text-xs text-gray-400">Register a new teacher or staff</p>
                </div>
            </a>
            <a href="{{ route('admin.attendance.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg border border-gray-100
                      hover:bg-teal-50 hover:border-teal-200 transition-colors group">
                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center text-sm flex-shrink-0">
                    ✅
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800 group-hover:text-teal-800">Take Attendance</p>
                    <p class="text-xs text-gray-400">Mark today's attendance</p>
                </div>
            </a>
            <a href="{{ route('admin.events.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg border border-gray-100
                      hover:bg-purple-50 hover:border-purple-200 transition-colors group">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-sm flex-shrink-0">
                    📅
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800 group-hover:text-purple-800">Create Event</p>
                    <p class="text-xs text-gray-400">Announce a new school event</p>
                </div>
            </a>
        </div>
    </div>

    {{-- System Status --}}
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-800 mb-4">System Status</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-xs text-gray-600">Database</span>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-50
                             text-xs font-semibold text-green-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Healthy
                </span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-xs text-gray-600">Application</span>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-50
                             text-xs font-semibold text-green-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Online
                </span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-xs text-gray-600">Storage</span>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-50
                             text-xs font-semibold text-green-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Available
                </span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-xs text-gray-600">Last Updated</span>
                <span class="text-xs text-gray-500">{{ now()->format('H:i') }}</span>
            </div>
        </div>

        {{-- Module Links --}}
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Reports</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('admin.attendance.report') }}"
                   class="text-center px-2 py-2 bg-gray-50 border border-gray-200 rounded-lg
                          text-xs font-medium text-gray-700 hover:bg-blue-50 hover:border-blue-200
                          hover:text-blue-700 transition-colors">
                    Attendance
                </a>
                <a href="{{ route('admin.meals.report') }}"
                   class="text-center px-2 py-2 bg-gray-50 border border-gray-200 rounded-lg
                          text-xs font-medium text-gray-700 hover:bg-orange-50 hover:border-orange-200
                          hover:text-orange-700 transition-colors">
                    Meals
                </a>
                <a href="{{ route('admin.academics.class-results') }}"
                   class="text-center px-2 py-2 bg-gray-50 border border-gray-200 rounded-lg
                          text-xs font-medium text-gray-700 hover:bg-purple-50 hover:border-purple-200
                          hover:text-purple-700 transition-colors">
                    Academics
                </a>
                <a href="{{ route('admin.admissions.index') }}"
                   class="text-center px-2 py-2 bg-gray-50 border border-gray-200 rounded-lg
                          text-xs font-medium text-gray-700 hover:bg-green-50 hover:border-green-200
                          hover:text-green-700 transition-colors">
                    Admissions
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Bottom Row — Events & Upcoming Exams --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- Recent Events --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">Recent Events</h3>
                <p class="text-xs text-gray-400 mt-0.5">Latest school events</p>
            </div>
            <a href="{{ route('admin.events.index') }}"
               class="text-xs font-semibold text-blue-700 hover:text-blue-800 transition-colors">
                View all →
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentEvents as $event)
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-sm flex-shrink-0">
                        @if($event->status === 'upcoming') 🕐
                        @elseif($event->status === 'ongoing') 🔴
                        @elseif($event->status === 'completed') ✅
                        @else 📅
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $event->title }}</p>
                        <p class="text-xs text-gray-400">
                            {{ isset($event->event_date) ? \Carbon\Carbon::parse($event->event_date)->format('d M Y') : 'No date' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0 ml-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $event->status === 'upcoming'  ? 'bg-blue-50 text-blue-700'   :
                          ($event->status === 'ongoing'   ? 'bg-red-50 text-red-700'     :
                          ($event->status === 'completed' ? 'bg-green-50 text-green-700' :
                                                            'bg-gray-50 text-gray-500')) }}">
                        {{ ucfirst($event->status) }}
                    </span>
                    <a href="{{ route('admin.events.show', $event) }}"
                       class="text-xs text-blue-700 hover:text-blue-800 font-semibold">
                        View →
                    </a>
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center">
                <p class="text-sm text-gray-400 mb-2">No events yet</p>
                <a href="{{ route('admin.events.create') }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800">
                    Create your first event →
                </a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Upcoming Exams --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Exams</h3>
                <p class="text-xs text-gray-400 mt-0.5">Next scheduled exams</p>
            </div>
            <a href="{{ route('admin.exams.index') }}"
               class="text-xs font-semibold text-blue-700 hover:text-blue-800 transition-colors">
                View all →
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($upcomingExams as $exam)
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-sm flex-shrink-0">
                        📝
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $exam->name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $exam->level }} •
                            {{ $exam->start_date instanceof \Carbon\Carbon ? $exam->start_date->format('d M Y') : \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.exams.show', $exam) }}"
                   class="text-xs text-blue-700 hover:text-blue-800 font-semibold flex-shrink-0 ml-3">
                    Analyze →
                </a>
            </div>
            @empty
            <div class="px-5 py-10 text-center">
                <p class="text-sm text-gray-400 mb-2">No upcoming exams</p>
                <a href="{{ route('admin.exams.create') }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800">
                    Create an exam →
                </a>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection