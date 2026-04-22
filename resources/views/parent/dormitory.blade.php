@extends('layouts.portal')

@section('page_title', 'Dormitory')
@section('page_subtitle', 'Your child\'s accommodation details')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Child Header --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <div class="flex items-center gap-3">
            <x-avatar :photo="$child->photo" :name="$child->full_name" size="md" />
            <div>
                <h4 class="text-sm font-bold text-gray-900">{{ $child->full_name }}</h4>
                <p class="text-xs text-gray-500">{{ $child->admission_number }} • {{ $child->class }}</p>
            </div>
        </div>
    </div>

    @if($bed)

    {{-- Bed Assignment --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-gray-100 bg-blue-50">
            <h4 class="text-sm font-bold text-blue-900">Dormitory Assignment</h4>
            <p class="text-xs text-blue-700 mt-0.5">Your child's current bed allocation</p>
        </div>
        <div class="divide-y divide-gray-100">
            <div class="px-5 py-3 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Dormitory</span>
                <span class="text-sm font-semibold text-gray-900">{{ $bed->dormitory->name }}</span>
            </div>
            <div class="px-5 py-3 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Gender</span>
                <span class="text-sm font-semibold text-gray-900 capitalize">{{ $bed->dormitory->gender }}</span>
            </div>
            <div class="px-5 py-3 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Room Number</span>
                <span class="text-sm font-semibold text-gray-900">{{ $bed->room->room_number }}</span>
            </div>
            <div class="px-5 py-3 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Bed Number</span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $bed->bed_number }} ({{ ucfirst($bed->position) }} bunk)
                </span>
            </div>
            @if($bed->dormitory->warden_name)
            <div class="px-5 py-3 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Warden</span>
                <span class="text-sm font-semibold text-gray-900">{{ $bed->dormitory->warden_name }}</span>
            </div>
            @endif
            @if($bed->dormitory->warden_phone)
            <div class="px-5 py-3 flex justify-between items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Warden Phone</span>
                <span class="text-sm font-semibold text-blue-700">{{ $bed->dormitory->warden_phone }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Dorm Rules --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h4 class="text-sm font-bold text-gray-800 mb-3">Dormitory Guidelines</h4>
        <ul class="space-y-2 text-xs text-gray-600">
            <li class="flex items-start gap-2">
                <span class="text-green-500 font-bold mt-0.5">•</span>
                Lights out is at 10:00 PM on weekdays and 10:30 PM on weekends.
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500 font-bold mt-0.5">•</span>
                Students must keep their bed area clean and tidy at all times.
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500 font-bold mt-0.5">•</span>
                No visitors are allowed inside dormitories.
            </li>
            <li class="flex items-start gap-2">
                <span class="text-green-500 font-bold mt-0.5">•</span>
                Any issues should be reported to the warden immediately.
            </li>
        </ul>
    </div>

    @else

    <div class="bg-white rounded-xl border border-gray-200 p-10 text-center">
        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-gray-700 mb-1">No Dormitory Assigned</p>
        <p class="text-xs text-gray-400">Your child has not been assigned a dormitory yet. Contact the school administration for assistance.</p>
    </div>

    @endif

</div>

@endsection