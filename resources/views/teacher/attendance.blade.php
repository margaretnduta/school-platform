@extends('layouts.teacher')

@section('page_title', 'Take Attendance')
@section('page_subtitle', 'Mark attendance for your class')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-5 text-sm font-medium flex items-center gap-2">
    <span class="text-green-500">&#10003;</span> {{ session('success') }}
</div>
@endif

{{-- Class & Date Selector --}}
<div class="bg-white rounded-xl border border-gray-200 p-5 mb-5">
    <p class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-4">Select Class & Date</p>
    <form action="{{ route('teacher.attendance') }}" method="GET">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Class *</label>
                <select name="class" required
                        class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                               bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500">
                    <option value="">— Select Class —</option>
                    @foreach($myClasses as $class)
                        <option value="{{ $class->name }}"
                            {{ $selectedClass == $class->name ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Date *</label>
                <input type="date" name="date"
                       value="{{ $selectedDate }}"
                       class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900
                              bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                              focus:border-blue-500"
                       required>
            </div>

            <div class="flex flex-col justify-end">
                <button type="submit"
                        class="w-full bg-blue-900 text-white font-semibold text-sm
                               px-4 py-2.5 rounded-lg hover:bg-blue-800
                               transition-colors border border-blue-900">
                    Load Students
                </button>
            </div>

        </div>
    </form>
</div>

{{-- Attendance Form --}}
@if($students->count() > 0)

<form action="{{ route('teacher.attendance.save') }}" method="POST">
    @csrf
    <input type="hidden" name="class" value="{{ $selectedClass }}">
    <input type="hidden" name="date"  value="{{ $selectedDate }}">

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-900">
                    {{ $selectedClass }}
                    <span class="text-gray-400 font-normal mx-1">—</span>
                    {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $students->count() }} students loaded</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="markAll('present')"
                        class="px-3 py-1.5 bg-green-600 text-white text-xs font-semibold
                               rounded-lg hover:bg-green-700 transition-colors border border-green-600">
                    All Present
                </button>
                <button type="button" onclick="markAll('absent')"
                        class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold
                               rounded-lg hover:bg-red-700 transition-colors border border-red-600">
                    All Absent
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide w-10">#</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Present</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Absent</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Late</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wide">Excused</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wide">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="attendanceTable">
                    @foreach($students as $index => $student)
                    @php $currentStatus = $existing[$student->id] ?? 'present'; @endphp
                    <tr class="hover:bg-gray-50 transition-colors attendance-row">
                        <td class="px-4 py-3 text-sm text-gray-500 font-medium">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <x-avatar :photo="$student->photo"
                                          :name="$student->full_name"
                                          size="xs" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $student->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->admission_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="present"
                                   class="attendance-radio w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                   {{ $currentStatus == 'present' ? 'checked' : '' }}>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="absent"
                                   class="attendance-radio w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                                   {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="late"
                                   class="attendance-radio w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500"
                                   {{ $currentStatus == 'late' ? 'checked' : '' }}>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="excused"
                                   class="attendance-radio w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                   {{ $currentStatus == 'excused' ? 'checked' : '' }}>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text"
                                   name="remarks[{{ $student->id }}]"
                                   placeholder="Optional remark"
                                   class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs
                                          text-gray-800 bg-white focus:outline-none focus:ring-1
                                          focus:ring-blue-500 focus:border-blue-500">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
            <p class="text-xs font-semibold text-gray-700" id="attendanceSummary"></p>
            <button type="submit"
                    class="bg-blue-900 text-white font-semibold text-sm px-8 py-2.5
                           rounded-lg hover:bg-blue-800 transition-colors border border-blue-900">
                Save Attendance
            </button>
        </div>

    </div>
</form>

@elseif($selectedClass)
<div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
    <p class="text-sm font-semibold text-gray-700 mb-1">No active students found in {{ $selectedClass }}</p>
    <p class="text-xs text-gray-500">Make sure students are assigned to this class and marked active.</p>
</div>

@else
<div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
    <p class="text-sm font-semibold text-gray-700 mb-1">Select a class and date to begin</p>
    <p class="text-xs text-gray-500">All active students in the selected class will load automatically.</p>
</div>
@endif

<script>
    function markAll(status) {
        document.querySelectorAll(`input[type="radio"][value="${status}"]`)
                .forEach(r => r.checked = true);
        updateSummary();
    }

    function updateSummary() {
        const counts = { present: 0, absent: 0, late: 0, excused: 0 };
        document.querySelectorAll('.attendance-row').forEach(row => {
            const checked = row.querySelector('input[type="radio"]:checked');
            if (checked) counts[checked.value]++;
        });
        const el = document.getElementById('attendanceSummary');
        if (el) {
            el.innerHTML =
                `Present: <strong>${counts.present}</strong> &nbsp;|&nbsp; ` +
                `Absent: <strong>${counts.absent}</strong> &nbsp;|&nbsp; ` +
                `Late: <strong>${counts.late}</strong> &nbsp;|&nbsp; ` +
                `Excused: <strong>${counts.excused}</strong>`;
        }
    }

    document.querySelectorAll('.attendance-radio')
            .forEach(r => r.addEventListener('change', updateSummary));
    updateSummary();
</script>

@endsection