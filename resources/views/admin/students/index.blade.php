@extends('layouts.admin')

@section('page_title', 'Students')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

{{-- Header --}}
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">All Students</h3>
    <a href="{{ route('admin.students.create') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        + Add Student
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admission No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guardian</th>
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
                <td class="px-6 py-4 text-sm text-gray-500">{{ $student->class ?? 'Not Assigned' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $student->guardian_name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $student->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm space-x-2">
                    <a href="{{ route('admin.students.show', $student) }}"
                       class="text-blue-600 hover:underline">View</a>
                    <a href="{{ route('admin.students.edit', $student) }}"
                       class="text-yellow-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.students.destroy', $student) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">No students found. Add your first student!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4">
        {{ $students->links() }}
    </div>
</div>

@endsection