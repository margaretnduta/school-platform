@extends('layouts.admin')

@section('page_title', 'Edit Exam')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.exams.index') }}" class="text-primary-600 hover:text-primary-700 flex items-center gap-2 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Exams
        </a>
        <h1 class="text-3xl font-bold text-gray-900">✏️ Edit Exam</h1>
        <p class="text-gray-600 mt-1">Update exam details</p>
    </div>

    <x-card>
        <form action="{{ route('admin.exams.update', $exam) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Exam Name *
                    </label>
                    <input type="text" name="name" placeholder="e.g., Mid-Term Exams" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-danger-500 @enderror"
                        value="{{ old('name', $exam->name) }}" required>
                    @error('name')
                        <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Term *
                    </label>
                    <select name="term" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('term') border-danger-500 @enderror" required>
                        <option value="">Select Term</option>
                        <option value="1" {{ old('term', $exam->term) == 1 ? 'selected' : '' }}>Term 1</option>
                        <option value="2" {{ old('term', $exam->term) == 2 ? 'selected' : '' }}>Term 2</option>
                        <option value="3" {{ old('term', $exam->term) == 3 ? 'selected' : '' }}>Term 3</option>
                    </select>
                    @error('term')
                        <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Year *
                    </label>
                    <input type="number" name="year" placeholder="2026" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('year') border-danger-500 @enderror"
                        value="{{ old('year', $exam->year) }}" required>
                    @error('year')
                        <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Status *
                    </label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                        <option value="planned" {{ old('status', $exam->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                        <option value="ongoing" {{ old('status', $exam->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status', $exam->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Description
                </label>
                <textarea name="description" placeholder="Enter exam description..." rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-danger-500 @enderror">{{ old('description', $exam->description) }}</textarea>
                @error('description')
                    <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Start Date *
                    </label>
                    <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('start_date') border-danger-500 @enderror"
                        value="{{ old('start_date', $exam->start_date->format('Y-m-d')) }}" required>
                    @error('start_date')
                        <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        End Date *
                    </label>
                    <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('end_date') border-danger-500 @enderror"
                        value="{{ old('end_date', $exam->end_date->format('Y-m-d')) }}" required>
                    @error('end_date')
                        <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.exams.index') }}" class="flex-1 btn btn-white">
                    Cancel
                </a>
                <button type="submit" class="flex-1 btn btn-primary">
                    Update Exam
                </button>
            </div>
        </form>
    </x-card>
</div>

@endsection
