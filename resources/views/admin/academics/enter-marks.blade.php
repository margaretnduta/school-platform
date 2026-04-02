@extends('layouts.admin')

@section('page_title', 'Enter Marks')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Enter Marks</h3>
    <div class="flex gap-2">
        <a href="{{ route('admin.academics.class-results') }}"
           class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition text-sm">
            📊 Class Results
        </a>
        <a href="{{ route('admin.academics.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm">
            ← Subjects
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('admin.academics.enter-marks') }}" method="GET"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
            <select name="class" required
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Term *</label>
            <select name="term" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Select Term —</option>
                <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year *</label>
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
                Load Students
            </button>
        </div>

    </form>
</div>

{{-- Marks Entry Table --}}
@if($students->count() > 0 && $subjects->count() > 0)

<form action="{{ route('admin.academics.save-marks') }}" method="POST">
    @csrf
    <input type="hidden" name="class" value="{{ $selectedClass }}">
    <input type="hidden" name="term"  value="{{ $selectedTerm }}">
    <input type="hidden" name="year"  value="{{ $selectedYear }}">

    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="font-semibold text-gray-700">
                {{ $selectedClass }} —
                {{ ucwords(str_replace('_', ' ', $selectedTerm)) }} —
                {{ $selectedYear }}
            </h4>
            <p class="text-xs text-gray-400 mt-1">
                {{ $students->count() }} students | {{ $subjects->count() }} subjects
            </p>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase sticky left-0 bg-gray-50 z-10">
                        Student
                    </th>
                    @foreach($subjects as $subject)
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                        {{ $subject->name }}
                        <br>
                        <span class="text-gray-400 font-normal">/{{ $subject->total_marks }}</span>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 sticky left-0 bg-white hover:bg-gray-50 z-10">
                        <div class="flex items-center gap-2">
                            <x-avatar :photo="$student->photo" :name="$student->full_name" size="xs" />
                            <div>
                                <p class="text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $student->full_name }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $student->admission_number }}</p>
                            </div>
                        </div>
                    </td>
                    @foreach($subjects as $subject)
                    @php
                        $existing = \App\Models\AcademicRecord::where('student_id', $student->id)
                                        ->where('subject_id', $subject->id)
                                        ->where('term', $selectedTerm)
                                        ->where('year', $selectedYear)
                                        ->first();
                    @endphp
                    <td class="px-3 py-2 text-center">
                        <input type="number"
                               name="marks[{{ $student->id }}][{{ $subject->id }}]"
                               value="{{ $existing?->marks ?? '' }}"
                               min="0" max="{{ $subject->total_marks }}"
                               placeholder="—"
                               class="w-16 border border-gray-300 rounded px-2 py-1 text-sm text-center
                                      focus:outline-none focus:ring-2 focus:ring-blue-500
                                      {{ $existing && $existing->status == 'fail' ? 'border-red-300 bg-red-50' : '' }}">
                        @if($existing)
                        <p class="text-xs mt-1 font-semibold
                            {{ $existing->status == 'pass' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $existing->grade }}
                        </p>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button type="submit"
                    class="bg-blue-900 text-white px-8 py-2 rounded-lg hover:bg-blue-800 transition font-semibold">
                💾 Save Marks
            </button>
        </div>

    </div>
</form>

@elseif($selectedClass && $selectedTerm)
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-4xl mb-3">📚</p>
    <p class="font-medium">No students or subjects found for this class.</p>
    <p class="text-sm mt-1">
        Make sure students are assigned to {{ $selectedClass }} and subjects are created for it.
    </p>
</div>

@else
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-5xl mb-4">✏️</p>
    <p class="font-medium text-lg">Select a class, term and year above to enter marks.</p>
</div>
@endif

@endsection