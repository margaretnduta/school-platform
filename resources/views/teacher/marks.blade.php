@extends('layouts.teacher')

@section('page_title', 'Enter Marks')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Enter Marks</h3>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('teacher.marks') }}" method="GET"
          class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
            <select name="class" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                <option value="">— Class —</option>
                @foreach($myClasses as $className)
                    <option value="{{ $className }}"
                        {{ $selectedClass == $className ? 'selected' : '' }}>
                        {{ $className }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
            <select name="subject_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                <option value="">— Subject —</option>
                @foreach($mySubjects as $subj)
                    <option value="{{ $subj->id }}"
                        {{ $selectedSubject == $subj->id ? 'selected' : '' }}>
                        {{ $subj->name }} ({{ $subj->class }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Term *</label>
            <select name="term" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                <option value="">— Term —</option>
                <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
            <select name="year"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-green-900 text-white py-2 rounded-lg hover:bg-green-800 transition text-sm">
                Load Students
            </button>
        </div>

    </form>
</div>

{{-- Marks Entry --}}
@if($students->count() > 0 && $subject)

<form action="{{ route('teacher.marks.save') }}" method="POST">
    @csrf
    <input type="hidden" name="class"      value="{{ $selectedClass }}">
    <input type="hidden" name="term"       value="{{ $selectedTerm }}">
    <input type="hidden" name="year"       value="{{ $selectedYear }}">
    <input type="hidden" name="subject_id" value="{{ $subject->id }}">

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="font-semibold text-gray-700">
                {{ $subject->name }} — {{ $selectedClass }} —
                {{ ucwords(str_replace('_', ' ', $selectedTerm)) }} —
                {{ $selectedYear }}
            </h4>
            <p class="text-xs text-gray-400 mt-1">
                {{ $students->count() }} students |
                Out of {{ $subject->total_marks }} marks |
                Pass mark: {{ $subject->pass_marks }}
            </p>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                        Marks / {{ $subject->total_marks }}
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Grade</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($students as $index => $student)
                @php
                    $existing = \App\Models\AcademicRecord::where('student_id', $student->id)
                                    ->where('subject_id', $subject->id)
                                    ->where('term', $selectedTerm)
                                    ->where('year', $selectedYear)
                                    ->first();
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <x-avatar :photo="$student->photo" :name="$student->full_name" size="xs" />
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                <p class="text-xs text-gray-400">{{ $student->admission_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input type="number"
                               name="marks[{{ $student->id }}]"
                               value="{{ $existing?->marks ?? '' }}"
                               min="0" max="{{ $subject->total_marks }}"
                               placeholder="—"
                               class="w-20 border border-gray-300 rounded px-2 py-1 text-sm text-center
                                      focus:outline-none focus:ring-2 focus:ring-green-500
                                      {{ $existing && $existing->status == 'fail' ? 'border-red-300 bg-red-50' : '' }}">
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($existing)
                        <span class="px-2 py-1 text-xs rounded font-bold
                            {{ in_array($existing->grade, ['A','A-','B+']) ? 'bg-green-100 text-green-700' :
                              (in_array($existing->grade, ['B','B-','C+']) ? 'bg-blue-100 text-blue-700' :
                              (in_array($existing->grade, ['C','C-','D+']) ? 'bg-yellow-100 text-yellow-700' :
                                                                             'bg-red-100 text-red-700')) }}">
                            {{ $existing->grade }}
                        </span>
                        @else
                        <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($existing)
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $existing->status == 'pass' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($existing->status) }}
                        </span>
                        @else
                        <span class="text-gray-300 text-xs">Not entered</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200 flex justify-end bg-gray-50">
            <button type="submit"
                    class="bg-green-900 text-white px-8 py-2 rounded-lg hover:bg-green-800 transition font-semibold">
                💾 Save Marks
            </button>
        </div>

    </div>
</form>

@elseif($selectedClass && $selectedTerm && $selectedSubject)
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-4xl mb-3">📝</p>
    <p class="font-medium">No students found for this selection.</p>
</div>

@else
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-5xl mb-4">📝</p>
    <p class="font-medium text-lg">Select class, subject, term and year above to enter marks.</p>
</div>
@endif

@endsection