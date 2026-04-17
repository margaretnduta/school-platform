@extends('layouts.teacher')

@section('page_title', 'My Students')
@section('page_subtitle', 'Students in your assigned classes')

@section('content')

{{-- Class Filter --}}
<div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
    <p class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-4">Select Class</p>
    <form action="{{ route('teacher.students') }}" method="GET">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex flex-col gap-1.5 min-w-48">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Class</label>
                <select name="class"
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500">
                    @foreach($myClasses as $class)
                        <option value="{{ $class->name }}"
                            {{ $selectedClass == $class->name ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="bg-blue-900 text-white font-semibold text-sm px-5 py-2.5
                           rounded-lg hover:bg-blue-800 transition-colors border border-blue-900">
                Load Students
            </button>
            @if($selectedClass)
            <a href="{{ route('teacher.attendance', ['class' => $selectedClass]) }}"
               class="bg-green-700 text-white font-semibold text-sm px-5 py-2.5
                      rounded-lg hover:bg-green-600 transition-colors border border-green-700">
                Take Attendance
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Students Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <p class="text-sm font-bold text-gray-900">
            {{ $selectedClass ?? 'Select a Class' }}
            @if($students->count() > 0)
                <span class="text-xs text-gray-500 font-normal ml-2">
                    ({{ $students->count() }} students)
                </span>
            @endif
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Photo</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Adm. No</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Gender</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Dormitory</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <x-avatar :photo="$student->photo"
                                  :name="$student->full_name"
                                  size="sm" />
                    </td>
                    <td class="px-4 py-3 text-sm font-semibold text-blue-900">
                        {{ $student->admission_number }}
                    </td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">
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
                                ? 'bg-green-50 text-green-700 border border-green-200'
                                : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('teacher.student.profile', $student->id) }}"
                           class="inline-flex items-center px-3 py-1.5 bg-blue-900 text-white
                                  text-xs font-semibold rounded-lg hover:bg-blue-800
                                  transition-colors border border-blue-900">
                            View Profile
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center">
                        <p class="text-sm font-semibold text-gray-600 mb-1">
                            @if($selectedClass)
                                No students found in {{ $selectedClass }}
                            @else
                                Select a class above to view students
                            @endif
                        </p>
                        <p class="text-xs text-gray-400">Make sure students are assigned and active.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection