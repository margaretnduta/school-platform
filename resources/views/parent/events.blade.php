@extends('layouts.portal')

@section('page_title', 'School Events & Dates')
@section('page_subtitle', 'Stay updated with school activities and important dates')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Visit Hours Banner --}}
    <div class="bg-blue-900 rounded-xl p-5 mb-5 text-white">
        <h4 class="text-sm font-bold mb-3">Parent Visiting Hours</h4>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-white/10 rounded-lg p-3 border border-white/20">
                <p class="text-xs font-bold text-blue-200 uppercase tracking-wide">Monday</p>
                <p class="text-sm font-bold text-white mt-1">9:00 AM — 2:00 PM</p>
                <p class="text-xs text-blue-200 mt-0.5">Admin queries & meetings</p>
            </div>
            <div class="bg-white/10 rounded-lg p-3 border border-white/20">
                <p class="text-xs font-bold text-blue-200 uppercase tracking-wide">Wednesday</p>
                <p class="text-sm font-bold text-white mt-1">10:00 AM — 1:00 PM</p>
                <p class="text-xs text-blue-200 mt-0.5">Teacher consultations</p>
            </div>
            <div class="bg-white/10 rounded-lg p-3 border border-white/20">
                <p class="text-xs font-bold text-blue-200 uppercase tracking-wide">Friday</p>
                <p class="text-sm font-bold text-white mt-1">9:00 AM — 12:00 PM</p>
                <p class="text-xs text-blue-200 mt-0.5">General visits & welfare</p>
            </div>
        </div>
        <p class="text-xs text-blue-300 mt-3">
            Carry a valid ID. All visits must be recorded at the reception desk.
        </p>
    </div>

    {{-- Upcoming Events --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-bold text-gray-800">Upcoming Events & Important Dates</h4>
            <p class="text-xs text-gray-400 mt-0.5">Exams, closing days, mid-term breaks and more</p>
        </div>

        @forelse($upcomingEvents as $event)
        <div class="px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition-colors last:border-0">
            <div class="flex items-start gap-4">

                {{-- Date Badge --}}
                <div class="flex-shrink-0 w-12 text-center">
                    <div class="bg-blue-900 rounded-lg px-2 py-1.5">
                        <p class="text-xs font-bold text-blue-200">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                        </p>
                        <p class="text-lg font-bold text-white leading-tight">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                        </p>
                    </div>
                </div>

                {{-- Event Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-sm font-bold text-gray-900">{{ $event->title }}</p>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold flex-shrink-0
                            {{ $event->status == 'upcoming'  ? 'bg-blue-50 text-blue-700 border border-blue-200'   :
                              ($event->status == 'ongoing'   ? 'bg-green-50 text-green-700 border border-green-200' :
                                                               'bg-gray-50 text-gray-500 border border-gray-200') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                    @if($event->description)
                    <p class="text-xs text-gray-500 mt-0.5">{{ $event->description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-3 mt-1.5 text-xs text-gray-400">
                        <span>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}
                        </span>
                        @if($event->location)
                        <span>• {{ $event->location }}</span>
                        @endif
                        @if(isset($event->category) && $event->category)
                        <span>• {{ $event->category }}</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="px-5 py-10 text-center">
            <p class="text-sm text-gray-400">No upcoming events at the moment.</p>
            <p class="text-xs text-gray-400 mt-1">Check back later for school updates.</p>
        </div>
        @endforelse
    </div>

    {{-- Past Events --}}
    @if($pastEvents->count() > 0)
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-bold text-gray-800">Past Events</h4>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($pastEvents as $event)
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $event->title }}</p>
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                        @if($event->location) • {{ $event->location }} @endif
                    </p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold flex-shrink-0 ml-3
                             bg-gray-50 text-gray-500 border border-gray-200">
                    Completed
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection