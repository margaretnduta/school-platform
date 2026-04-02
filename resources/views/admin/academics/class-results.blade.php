@extends('layouts.admin')

@section('page_title', 'Class Results')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Class Results</h3>
    <a href="{{ route('admin.academics.enter-marks') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition text-sm">
        ✏️ Enter Marks
    </a>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('admin.academics.class-results') }}" method="GET"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
            <select name="class"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Select Class —</option>
                @foreach($classes as $class)
                    <option value="{{ $class->name }}"
                        {{ $selectedClass == $class->name ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Term</label>
            <select name="term"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Select Term —</option>
                <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
            <select name="year"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                View Results
            </button>
        </div>

    </form>
</div>

@if($results->count() > 0)

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <div class="px-6 py-4 border-b border-gray-200">
        <h4 class="font-semibold text-gray-700">
            {{ $selectedClass }} —
            {{ ucwords(str_replace('_', ' ', $selectedTerm)) }} —
            {{ $selectedYear }}
        </h4>
        <p class="text-xs text-gray-400 mt-1">Ranked by total points (highest first)</p>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adm. No</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Subjects</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Mean Score</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Mean Grade</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Points</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($results as $index => $result)
            <tr class="hover:bg-gray-50 {{ $index == 0 ? 'bg-yellow-50' : '' }}">
                <td class="px-4 py-3 text-sm font-bold
                    {{ $index == 0 ? 'text-yellow-600' :
                      ($index == 1 ? 'text-gray-400' :
                      ($index == 2 ? 'text-orange-400' : 'text-gray-500')) }}">
                    @if($index == 0) 🥇
                    @elseif($index == 1) 🥈
                    @elseif($index == 2) 🥉
                    @else {{ $index + 1 }}
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <x-avatar :photo="$result['student']->photo"
                                  :name="$result['student']->full_name"
                                  size="xs" />
                        <span class="text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{ $result['student']->full_name }}
                        </span>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-blue-900 font-medium">
                    {{ $result['student']->admission_number }}
                </td>
                <td class="px-4 py-3 text-sm text-center text-gray-500">
                    {{ $result['subject_count'] }}
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm font-bold text-blue-900">{{ $result['mean_score'] }}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 text-xs rounded-full font-bold
                        {{ in_array($result['mean_grade'], ['A','A-','B+']) ? 'bg-green-100 text-green-700' :
                          (in_array($result['mean_grade'], ['B','B-','C+']) ? 'bg-blue-100 text-blue-700' :
                          (in_array($result['mean_grade'], ['C','C-','D+']) ? 'bg-yellow-100 text-yellow-700' :
                                                                              'bg-red-100 text-red-700')) }}">
                        {{ $result['mean_grade'] }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm font-bold text-gray-700">{{ $result['total_points'] }}</span>
                </td>
                <td class="px-4 py-3 text-sm">
                    <a href="{{ route('admin.academics.report-card', $result['student']->id) }}?term={{ $selectedTerm }}&year={{ $selectedYear }}"
                       class="text-blue-600 hover:underline text-xs whitespace-nowrap">
                        📄 Report Card
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@elseif($selectedClass && $selectedTerm)
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-4xl mb-3">📊</p>
    <p class="font-medium">No results found for this selection.</p>
    <p class="text-sm mt-1">Enter marks first using the Enter Marks page.</p>
</div>

@else
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-5xl mb-4">📊</p>
    <p class="font-medium text-lg">Select a class, term and year to view results.</p>
</div>
@endif

@endsection