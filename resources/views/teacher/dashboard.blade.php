@extends('layouts.teacher')

@section('page_title', 'Teacher Dashboard')
@section('page_subtitle', 'Welcome back — here is your class overview')

@section('content')

{{-- Teacher Profile Strip --}}
<div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
    <div class="flex items-center gap-4">
        <x-avatar :photo="$staff->photo" :name="$staff->full_name" size="lg" />
        <div class="min-w-0">
            <h3 class="text-base font-bold text-gray-900">{{ $staff->full_name }}</h3>
            <p class="text-sm text-gray-500">{{ $staff->role_name }}
                @if($staff->department) — {{ $staff->department }} @endif
            </p>
            @if($staff->subject)
            <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-700
                         text-xs font-medium rounded-full">
                {{ $staff->subject }}
            </span>
            @endif
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">My Students</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStudents }}</p>
                <p class="text-xs text-gray-400 mt-1">Across all my classes</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                🎓
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">My Classes</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $myClasses->count() }}</p>
                <p class="text-xs text-gray-400 mt-1">Assigned classes</p>
            </div>
            <div class="w-11 h-11 bg-purple-50 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                🏫
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">My Subjects</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $mySubjects->count() }}</p>
                <p class="text-xs text-gray-400 mt-1">Teaching subjects</p>
            </div>
            <div class="w-11 h-11 bg-green-50 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                📚
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Attendance Today</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $todayAttendance }}</p>
                <p class="text-xs text-gray-400 mt-1">Records entered today</p>
            </div>
            <div class="w-11 h-11 rounded-lg flex items-center justify-center text-xl flex-shrink-0
                        {{ $todayAttendance > 0 ? 'bg-teal-50' : 'bg-gray-50' }}">
                ✅
            </div>
        </div>
    </div>

</div>

{{-- Main Content --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- My Classes --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">My Classes</h3>
                <p class="text-xs text-gray-400 mt-0.5">Classes you are assigned to</p>
            </div>
            <a href="{{ route('teacher.attendance') }}"
               class="text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors
                      px-3 py-1.5 bg-slate-100 rounded-lg hover:bg-slate-200">
                Take Attendance
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($myClasses as $class)
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800">{{ $class->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $class->level }}
                        @if($class->stream) — {{ $class->stream }} @endif
                        • Capacity {{ $class->capacity }}
                    </p>
                </div>
                <a href="{{ route('teacher.students', ['class' => $class->name]) }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800 flex-shrink-0 ml-3">
                    View →
                </a>
            </div>
            @empty
            <div class="px-5 py-10 text-center">
                <p class="text-sm text-gray-400">No classes assigned yet.</p>
                <p class="text-xs text-gray-400 mt-1">Contact admin to assign you a class.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- My Subjects --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">My Subjects</h3>
                <p class="text-xs text-gray-400 mt-0.5">Subjects you teach</p>
            </div>
            <a href="{{ route('teacher.marks') }}"
               class="text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors
                      px-3 py-1.5 bg-slate-100 rounded-lg hover:bg-slate-200">
                Enter Marks
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($mySubjects as $subject)
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800">{{ $subject->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $subject->code }} • {{ $subject->class }} •
                        Out of {{ $subject->total_marks }} marks
                    </p>
                </div>
                <a href="{{ route('teacher.marks', ['class' => $subject->class, 'subject_id' => $subject->id]) }}"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-800 flex-shrink-0 ml-3">
                    Marks →
                </a>
            </div>
            @empty
            <div class="px-5 py-10 text-center">
                <p class="text-sm text-gray-400">No subjects assigned yet.</p>
                <p class="text-xs text-gray-400 mt-1">Contact admin to assign you subjects.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection