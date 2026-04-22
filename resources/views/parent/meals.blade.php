@extends('layouts.portal')

@section('page_title', 'Meal Records')
@section('page_subtitle', 'Your child\'s meal history')

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
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Records</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Meals Taken</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $taken }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Not Taken</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $notTaken }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Meal Rate</p>
            <p class="text-2xl font-bold mt-1
                {{ $mealRate >= 80 ? 'text-green-600' : ($mealRate >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $mealRate }}%
            </p>
        </div>
    </div>

    {{-- Records --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-bold text-gray-800">Meal History</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Session</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700 font-medium">
                        {{ $record->meal->date instanceof \Carbon\Carbon
                            ? $record->meal->date->format('D, d M Y')
                            : \Carbon\Carbon::parse($record->meal->date)->format('D, d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs font-semibold
                            {{ $record->meal->session == 'breakfast' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' :
                              ($record->meal->session == 'lunch'     ? 'bg-blue-50 text-blue-700 border border-blue-200'      :
                                                                       'bg-purple-50 text-purple-700 border border-purple-200') }}">
                            {{ ucfirst($record->meal->session) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $record->status == 'taken'
                                ? 'bg-green-50 text-green-700 border border-green-200'
                                : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ $record->status == 'taken' ? 'Taken' : 'Not Taken' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-400">
                        No meal records found.
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