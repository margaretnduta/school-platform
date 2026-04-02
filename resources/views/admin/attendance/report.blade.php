@extends('layouts.admin')

@section('page_title', 'Attendance Report')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Attendance Report</h3>
    <a href="{{ route('admin.attendance.index') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        ✅ Take Attendance
    </a>
</div>

{{-- Filter Form --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('admin.attendance.report') }}" method="GET"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
            <select name="class"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->name }}"
                        {{ $selectedClass == $class->name ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                Filter
            </button>
        </div>

    </form>
</div>

{{-- Stats --}}
@if($records->count() > 0)
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-green-600">
            {{ $records->where('status','present')->count() }}
        </p>
        <p class="text-sm text-gray-500">Present</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-red-600">
            {{ $records->where('status','absent')->count() }}
        </p>
        <p class="text-sm text-gray-500">Absent</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-yellow-600">
            {{ $records->where('status','late')->count() }}
        </p>
        <p class="text-sm text-gray-500">Late</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-blue-600">
            {{ $records->where('status','excused')->count() }}
        </p>
        <p class="text-sm text-gray-500">Excused</p>
    </div>
</div>

{{-- Records Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($records as $record)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $record->date->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                    {{ $record->student->full_name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $record->class }}</td>
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
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.attendance.student', $record->student->id) }}"
                       class="text-blue-600 hover:underline text-xs">
                        📊 View Student
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@else
<div class="bg-white rounded-xl shadow p-10 text-center">
    <p class="text-5xl mb-4">📋</p>
    <p class="text-gray-500 font-medium">No attendance records found.</p>
    <p class="text-gray-400 text-sm mt-1">
        Select a class and date range above then click Filter.
    </p>
</div>
@endif

@endsection