@extends('layouts.teacher')

@section('page_title', 'Enter Marks')
@section('page_subtitle', 'Record student marks for your subjects')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-5 text-sm font-medium flex items-center gap-2">
    <span class="text-green-500">&#10003;</span> {{ session('success') }}
</div>
@endif

{{-- Filter Form --}}
<div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
    <p class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-4">Select Class & Subject</p>
    <form action="{{ route('teacher.marks') }}" method="GET">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Class *</label>
                <select name="class" required
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500">
                    <option value="">— Select —</option>
                    @foreach($myClasses as $className)
                        <option value="{{ $className }}"
                            {{ $selectedClass == $className ? 'selected' : '' }}>
                            {{ $className }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Subject *</label>
                <select name="subject_id" required
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500">
                    <option value="">— Select —</option>
                    @foreach($mySubjects as $subj)
                        <option value="{{ $subj->id }}"
                            {{ $selectedSubject == $subj->id ? 'selected' : '' }}>
                            {{ $subj->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Term *</label>
                <select name="term"
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500">
                    <option value="">— Select —</option>
                    <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                    <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                    <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Year</label>
                <select name="year"
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex flex-col justify-end">
                <button type="submit"
                        class="w-full bg-blue-900 text-white font-semibold text-sm
                               px-4 py-2.5 rounded-lg hover:bg-blue-800
                               transition-colors border border-blue-900">
                    Load Students
                </button>
            </div>

        </div>
    </form>
</div>

{{-- Results --}}
@if($students->count() > 0 && $subject)

    @if(!$selectedTerm)
    <div class="bg-amber-50 border border-amber-300 text-amber-900 px-4 py-3 rounded-lg mb-4 text-sm font-medium">
        &#9888; Please select a <strong>Term</strong> above before saving marks.
    </div>
    @endif

    <form action="{{ route('teacher.marks.save') }}" method="POST">
        @csrf
        <input type="hidden" name="class"      value="{{ $selectedClass }}">
        <input type="hidden" name="term"       value="{{ $selectedTerm }}">
        <input type="hidden" name="year"       value="{{ $selectedYear }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-900">
                        {{ $subject->name }}
                        <span class="text-gray-400 font-normal mx-1">—</span>
                        {{ $selectedClass }}
                        @if($selectedTerm)
                            <span class="text-gray-400 font-normal mx-1">—</span>
                            {{ ucwords(str_replace('_', ' ', $selectedTerm)) }}
                        @endif
                        <span class="text-gray-400 font-normal mx-1">—</span>
                        {{ $selectedYear }}
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $students->count() }} students &bull;
                        Max marks: {{ $subject->total_marks }} &bull;
                        Pass mark: {{ $subject->pass_marks }}
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide w-10">#</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Class</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Marks / {{ $subject->total_marks }}</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Grade</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Status</th>
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
                            <td class="px-4 py-3 text-sm text-gray-500 font-medium">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <x-avatar :photo="$student->photo"
                                              :name="$student->full_name"
                                              size="xs" />
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $student->full_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->admission_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $student->class }}</td>
                            <td class="px-4 py-3 text-center">
                                <input type="number"
                                       name="marks[{{ $student->id }}]"
                                       value="{{ $existing?->marks ?? '' }}"
                                       min="0"
                                       max="{{ $subject->total_marks }}"
                                       placeholder="—"
                                       class="w-20 border border-gray-300 rounded-lg px-2 py-1.5
                                              text-sm text-center font-semibold text-gray-900
                                              focus:outline-none focus:ring-2 focus:ring-blue-500
                                              {{ $existing && $existing->status == 'fail'
                                                 ? 'border-red-300 bg-red-50 text-red-700'
                                                 : 'bg-white hover:border-gray-400' }}">
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($existing)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-bold
                                        {{ in_array($existing->grade, ['A','A-','B+']) ? 'bg-green-50 text-green-700 border border-green-200' :
                                          (in_array($existing->grade, ['B','B-','C+']) ? 'bg-blue-50 text-blue-700 border border-blue-200' :
                                          (in_array($existing->grade, ['C','C-','D+']) ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' :
                                                                                         'bg-red-50 text-red-700 border border-red-200')) }}">
                                        {{ $existing->grade }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($existing)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $existing->status == 'pass'
                                            ? 'bg-green-50 text-green-700 border border-green-200'
                                            : 'bg-red-50 text-red-700 border border-red-200' }}">
                                        {{ ucfirst($existing->status) }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">Not entered</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                <p class="text-xs text-gray-600 font-medium">
                    @if($selectedTerm)
                        Saving marks for <strong class="text-gray-900">{{ ucwords(str_replace('_', ' ', $selectedTerm)) }}</strong> — {{ $selectedYear }}
                    @else
                        <span class="text-amber-700">Select a term above before saving.</span>
                    @endif
                </p>
                <button type="submit"
                        {{ !$selectedTerm ? 'disabled' : '' }}
                        class="bg-blue-900 text-white font-semibold text-sm px-8 py-2.5
                               rounded-lg hover:bg-blue-800 transition-colors border border-blue-900
                               disabled:opacity-40 disabled:cursor-not-allowed">
                    Save Marks
                </button>
            </div>

        </div>
    </form>

@elseif($selectedClass && $selectedSubject)
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <p class="text-2xl mb-3">&#128240;</p>
        <p class="text-sm font-semibold text-gray-700 mb-1">No active students found</p>
        <p class="text-xs text-gray-500">
            No students found for <strong>{{ $selectedClass }}</strong>.
            Make sure students are assigned and active.
        </p>
    </div>

@else
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <p class="text-sm font-semibold text-gray-700 mb-1">Select a class and subject to begin</p>
        <p class="text-xs text-gray-500">Choose from the filters above then click Load Students</p>
    </div>
@endif

@endsection