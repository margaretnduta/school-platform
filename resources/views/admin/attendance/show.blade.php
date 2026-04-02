@extends('layouts.admin')

@section('page_title', 'Student Attendance')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Student Header --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-blue-900">{{ $student->full_name }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $student->admission_number }} • {{ $student->class ?? 'No Class' }}
                </p>
            </div>
            <a href="{{ route('admin.students.show', $student) }}"
               class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                View Full Profile
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-green-600">
                {{ $records->where('status', 'present')->count() }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Present</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-red-600">
                {{ $records->where('status', 'absent')->count() }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Absent</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-yellow-600">
                {{ $records->where('status', 'late')->count() }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Late</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-blue-600">
                {{ $records->where('status', 'excused')->count() }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Excused</p>
        </div>
    </div>

    {{-- Attendance Rate --}}
    @php
        $total       = $records->count();
        $present     = $records->where('status', 'present')->count();
        $rate        = $total > 0 ? round(($present / $total) * 100) : 0;
    @endphp

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-2">
            <h4 class="font-semibold text-gray-700">Attendance Rate</h4>
            <span class="text-sm font-bold
                {{ $rate >= 80 ? 'text-green-600' :
                   ($rate >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $rate }}%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="h-4 rounded-full transition-all
                {{ $rate >= 80 ? 'bg-green-500' :
                   ($rate >= 50 ? 'bg-yellow-400' : 'bg-red-500') }}"
                 style="width: {{ $rate }}%">
            </div>
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>0%</span>
            <span class="{{ $rate >= 80 ? 'text-green-600 font-semibold' : '' }}">
                @if($rate >= 80) Good attendance ✅
                @elseif($rate >= 50) Needs improvement ⚠️
                @else Poor attendance ❌
                @endif
            </span>
            <span>100%</span>
        </div>
    </div>

    {{-- Records Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="font-semibold text-gray-700">Attendance History</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $record->date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $record->status == 'present' ? 'bg-green-100 text-green-700'    :
                              ($record->status == 'absent'  ? 'bg-red-100 text-red-700'      :
                              ($record->status == 'late'    ? 'bg-yellow-100 text-yellow-700' :
                                                              'bg-blue-100 text-blue-700')) }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $record->remarks ?? '—' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                        No attendance records found for this student.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $records->links() }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.attendance.report') }}"
           class="text-gray-500 hover:text-gray-700 text-sm">
            ← Back to Attendance Report
        </a>
    </div>

</div>

@endsection
```

---

Now make sure your `resources/views/admin/attendance/` folder has exactly these **3 files**:
```
attendance/
├── index.blade.php    ← take attendance
├── report.blade.php   ← view all records
└── show.blade.php     ← individual student