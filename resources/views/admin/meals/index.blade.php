@extends('layouts.admin')

@section('page_title', 'Meal Tracking')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Meal Tracking</h3>
    <a href="{{ route('admin.meals.report') }}"
       class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
        📊 View Report
    </a>
</div>

{{-- Today's Meal Summary --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @foreach(['breakfast', 'lunch', 'dinner'] as $session)
    @php
        $sessionMeal = $todayMeals->where('session', $session)->first();
    @endphp
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-2">
            <h4 class="font-semibold text-gray-700 capitalize">
                {{ $session == 'breakfast' ? '🌅' : ($session == 'lunch' ? '☀️' : '🌙') }}
                {{ ucfirst($session) }}
            </h4>
            <span class="text-xs px-2 py-1 rounded-full
                {{ $sessionMeal ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $sessionMeal ? 'Recorded' : 'Not yet' }}
            </span>
        </div>
        @if($sessionMeal)
            <p class="text-2xl font-bold text-blue-900">{{ $sessionMeal->taken_count }}</p>
            <p class="text-xs text-gray-500">students fed today</p>
        @else
            <p class="text-sm text-gray-400">No records for today</p>
        @endif
    </div>
    @endforeach
</div>

{{-- Session Selector --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h4 class="font-semibold text-gray-700 mb-4">Record Meal Session</h4>
    <form action="{{ route('admin.meals.load') }}" method="POST"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
            <select name="class" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Select Class —</option>
                @foreach($classes as $class)
                    <option value="{{ $class->name }}"
                        {{ isset($selectedClass) && $selectedClass == $class->name ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Session *</label>
            <select name="session" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Select Session —</option>
                <option value="breakfast" {{ isset($selectedSession) && $selectedSession == 'breakfast' ? 'selected' : '' }}>🌅 Breakfast</option>
                <option value="lunch"     {{ isset($selectedSession) && $selectedSession == 'lunch'     ? 'selected' : '' }}>☀️ Lunch</option>
                <option value="dinner"    {{ isset($selectedSession) && $selectedSession == 'dinner'    ? 'selected' : '' }}>🌙 Dinner</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
            <input type="date" name="date"
                   value="{{ $selectedDate ?? $today }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                Load Students
            </button>
        </div>

    </form>
</div>

{{-- Meal Recording Form --}}
@if(isset($students) && $students->count() > 0)
<form action="{{ route('admin.meals.store') }}" method="POST">
    @csrf
    <input type="hidden" name="class"   value="{{ $selectedClass }}">
    <input type="hidden" name="date"    value="{{ $selectedDate }}">
    <input type="hidden" name="session" value="{{ $selectedSession }}">

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">
                {{ ucfirst($selectedSession) }} — {{ $selectedClass }} — {{ $selectedDate }}
                <span class="text-sm text-gray-400 ml-2">({{ $students->count() }} students)</span>
            </h4>
            <div class="flex space-x-2">
                <button type="button" onclick="markAllMeals('taken')"
                        class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs hover:bg-green-200">
                    ✅ All Taken
                </button>
                <button type="button" onclick="markAllMeals('not_taken')"
                        class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs hover:bg-red-200">
                    ❌ All Not Taken
                </button>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adm. No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Taken</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Not Taken</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="mealTable">
                @foreach($students as $index => $student)
                @php $currentStatus = $existing[$student->id] ?? 'taken'; @endphp
                <tr class="hover:bg-gray-50 meal-row">
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-3 text-sm font-medium text-blue-900">{{ $student->admission_number }}</td>
                    <td class="px-6 py-3 text-sm text-gray-900">{{ $student->full_name }}</td>
                    <td class="px-6 py-3 text-center">
                        <input type="radio"
                               name="meals[{{ $student->id }}]"
                               value="taken"
                               class="meal-radio w-4 h-4 text-green-600"
                               {{ $currentStatus == 'taken' ? 'checked' : '' }}>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <input type="radio"
                               name="meals[{{ $student->id }}]"
                               value="not_taken"
                               class="meal-radio w-4 h-4 text-red-600"
                               {{ $currentStatus == 'not_taken' ? 'checked' : '' }}>
                    </td>
                    <td class="px-6 py-3">
                        <input type="text"
                               name="remarks[{{ $student->id }}]"
                               placeholder="Optional"
                               class="w-full border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <div class="text-sm text-gray-500" id="mealSummary"></div>
            <button type="submit"
                    class="bg-blue-900 text-white px-8 py-2 rounded-lg hover:bg-blue-800 transition font-semibold">
                Save Meal Records
            </button>
        </div>
    </div>
</form>

@elseif(isset($students) && $students->count() == 0)
<div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
    No active students found in this class.
</div>
@endif

<script>
    function markAllMeals(status) {
        document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => r.checked = true);
        updateMealSummary();
    }

    function updateMealSummary() {
        let taken = 0, notTaken = 0;
        document.querySelectorAll('.meal-row').forEach(row => {
            const checked = row.querySelector('input[type="radio"]:checked');
            if (checked) {
                if (checked.value === 'taken') taken++;
                else notTaken++;
            }
        });
        const summary = document.getElementById('mealSummary');
        if (summary) {
            summary.innerHTML = `✅ Taken: <strong>${taken}</strong> &nbsp;|&nbsp; ❌ Not Taken: <strong>${notTaken}</strong>`;
        }
    }

    document.querySelectorAll('.meal-radio').forEach(r => r.addEventListener('change', updateMealSummary));
    updateMealSummary();
</script>

@endsection