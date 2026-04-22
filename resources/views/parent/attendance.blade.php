@extends('layouts.portal')

@section('page_title', 'Attendance Records')
@section('page_subtitle', 'Your child\'s attendance history')

@section('content')

<div class="max-w-4xl mx-auto">

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

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Days</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Present</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $present }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Absent</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $absent }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Rate</p>
            <p class="text-2xl font-bold mt-1
                {{ $rate >= 75 ? 'text-green-600' : ($rate >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $rate }}%
            </p>
        </div>
    </div>

    {{-- Rate Bar --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <div class="flex justify-between text-xs font-semibold text-gray-600 mb-2">
            <span>Attendance Rate</span>
            <span>{{ $rate }}% / 75% required for exams</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="h-3 rounded-full transition-all
                {{ $rate >= 75 ? 'bg-green-500' : ($rate >= 50 ? 'bg-yellow-400' : 'bg-red-500') }}"
                 style="width: {{ min($rate, 100) }}%">
            </div>
        </div>
        <p class="text-xs mt-2
            {{ $rate >= 75 ? 'text-green-600' : 'text-red-600' }} font-medium">
            @if($rate >= 75) Your child meets the minimum attendance requirement.
            @else Your child does not meet the 75% minimum attendance requirement for exams.
            @endif
        </p>
    </div>

    {{-- Records Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-bold text-gray-800">Attendance History</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700 font-medium">
                        {{ $record->date instanceof \Carbon\Carbon
                            ? $record->date->format('D, d M Y')
                            : \Carbon\Carbon::parse($record->date)->format('D, d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $record->status == 'present' ? 'bg-green-50 text-green-700 border border-green-200' :
                              ($record->status == 'absent'  ? 'bg-red-50 text-red-700 border border-red-200'     :
                              ($record->status == 'late'    ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' :
                                                              'bg-blue-50 text-blue-700 border border-blue-200')) }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $record->remarks ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-400">
                        No attendance records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $records->links() }}
        </div>
    </div>

</div>

@endsection