@extends('layouts.teacher')

@section('page_title', 'My Students')
@section('page_subtitle', 'Students in your assigned classes')

@section('content')

{{-- Class Filter --}}
<div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
    <form action="{{ route('teacher.students') }}" method="GET"
          class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                Select Class
            </label>
            <select name="class"
                    class="border border-gray-300 rounded-lg px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-500
                           text-sm text-gray-800 bg-white min-w-40">
                @foreach($myClasses as $class)
                    <option value="{{ $class->name }}"
                        {{ $selectedClass == $class->name ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="bg-slate-800 text-white px-5 py-2.5 rounded-lg
                       hover:bg-slate-700 transition text-sm font-semibold">
            Load Students
        </button>
        @if($selectedClass)
        <a href="{{ route('teacher.attendance', ['class' => $selectedClass]) }}"
           class="bg-teal-700 text-white px-5 py-2.5 rounded-lg
                  hover:bg-teal-600 transition text-sm font-semibold">
            ✅ Take Attendance
        </a>
        @endif
    </form>
</div>

{{-- Students Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h4 class="text-sm font-semibold text-gray-800">
            {{ $selectedClass ?? 'Select a Class' }}
            @if($students->count() > 0)
                <span class="text-xs text-gray-400 ml-2 font-normal">
                    ({{ $students->count() }} students)
                </span>
            @endif
        </h4>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Photo</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Adm. No</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Gender</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Dormitory</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($students as $student)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-2.5">
                    <x-avatar :photo="$student->photo"
                              :name="$student->full_name"
                              size="sm" />
                </td>
                <td class="px-4 py-3 text-sm font-semibold text-slate-700">
                    {{ $student->admission_number }}
                </td>
                <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                    {{ $student->full_name }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-600 capitalize">
                    {{ $student->gender }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">
                    {{ $student->dormitory ?? 'N/A' }}
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $student->status === 'active'
                            ? 'bg-green-50 text-green-700'
                            : 'bg-red-50 text-red-700' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('teacher.student.profile', $student->id) }}"
                       class="text-xs font-semibold text-slate-700 hover:text-slate-900
                              px-3 py-1.5 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                        View Profile →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-10 text-center">
                    <p class="text-sm text-gray-500 font-medium">
                        @if($selectedClass)
                            No students found in {{ $selectedClass }}.
                        @else
                            Select a class above to view students.
                        @endif
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection