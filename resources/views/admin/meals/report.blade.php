@extends('layouts.admin')

@section('page_title', 'Meal Report')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Meal Report</h3>
    <a href="{{ route('admin.meals.index') }}"
       class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        🍽️ Record Meals
    </a>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('admin.meals.report') }}" method="GET"
          class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
            <select name="session"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Sessions</option>
                <option value="breakfast" {{ $selectedSession == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                <option value="lunch"     {{ $selectedSession == 'lunch'     ? 'selected' : '' }}>Lunch</option>
                <option value="dinner"    {{ $selectedSession == 'dinner'    ? 'selected' : '' }}>Dinner</option>
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

@if($records->count() > 0)

{{-- Summary Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-blue-900">{{ $records->count() }}</p>
        <p class="text-sm text-gray-500">Total Sessions</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-green-600">{{ $records->sum('taken_count') }}</p>
        <p class="text-sm text-gray-500">Total Meals Taken</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-yellow-600">{{ $records->where('session','breakfast')->count() }}</p>
        <p class="text-sm text-gray-500">Breakfast Sessions</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-purple-600">{{ $records->where('session','dinner')->count() }}</p>
        <p class="text-sm text-gray-500">Dinner Sessions</p>
    </div>
</div>

{{-- Sessions Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h4 class="font-semibold text-gray-700">Meal Sessions</h4>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Session</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Taken</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Not Taken</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($records as $meal)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-700">{{ $meal->date->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $meal->session == 'breakfast' ? 'bg-yellow-100 text-yellow-700' :
                           ($meal->session == 'lunch'    ? 'bg-blue-100 text-blue-700'    :
                                                           'bg-purple-100 text-purple-700') }}">
                        {{ ucfirst($meal->session) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $meal->class }}</td>
                <td class="px-6 py-4 text-sm font-semibold text-green-600">{{ $meal->taken_count }}</td>
                <td class="px-6 py-4 text-sm font-semibold text-red-500">{{ $meal->not_taken_count }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.meals.show', $meal) }}"
                       class="text-blue-600 hover:underline">View Session</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@else
<div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
    No meal records found for the selected filters.
</div>
@endif

@endsection