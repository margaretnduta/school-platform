@extends('layouts.admin')

@section('page_title', 'Staff')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">All Staff Members</h3>
    <a href="{{ route('admin.staff.create') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        + Add Staff
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($staff as $member)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-blue-900">{{ $member->staff_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $member->full_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->role_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->department ?? 'N/A' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->phone ?? 'N/A' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $member->employment_type) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $member->status === 'active' ? 'bg-green-100 text-green-700' :
                           ($member->status === 'on_leave' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst(str_replace('_', ' ', $member->status)) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm space-x-2">
                    <a href="{{ route('admin.staff.show', $member) }}" class="text-blue-600 hover:underline">View</a>
                    <a href="{{ route('admin.staff.edit', $member) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.staff.destroy', $member) }}" method="POST"
                          class="inline" onsubmit="return confirm('Delete this staff member?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-400">No staff members found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $staff->links() }}</div>
</div>

@endsection