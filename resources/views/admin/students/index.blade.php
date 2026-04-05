@extends('layouts.admin')

@section('page_title', 'Students')

@section('content')

@if(session('success'))
    <x-alert variant="success" dismissible>
        <strong>Success!</strong> {{ session('success') }}
    </x-alert>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-gray-600">Manage and track all student information</p>
    </div>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Student
    </a>
</div>

<x-card>
    <div class="overflow-x-auto">
    <table class="table w-full">
        <thead class="table-head">
            <tr>
                <th class="w-12">Photo</th>
                <th>Admission No</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Guardian</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-body">
            @forelse($students as $student)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">
                    <x-avatar :photo="$student->photo" :name="$student->full_name" size="sm" />
                </td>
                <td class="px-4 py-3 text-sm font-medium text-blue-900 whitespace-nowrap">
                    {{ $student->admission_number }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-900 font-medium whitespace-nowrap">
                    {{ $student->full_name }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 capitalize">{{ $student->gender }}</td>
                <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                    {{ $student->class ?? 'Not Assigned' }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                    {{ $student->guardian_name }}
                </td>
                <td class="px-4 py-3">
                    <x-badge :variant="$student->status === 'active' ? 'success' : 'danger'">
                        {{ ucfirst($student->status) }}
                    </x-badge>
                </td>
                <td class="px-4 py-3 text-sm whitespace-nowrap space-x-2">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.students.show', $student) }}" class="btn btn-white btn-sm">
                            View
                        </a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-white btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Delete this student?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center">
                    <div class="text-gray-500 text-sm">No students found</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($students->hasPages())
        <x-card-footer>
            {{ $students->links() }}
        </x-card-footer>
    @endif
</x-card>

@endsection