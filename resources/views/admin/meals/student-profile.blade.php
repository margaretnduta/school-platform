@extends('layouts.admin')

@section('page_title', 'Student Meal Profile')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Student Header --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-blue-900">{{ $student->full_name }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $student->admission_number }} •
                    {{ $student->class ?? 'No Class' }} •
                    {{ ucfirst($student->gender) }}
                </p>
            </div>
            <a href="{{ route('admin.students.show', $student) }}"
               class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                View Full Profile
            </a>
        </div>

        {{-- Date Filter --}}
        <form action="{{ route('admin.meals.student', $student->id) }}" method="GET"
              class="mt-4 flex space-x-4 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">From</label>
                <input type="date" name="from" value="{{ $from }}"
                       class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">To</label>
                <input type="date" name="to" value="{{ $to }}"
                       class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition">
                Filter
            </button>
        </form>
    </div>

    {{-- Overall Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-blue-900">{{ $totalRecords }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Records</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $totalTaken }}</p>
            <p class="text-sm text-gray-500 mt-1">Meals Taken</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-red-500">{{ $totalNotTaken }}</p>
            <p class="text-sm text-gray-500 mt-1">Meals Missed</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold
                {{ $mealPercentage >= 80 ? 'text-green-600' :
                   ($mealPercentage >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $mealPercentage }}%
            </p>
            <p class="text-sm text-gray-500 mt-1">Meal Rate</p>
        </div>
    </div>

    {{-- Meal Rate Progress Bar --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-2">
            <h4 class="font-semibold text-gray-700">Overall Meal Rate</h4>
            <span class="text-sm font-bold
                {{ $mealPercentage >= 80 ? 'text-green-600' :
                   ($mealPercentage >= 50 ? 'text-yellow-500' : 'text-red-500') }}">
                {{ $mealPercentage }}%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="h-4 rounded-full transition-all
                {{ $mealPercentage >= 80 ? 'bg-green-500' :
                   ($mealPercentage >= 50 ? 'bg-yellow-400' : 'bg-red-500') }}"
                 style="width: {{ $mealPercentage }}%">
            </div>
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>0%</span>
            <span class="{{ $mealPercentage >= 80 ? 'text-green-600 font-semibold' : '' }}">
                @if($mealPercentage >= 80) Good eating habits ✅
                @elseif($mealPercentage >= 50) Needs monitoring ⚠️
                @else Concerning — needs attention ❌
                @endif
            </span>
            <span>100%</span>
        </div>
    </div>

    {{-- Session Breakdown --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Breakfast --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-3xl">🌅</span>
                <div>
                    <h4 class="font-semibold text-gray-700">Breakfast</h4>
                    <p class="text-xs text-gray-400">{{ $breakfastTotal }} sessions recorded</p>
                </div>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-500">Taken:</span>
                <span class="font-bold text-green-600">{{ $breakfastTaken }}</span>
            </div>
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500">Missed:</span>
                <span class="font-bold text-red-500">{{ $breakfastTotal - $breakfastTaken }}</span>
            </div>
            @if($breakfastTotal > 0)
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-yellow-400 h-2 rounded-full"
                     style="width: {{ round(($breakfastTaken / $breakfastTotal) * 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">
                {{ round(($breakfastTaken / $breakfastTotal) * 100) }}% rate
            </p>
            @endif
        </div>

        {{-- Lunch --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-3xl">☀️</span>
                <div>
                    <h4 class="font-semibold text-gray-700">Lunch</h4>
                    <p class="text-xs text-gray-400">{{ $lunchTotal }} sessions recorded</p>
                </div>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-500">Taken:</span>
                <span class="font-bold text-green-600">{{ $lunchTaken }}</span>
            </div>
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500">Missed:</span>
                <span class="font-bold text-red-500">{{ $lunchTotal - $lunchTaken }}</span>
            </div>
            @if($lunchTotal > 0)
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full"
                     style="width: {{ round(($lunchTaken / $lunchTotal) * 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">
                {{ round(($lunchTaken / $lunchTotal) * 100) }}% rate
            </p>
            @endif
        </div>

        {{-- Dinner --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-3xl">🌙</span>
                <div>
                    <h4 class="font-semibold text-gray-700">Dinner</h4>
                    <p class="text-xs text-gray-400">{{ $dinnerTotal }} sessions recorded</p>
                </div>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-500">Taken:</span>
                <span class="font-bold text-green-600">{{ $dinnerTaken }}</span>
            </div>
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500">Missed:</span>
                <span class="font-bold text-red-500">{{ $dinnerTotal - $dinnerTaken }}</span>
            </div>
            @if($dinnerTotal > 0)
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-purple-500 h-2 rounded-full"
                     style="width: {{ round(($dinnerTaken / $dinnerTotal) * 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">
                {{ round(($dinnerTaken / $dinnerTotal) * 100) }}% rate
            </p>
            @endif
        </div>

    </div>

    {{-- Daily Trend Chart --}}
    @if(count($chartLabels) > 0)
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h4 class="font-semibold text-gray-700 mb-4">📈 Daily Meal Trend</h4>
        <canvas id="mealChart" height="100"></canvas>
    </div>
    @endif

    {{-- Recent Records Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="font-semibold text-gray-700">Recent Meal Records</h4>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Session</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentRecords as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $record->meal->date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $record->meal->session == 'breakfast' ? 'bg-yellow-100 text-yellow-700' :
                               ($record->meal->session == 'lunch'    ? 'bg-blue-100 text-blue-700'    :
                                                                       'bg-purple-100 text-purple-700') }}">
                            {{ ucfirst($record->meal->session) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $record->status == 'taken' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $record->status == 'taken' ? '✅ Taken' : '❌ Not Taken' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $record->remarks ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                        No meal records found for this period.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $recentRecords->links() }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.meals.report') }}"
           class="text-gray-500 hover:text-gray-700 text-sm">← Back to Meal Report</a>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(count($chartLabels) > 0)
    const ctx = document.getElementById('mealChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Meals Taken',
                    data: @json($chartTaken),
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: 'Meals Missed',
                    data: @json($chartMissed),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} meal(s)`
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    grid: { display: false },
                    ticks: {
                        maxTicksLimit: 15,
                        callback: function(val, index) {
                            const label = this.getLabelForValue(val);
                            const date  = new Date(label);
                            return date.toLocaleDateString('en-KE', { day: 'numeric', month: 'short' });
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    title: { display: true, text: 'Number of Meals' }
                }
            }
        }
    });
    @endif
</script>

@endsection