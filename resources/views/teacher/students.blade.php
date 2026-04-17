@extends('layouts.teacher')

@section('page_title', 'My Students')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">My Students</h3>
</div>

{{-- Class Filter --}}
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form action="{{ route('teacher.students') }}" method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Class</label>
            <select name="class"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                @foreach($myClasses as $class)
                    <option value="{{ $class->name }}"
                        {{ $selectedClass == $class->name ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="bg-green-900 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition text-sm">
            Load Students
        </button>
    </form>
</div>

{{-- Students Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">
            {{ $selectedClass ?? 'Select a Class' }}
            @if($students->count() > 0)
                <span class="text-sm text-gray-400 ml-2">({{ $students->count() }} students)</span>
            @endif
        </h4>
        @if($selectedClass)
        <a href="{{ route('teacher.attendance', ['class' => $selectedClass]) }}"
           class="bg-green-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-800 transition">
            ✅ Take Attendance
        </a>
        @endif
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adm. No</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dormitory</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($students as $student)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">
                    <x-avatar :photo="$student->photo" :name="$student->full_name" size="sm" />
                </td>
                <td class="px-4 py-3 text-sm font-medium text-green-900">
                    {{ $student->admission_number }}
                </td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                    {{ $student->full_name }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 capitalize">{{ $student->gender }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $student->dormitory ?? 'N/A' }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $student->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                    @if($selectedClass)
                        No students found in {{ $selectedClass }}.
                    @else
                        Select a class above to view students.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection