@extends('layouts.admin')

@section('page_title', 'Class Details')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Class Info Card --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-blue-900">{{ $class->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Level: {{ $class->level }}
                    @if($class->stream) • Stream: {{ $class->stream }} @endif
                    @if($class->room_number) • Room: {{ $class->room_number }} @endif
                </p>
                @if($class->classTeacher)
                <p class="text-sm text-gray-500 mt-1">
                    Class Teacher: <span class="font-semibold">{{ $class->classTeacher->full_name }}</span>
                </p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-900">{{ $class->student_count }}</p>
                <p class="text-xs text-gray-500">of {{ $class->capacity }} students</p>
            </div>
        </div>
    </div>

    {{-- Students List --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="font-semibold text-gray-700">Students in {{ $class->name }}</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adm. No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dormitory</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-900">{{ $student->admission_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $student->full_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 capitalize">{{ $student->gender }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $student->dormitory ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $student->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.students.show', $student) }}"
                           class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                        No students assigned to this class yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $students->links() }}</div>
    </div>

</div>

@endsection