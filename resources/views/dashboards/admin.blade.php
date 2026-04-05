@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Students Card -->
    <x-card class="border-l-4 border-primary-500">
        <x-card-body>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Students</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $studentCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">Active students enrolled</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center text-2xl">
                    🎓
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.students.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    View all students →
                </a>
            </div>
        </x-card-body>
    </x-card>

    <!-- Staff Card -->
    <x-card class="border-l-4 border-success-500">
        <x-card-body>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Staff</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $staffCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">Teachers & administrators</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-success-100 to-success-200 rounded-lg flex items-center justify-center text-2xl">
                    👨‍🏫
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.staff.index') }}" class="text-success-600 hover:text-success-700 text-sm font-medium">
                    View all staff →
                </a>
            </div>
        </x-card-body>
    </x-card>

    <!-- Classes Card -->
    <x-card class="border-l-4 border-secondary-500">
        <x-card-body>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Classes</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $classCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">School classes</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-secondary-100 to-secondary-200 rounded-lg flex items-center justify-center text-2xl">
                    🏫
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.classes.index') }}" class="text-secondary-600 hover:text-secondary-700 text-sm font-medium">
                    View all classes →
                </a>
            </div>
        </x-card-body>
    </x-card>

    <!-- Pending Admissions Card -->
    <x-card class="border-l-4 border-warning-500">
        <x-card-body>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending Admissions</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $pendingAdmissions }}</p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting review</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-warning-100 to-warning-200 rounded-lg flex items-center justify-center text-2xl">
                    📋
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.admissions.index') }}" class="text-warning-600 hover:text-warning-700 text-sm font-medium">
                    Review admissions →
                </a>
            </div>
        </x-card-body>
    </x-card>

</div>

<!-- Recent Events Section -->
<x-card class="mb-8">
    <x-card-header>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">📅 Recent School Events</h3>
            <p class="text-sm text-gray-600 mt-1">Latest events happening at your school</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
            View all events
        </a>
    </x-card-header>
    <x-card-body>
        @if ($recentEvents->count() > 0)
            <div class="space-y-4">
                @foreach ($recentEvents as $event)
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                        <!-- Event Icon/Badge -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                <span class="text-lg">
                                    @switch ($event->status)
                                        @case ('upcoming')
                                            ⏰
                                        @break
                                        @case ('ongoing')
                                            🔴
                                        @break
                                        @case ('completed')
                                            ✅
                                        @break
                                        @default
                                            ❌
                                    @endswitch
                                </span>
                            </div>
                        </div>

                        <!-- Event Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $event->title }}</h4>
                                <x-badge :color="match($event->status) {
                                    'upcoming' => 'primary',
                                    'ongoing' => 'success',
                                    'completed' => 'gray',
                                    'cancelled' => 'danger',
                                    default => 'gray'
                                }">
                                    {{ ucfirst($event->status) }}
                                </x-badge>
                            </div>
                            <p class="text-xs text-gray-600 mb-2">{{ Str::limit($event->description, 80) }}</p>
                            <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    📅 {{ $event->event_date->format('M d, Y') }}
                                </span>
                                @if ($event->location)
                                    <span class="flex items-center gap-1">
                                        📍 {{ $event->location }}
                                    </span>
                                @endif
                                @if ($event->category)
                                    <span class="flex items-center gap-1">
                                        🏷️ {{ $event->category }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.events.show', $event) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                View →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 mb-4">No events yet</p>
                <a href="{{ route('admin.events.create') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Create your first event
                </a>
            </div>
        @endif
    </x-card-body>
</x-card>

<!-- Exams Section -->
<x-card class="mb-8">
    <x-card-header>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">📚 Exam Management</h3>
            <p class="text-sm text-gray-600 mt-1">Track and manage school exams and eligibility</p>
        </div>
        <a href="{{ route('admin.exams.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
            View all exams
        </a>
    </x-card-header>
    <x-card-body>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Upcoming Exams -->
            <div class="p-4 rounded-lg bg-primary-50 border border-primary-200">
                <p class="text-xs font-semibold text-primary-700 uppercase">Upcoming Exams</p>
                <p class="text-3xl font-bold text-primary-600 mt-2">{{ $upcomingExams->count() }}</p>
                <p class="text-xs text-primary-600 mt-1">Scheduled for future dates</p>
            </div>

            <!-- Ongoing Exams -->
            <div class="p-4 rounded-lg bg-success-50 border border-success-200">
                <p class="text-xs font-semibold text-success-700 uppercase">Ongoing Exams</p>
                <p class="text-3xl font-bold text-success-600 mt-2">{{ $ongoingExams }}</p>
                <p class="text-xs text-success-600 mt-1">Exams in progress</p>
            </div>

            <!-- Completed Exams -->
            <div class="p-4 rounded-lg bg-secondary-50 border border-secondary-200">
                <p class="text-xs font-semibold text-secondary-700 uppercase">Completed Exams</p>
                <p class="text-3xl font-bold text-secondary-600 mt-2">{{ $completedExams }}</p>
                <p class="text-xs text-secondary-600 mt-1">Finished exams</p>
            </div>
        </div>

        @if ($upcomingExams->count() > 0)
            <div class="space-y-3 border-t border-gray-200 pt-4">
                <p class="text-sm font-semibold text-gray-900">Next Scheduled Exams:</p>
                @foreach ($upcomingExams as $exam)
                    <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $exam->name }}</p>
                            <p class="text-xs text-gray-600">{{ $exam->level }} - Stream {{ $exam->stream }} • {{ $exam->start_date->format('M d, Y') }}</p>
                        </div>
                        <a href="{{ route('admin.exams.show', $exam) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Analyze →
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 border-t border-gray-200">
                <p class="text-gray-500 mb-3">No upcoming exams</p>
                <a href="{{ route('admin.exams.create') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Create an exam
                </a>
            </div>
        @endif
    </x-card-body>
</x-card>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <x-card>
        <x-card-header>
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
        </x-card-header>
        <x-card-body>
            <div class="space-y-3">
                <a href="{{ route('admin.students.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 transition">
                    <span class="text-xl">➕</span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Add New Student</p>
                        <p class="text-xs text-gray-600">Register a new student</p>
                    </div>
                </a>
                <a href="{{ route('admin.staff.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-success-50 transition">
                    <span class="text-xl">👤</span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Add New Staff</p>
                        <p class="text-xs text-gray-600">Register a new teacher or staff</p>
                    </div>
                </a>
                <a href="{{ route('admin.admissions.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-warning-50 transition">
                    <span class="text-xl">📝</span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Add Admission</p>
                        <p class="text-xs text-gray-600">Register a new admission application</p>
                    </div>
                </a>
                <a href="{{ route('admin.exams.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition">
                    <span class="text-xl">📚</span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Create Exam</p>
                        <p class="text-xs text-gray-600">Set up a new school exam</p>
                    </div>
                </a>
                <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-secondary-50 transition">
                    <span class="text-xl">📅</span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Create Event</p>
                        <p class="text-xs text-gray-600">Announce a new school event</p>
                    </div>
                </a>
            </div>
        </x-card-body>
    </x-card>

    <x-card>
        <x-card-header>
            <h3 class="text-lg font-semibold text-gray-900">System Status</h3>
        </x-card-header>
        <x-card-body>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Database Status</span>
                    <x-badge color="success">Healthy</x-badge>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">API Status</span>
                    <x-badge color="success">Online</x-badge>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Last Updated</span>
                    <span class="text-sm text-gray-600">Just now</span>
                </div>
            </div>
        </x-card-body>
    </x-card>
</div>

@endsection