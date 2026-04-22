@extends('layouts.portal')

@section('page_title', 'Report Card')
@section('page_subtitle', 'Your child\'s academic performance')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Term Selector --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
        <form action="{{ route('parent.report-card') }}" method="GET"
              class="flex flex-wrap gap-3 items-end">
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Term</label>
                <select name="term"
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                    <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                    <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Year</label>
                <select name="year"
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit"
                    class="bg-blue-900 text-white font-semibold text-sm px-5 py-2.5
                           rounded-lg hover:bg-blue-800 transition-colors border border-blue-900">
                View
            </button>
        </form>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Subjects</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $subjectCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Mean Score</p>
            <p class="text-2xl font-bold text-blue-900 mt-1">{{ $meanScore }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Mean Grade</p>
            <p class="text-2xl font-bold mt-1
                {{ in_array($meanGrade, ['A','A-','B+']) ? 'text-green-600' :
                  (in_array($meanGrade, ['B','B-','C+']) ? 'text-blue-600' :
                  (in_array($meanGrade, ['C','C-','D+']) ? 'text-yellow-600' : 'text-red-500')) }}">
                {{ $meanGrade }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Points</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPoints }}</p>
        </div>
    </div>

    {{-- Subject Results --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h4 class="text-sm font-bold text-gray-800">
                {{ $child->full_name }} —
                {{ ucwords(str_replace('_', ' ', $selectedTerm)) }} {{ $selectedYear }}
            </h4>
        </div>
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Subject</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Marks</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Out Of</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Grade</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                        {{ $record->subject->name ?? 'N/A' }}
                    </td>
                    <td class="px-4 py-3 text-center text-sm font-bold text-gray-900">{{ $record->marks }}</td>
                    <td class="px-4 py-3 text-center text-sm text-gray-500">{{ $record->total_marks }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded text-xs font-bold
                            {{ in_array($record->grade, ['A','A-','B+']) ? 'bg-green-50 text-green-700 border border-green-200' :
                              (in_array($record->grade, ['B','B-','C+']) ? 'bg-blue-50 text-blue-700 border border-blue-200' :
                              (in_array($record->grade, ['C','C-','D+']) ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' :
                                                                           'bg-red-50 text-red-700 border border-red-200')) }}">
                            {{ $record->grade }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $record->status == 'pass'
                                ? 'bg-green-50 text-green-700 border border-green-200'
                                : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-400">
                        No results for {{ ucwords(str_replace('_', ' ', $selectedTerm)) }} {{ $selectedYear }}.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection