@extends('layouts.teacher')

@section('page_title', 'Enter Marks')
@section('page_subtitle', 'Record student marks for your subjects')

@section('content')

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-5 text-sm font-medium">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Filter --}}
<div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
    <h4 class="text-sm font-semibold text-gray-700 mb-4">Select Class & Subject</h4>
    <form action="{{ route('teacher.marks') }}" method="GET"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Class *</label>
            <select name="class" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-500
                           text-sm text-gray-800 bg-white">
                <option value="">— Select Class —</option>
                @foreach($myClasses as $className)
                    <option value="{{ $className }}"
                        {{ $selectedClass == $className ? 'selected' : '' }}>
                        {{ $className }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Subject *</label>
            <select name="subject_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-500
                           text-sm text-gray-800 bg-white">
                <option value="">— Select Subject —</option>
                @foreach($mySubjects as $subj)
                    <option value="{{ $subj->id }}"
                        {{ $selectedSubject == $subj->id ? 'selected' : '' }}>
                        {{ $subj->name }} ({{ $subj->class }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Term *</label>
            <select name="term"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-500
                           text-sm text-gray-800 bg-white">
                <option value="">— Select Term —</option>
                <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Year</label>
            <select name="year"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-500
                           text-sm text-gray-800 bg-white">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-slate-800 text-white py-2.5 rounded-lg
                           hover:bg-slate-700 transition text-sm font-semibold">
                Load Students
            </button>
        </div>

    </form>
</div>

{{-- Marks Entry Table --}}
@if($students->count() > 0 && $subject)

<form action="{{ route('teacher.marks.save') }}" method="POST">
    @csrf
    <input type="hidden" name="class"      value="{{ $selectedClass }}">
    <input type="hidden" name="term"       value="{{ $selectedTerm }}">
    <input type="hidden" name="year"       value="{{ $selectedYear }}">
    <input type="hidden" name="subject_id" value="{{ $subject->id }}">

    @if(!$selectedTerm)
    <div class="bg-orange-50 border border-orange-200 text-orange-800 px-4 py-3 rounded-lg mb-4 text-sm">
        ⚠️ Please select a <strong>Term</strong> before saving marks.
    </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

        {{-- Table Header --}}
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h4 class="text-sm font-semibold text-gray-800">
                    {{ $subject->name }} — {{ $selectedClass }}
                    @if($selectedTerm) — {{ ucwords(str_replace('_', ' ', $selectedTerm)) }} @endif
                    — {{ $selectedYear }}
                </h4>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $students->count() }} students •
                    Out of {{ $subject->total_marks }} marks •
                    Pass mark: {{ $subject->pass_marks }}
                </p>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Marks / {{ $subject->total_marks }}
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Grade</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($students as $index => $student)
                @php
                    $existing = \App\Models\AcademicRecord::where('student_id', $student->id)
                                    ->where('subject_id', $subject->id)
                                    ->where('term', $selectedTerm ?: 'term_1')
                                    ->where('year', $selectedYear)
                                    ->first();
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <x-avatar :photo="$student->photo"
                                      :name="$student->full_name"
                                      size="xs" />
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $student->full_name }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $student->admission_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input type="number"
                               name="marks[{{ $student->id }}]"
                               value="{{ $existing?->marks ?? '' }}"
                               min="0"
                               max="{{ $subject->total_marks }}"
                               placeholder="—"
                               class="w-20 border border-gray-300 rounded-lg px-2 py-1.5
                                      text-sm text-center font-medium text-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-slate-500
                                      {{ $existing && $existing->status == 'fail'
                                         ? 'border-red-300 bg-red-50 text-red-700'
                                         : 'bg-white' }}">
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($existing)
                            <span class="inline-block px-2 py-0.5 rounded text-xs font-bold
                                {{ in_array($existing->grade, ['A','A-','B+'])
                                    ? 'bg-green-50 text-green-700'
                                    : (in_array($existing->grade, ['B','B-','C+'])
                                        ? 'bg-blue-50 text-blue-700'
                                        : (in_array($existing->grade, ['C','C-','D+'])
                                            ? 'bg-yellow-50 text-yellow-700'
                                            : 'bg-red-50 text-red-700')) }}">
                                {{ $existing->grade }}
                            </span>
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($existing)
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $existing->status == 'pass'
                                    ? 'bg-green-50 text-green-700'
                                    : 'bg-red-50 text-red-700' }}">
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

        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center">
            <p class="text-xs text-gray-500">
                Enter marks in the boxes above then click Save.
            </p>
            <button type="submit"
                    {{ !$selectedTerm ? 'disabled' : '' }}
                    class="bg-slate-800 text-white px-8 py-2.5 rounded-lg
                           hover:bg-slate-700 transition font-semibold text-sm
                           disabled:opacity-50 disabled:cursor-not-allowed">
                Save Marks
            </button>
        </div>

    </div>
</form>

@elseif($selectedClass && $selectedSubject)
<div class="bg-white rounded-xl border border-gray-200 p-10 text-center">
    <p class="text-4xl mb-3">📝</p>
    <p class="text-sm font-medium text-gray-600">No active students found in {{ $selectedClass }}.</p>
    <p class="text-xs text-gray-400 mt-1">Make sure students are assigned to this class.</p>
</div>

@else
<div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
    <p class="text-5xl mb-4">📝</p>
    <p class="text-base font-semibold text-gray-600 mb-1">Select a class and subject to load students</p>
    <p class="text-xs text-gray-400">Term and year are needed before saving marks</p>
</div>
@endif

@endsection