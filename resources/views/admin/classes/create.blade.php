@extends('layouts.admin')

@section('page_title', 'Add Class')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">

    <h3 class="text-lg font-semibold text-gray-700 mb-6">Create New Class</h3>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.classes.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="e.g. Form 1A"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Level *</label>
                <select name="level"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Select Level</option>
                    <option value="Form 1"  {{ old('level') == 'Form 1'  ? 'selected' : '' }}>Form 1</option>
                    <option value="Form 2"  {{ old('level') == 'Form 2'  ? 'selected' : '' }}>Form 2</option>
                    <option value="Form 3"  {{ old('level') == 'Form 3'  ? 'selected' : '' }}>Form 3</option>
                    <option value="Form 4"  {{ old('level') == 'Form 4'  ? 'selected' : '' }}>Form 4</option>
                    <option value="Grade 7" {{ old('level') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                    <option value="Grade 8" {{ old('level') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                    <option value="Grade 9" {{ old('level') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stream</label>
                <input type="text" name="stream" value="{{ old('stream') }}"
                       placeholder="e.g. East, West, A, B"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Capacity *</label>
                <input type="number" name="capacity" value="{{ old('capacity', 40) }}"
                       min="1" max="100"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class Teacher</label>
                <select name="class_teacher_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Teacher —</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ old('class_teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->full_name }} — {{ $teacher->subject ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
                <input type="text" name="room_number" value="{{ old('room_number') }}"
                       placeholder="e.g. Block A - Room 3"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('admin.classes.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Create Class
            </button>
        </div>

    </form>
</div>

@endsection