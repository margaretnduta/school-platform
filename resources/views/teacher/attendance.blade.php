@extends('layouts.teacher')

@section('page_title', 'Take Attendance')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Take Attendance</h3>
</div>

{{-- Class & Date Selector --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('teacher.attendance') }}" method="GET"
          class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
            <select name="class" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">— Select Class —</option>
                @foreach($myClasses as $class)
                    <option value="{{ $class->name }}"
                        {{ $selectedClass == $class->name ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
            <input type="date" name="date"
                   value="{{ $selectedDate }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                   required>
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-green-900 text-white py-2 rounded-lg hover:bg-green-800 transition">
                Load Students
            </button>
        </div>

    </form>
</div>

{{-- Attendance Form --}}
@if($students->count() > 0)

<form action="{{ route('teacher.attendance.save') }}" method="POST">
    @csrf
    <input type="hidden" name="class" value="{{ $selectedClass }}">
    <input type="hidden" name="date"  value="{{ $selectedDate }}">

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h4 class="font-semibold text-gray-700">
                    {{ $selectedClass }} — {{ $selectedDate }}
                </h4>
                <p class="text-xs text-gray-400 mt-1">{{ $students->count() }} students</p>
            </div>
            <div class="flex space-x-2">
                <button type="button" onclick="markAll('present')"
                        class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs hover:bg-green-200 transition">
                    ✅ All Present
                </button>
                <button type="button" onclick="markAll('absent')"
                        class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs hover:bg-red-200 transition">
                    ❌ All Absent
                </button>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Present</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Absent</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Late</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Excused</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="attendanceTable">
                @foreach($students as $index => $student)
                @php $currentStatus = $existing[$student->id] ?? 'present'; @endphp
                <tr class="hover:bg-gray-50 attendance-row">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <x-avatar :photo="$student->photo" :name="$student->full_name" size="xs" />
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                <p class="text-xs text-gray-400">{{ $student->admission_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input type="radio" name="attendance[{{ $student->id }}]"
                               value="present" class="attendance-radio w-4 h-4 text-green-600"
                               {{ $currentStatus == 'present' ? 'checked' : '' }}>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input type="radio" name="attendance[{{ $student->id }}]"
                               value="absent" class="attendance-radio w-4 h-4 text-red-600"
                               {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input type="radio" name="attendance[{{ $student->id }}]"
                               value="late" class="attendance-radio w-4 h-4 text-yellow-600"
                               {{ $currentStatus == 'late' ? 'checked' : '' }}>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input type="radio" name="attendance[{{ $student->id }}]"
                               value="excused" class="attendance-radio w-4 h-4 text-blue-600"
                               {{ $currentStatus == 'excused' ? 'checked' : '' }}>
                    </td>
                    <td class="px-4 py-3">
                        <input type="text" name="remarks[{{ $student->id }}]"
                               placeholder="Optional"
                               class="w-full border border-gray-200 rounded px-2 py-1 text-xs
                                      focus:outline-none focus:ring-1 focus:ring-green-500">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center bg-gray-50">
            <div class="text-sm text-gray-600 font-medium" id="attendanceSummary"></div>
            <button type="submit"
                    class="bg-green-900 text-white px-8 py-2 rounded-lg hover:bg-green-800 transition font-semibold">
                💾 Save Attendance
            </button>
        </div>

    </div>
</form>

@elseif($selectedClass)
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-4xl mb-3">🎓</p>
    <p class="font-medium">No active students found in {{ $selectedClass }}.</p>
</div>

@else
<div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
    <p class="text-5xl mb-4">✅</p>
    <p class="font-medium text-lg">Select a class and date above to take attendance.</p>
</div>
@endif

<script>
    function markAll(status) {
        document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => r.checked = true);
        updateSummary();
    }

    function updateSummary() {
        const counts = { present: 0, absent: 0, late: 0, excused: 0 };
        document.querySelectorAll('.attendance-row').forEach(row => {
            const checked = row.querySelector('input[type="radio"]:checked');
            if (checked) counts[checked.value]++;
        });
        const summary = document.getElementById('attendanceSummary');
        if (summary) {
            summary.innerHTML = `
                ✅ Present: <strong>${counts.present}</strong> &nbsp;|&nbsp;
                ❌ Absent: <strong>${counts.absent}</strong> &nbsp;|&nbsp;
                🕐 Late: <strong>${counts.late}</strong> &nbsp;|&nbsp;
                📋 Excused: <strong>${counts.excused}</strong>
            `;
        }
    }

    document.querySelectorAll('.attendance-radio').forEach(r => {
        r.addEventListener('change', updateSummary);
    });

    updateSummary();
</script>

@endsection