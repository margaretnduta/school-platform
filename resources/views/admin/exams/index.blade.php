@extends('layouts.admin')

@section('page_title', 'Exam Management')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">📚 Exam Management</h1>
        <p class="text-gray-600 mt-1">Create and manage school exams and eligibility tracking</p>
    </div>
    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-lg">
        + Create Exam
    </a>
</div>

@if ($exams->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($exams as $exam)
            <x-card class="hover:shadow-lg transition-all duration-300">
                <x-card-body>
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $exam->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $exam->level }} - Stream {{ $exam->stream }}</p>
                        </div>
                        <x-badge :color="match($exam->status) {
                            'planned' => 'primary',
                            'ongoing' => 'success',
                            'completed' => 'gray',
                            default => 'gray'
                        }">
                            {{ ucfirst($exam->status) }}
                        </x-badge>
                    </div>

                    @if ($exam->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $exam->description }}</p>
                    @endif

                    <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-xs text-gray-500">Start Date</p>
                            <p class="font-semibold text-gray-900">{{ $exam->start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">End Date</p>
                            <p class="font-semibold text-gray-900">{{ $exam->end_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Term</p>
                            <p class="font-semibold text-gray-900">Term {{ $exam->term }}, {{ $exam->year }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.exams.show', $exam) }}" class="flex-1 btn btn-primary btn-sm">
                            Analyze
                        </a>
                        <a href="{{ route('admin.exams.edit', $exam) }}" class="flex-1 btn btn-secondary btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full btn btn-danger btn-sm" onclick="return confirm('Delete this exam?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </x-card-body>
            </x-card>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $exams->links() }}
    </div>
@else
    <x-card>
        <x-card-body class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">📋 No exams created yet</p>
            <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">
                Create Your First Exam
            </a>
        </x-card-body>
    </x-card>
@endif

@endsection
