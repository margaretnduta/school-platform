@extends('layouts.admin')

@section('page_title', 'Academics')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

{{-- Quick Action Buttons --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.academics.enter-marks') }}"
       class="bg-blue-900 text-white rounded-xl p-5 flex items-center space-x-4 hover:bg-blue-800 transition">
        <span class="text-3xl">✏️</span>
        <div>
            <p class="font-semibold">Enter Marks</p>
            <p class="text-xs text-blue-300">Record student marks by class and term</p>
        </div>
    </a>
    <a href="{{ route('admin.academics.class-results') }}"
       class="bg-green-700 text-white rounded-xl p-5 flex items-center space-x-4 hover:bg-green-600 transition">
        <span class="text-3xl">📊</span>
        <div>
            <p class="font-semibold">Class Results</p>
            <p class="text-xs text-green-200">View and rank class performance</p>
        </div>
    </a>
    <div class="bg-white rounded-xl shadow p-5 flex items-center space-x-4">
        <span class="text-3xl">📚</span>
        <div>
            <p class="font-semibold text-gray-700">Total Subjects</p>
            <p class="text-2xl font-bold text-blue-900">{{ $subjects->count() }}</p>
        </div>
    </div>
</div>

{{-- Subjects List + Add Form --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Add Subject Form --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Add New Subject</h4>
        <form action="{{ route('admin.academics.store') }}" method="POST">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 text-red-600 text-xs p-3 rounded mb-3">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subject Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Mathematics"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subject Code *</label>
                    <input type="text" name="code" value="{{ old('code') }}"
                           placeholder="e.g. MATH101"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Class *</label>
                    <select name="class"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->name }}" {{ old('class') == $class->name ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subject Teacher</label>
                    <select name="teacher_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— None —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Total Marks</label>
                        <input type="number" name="total_marks" value="{{ old('total_marks', 100) }}"
                               min="1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Pass Marks</label>
                        <input type="number" name="pass_marks" value="{{ old('pass_marks', 50) }}"
                               min="1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition text-sm font-semibold">
                    Add Subject
                </button>
            </div>
        </form>
    </div>

    {{-- Subjects Table --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="font-semibold text-gray-700">All Subjects</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marks</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($subjects as $subject)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $subject->name }}</td>
                    <td class="px-4 py-3 text-sm text-blue-900 font-mono">{{ $subject->code }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $subject->class }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">
                        {{ $subject->teacher?->full_name ?? 'Not Assigned' }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">
                        {{ $subject->pass_marks }} / {{ $subject->total_marks }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <form action="{{ route('admin.academics.destroy', $subject) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Delete this subject?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                        No subjects yet. Add your first subject.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection