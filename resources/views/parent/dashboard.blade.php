@extends('layouts.portal')

@section('page_title', 'Parent Dashboard')
@section('page_subtitle', 'Welcome back — here is your child\'s overview')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Welcome --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <h3 class="text-base font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h3>
        <p class="text-sm text-gray-500 mt-0.5">Track your child's progress and stay updated with school activities.</p>
    </div>

    @if($child)

    {{-- Child Info Strip --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <div class="flex items-center gap-4">
            <x-avatar :photo="$child->photo" :name="$child->full_name" size="lg" />
            <div class="min-w-0 flex-1">
                <h4 class="text-base font-bold text-gray-900">{{ $child->full_name }}</h4>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $child->admission_number }} •
                    {{ $child->class ?? 'No Class' }} •
                    {{ ucfirst($child->gender) }}
                </p>
                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                    {{ $child->status === 'active' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                    {{ ucfirst($child->status) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Attendance Rate</p>
            @if($attendanceSummary && $attendanceSummary['total'] > 0)
            @php $rate = round(($attendanceSummary['present'] / $attendanceSummary['total']) * 100); @endphp
            <p class="text-3xl font-bold mt-2
                {{ $rate >= 75 ? 'text-green-600' : ($rate >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $rate }}%
            </p>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $attendanceSummary['present'] }} present of {{ $attendanceSummary['total'] }} days
            </p>
            @else
            <p class="text-2xl font-bold text-gray-400 mt-2">N/A</p>
            <p class="text-xs text-gray-400 mt-0.5">No records yet</p>
            @endif
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('parent.attendance') }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800">
                    View details →
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Report Card</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $child->class ?? 'N/A' }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Current class</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('parent.report-card') }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800">
                    View marks →
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Dormitory</p>
            <p class="text-sm font-bold text-gray-900 mt-2">
                {{ $child->dormitory ? explode('|', $child->dormitory)[0] : 'Not Assigned' }}
            </p>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $child->dormitory ? trim(str_replace(explode('|', $child->dormitory)[0], '', $child->dormitory), '| ') : '—' }}
            </p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('parent.dormitory') }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800">
                    View details →
                </a>
            </div>
        </div>

    </div>

    @else

    {{-- No child yet --}}
    @if($application)
    <div class="bg-white rounded-xl border border-gray-200 p-8 mb-5 text-center">
        <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h4 class="text-sm font-bold text-gray-800 mb-1">Application Pending</h4>
        <p class="text-xs text-gray-500 mb-4">
            Your child's application is <strong>{{ $application->status }}</strong>.
            Once approved, their profile will appear here.
        </p>
        <a href="{{ route('parent.admissions.show', $application) }}"
           class="inline-flex items-center px-4 py-2 bg-blue-900 text-white text-xs font-semibold
                  rounded-lg hover:bg-blue-800 transition-colors border border-blue-900">
            View Application
        </a>
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-200 p-8 mb-5 text-center">
        <h4 class="text-sm font-bold text-gray-800 mb-1">No Application Yet</h4>
        <p class="text-xs text-gray-500 mb-4">Apply for your child's admission to get started.</p>
        <a href="{{ route('parent.admissions.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-900 text-white text-xs font-semibold
                  rounded-lg hover:bg-blue-800 transition-colors border border-blue-900">
            Apply Now
        </a>
    </div>
    @endif

    @endif

    {{-- Visit Hours & School Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Parent Visiting Hours --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-blue-50">
                <h4 class="text-sm font-bold text-blue-900">Parent Visiting Hours</h4>
                <p class="text-xs text-blue-700 mt-0.5">When you can visit the school physically</p>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="px-5 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Monday</p>
                        <p class="text-xs text-gray-500">Administrative queries & meetings</p>
                    </div>
                    <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200
                                 text-xs font-semibold rounded-lg">
                        9:00 AM — 2:00 PM
                    </span>
                </div>
                <div class="px-5 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Wednesday</p>
                        <p class="text-xs text-gray-500">Academic consultations with teachers</p>
                    </div>
                    <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200
                                 text-xs font-semibold rounded-lg">
                        10:00 AM — 1:00 PM
                    </span>
                </div>
                <div class="px-5 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Friday</p>
                        <p class="text-xs text-gray-500">General visits & student welfare</p>
                    </div>
                    <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200
                                 text-xs font-semibold rounded-lg">
                        9:00 AM — 12:00 PM
                    </span>
                </div>
                <div class="px-5 py-3 bg-gray-50">
                    <p class="text-xs text-gray-500">
                        Please carry a valid ID when visiting. All visits must be recorded at the reception.
                        For urgent matters contact the school office.
                    </p>
                </div>
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-gray-800">Upcoming Events</h4>
                    <p class="text-xs text-gray-400 mt-0.5">School activities & important dates</p>
                </div>
                <a href="{{ route('parent.events') }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800">
                    View all →
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($upcomingEvents->take(4) as $event)
                <div class="px-5 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100
                                flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $event->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('D, d M Y') }}
                            @if($event->location) • {{ $event->location }} @endif
                        </p>
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-400">No upcoming events</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection