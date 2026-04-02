@extends('layouts.admin')

@section('page_title', 'Report Card')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Term Selector --}}
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <form action="{{ route('admin.academics.report-card', $student->id) }}" method="GET"
              class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Term</label>
                <select name="term"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="term_1" {{ $selectedTerm == 'term_1' ? 'selected' : '' }}>Term 1</option>
                    <option value="term_2" {{ $selectedTerm == 'term_2' ? 'selected' : '' }}>Term 2</option>
                    <option value="term_3" {{ $selectedTerm == 'term_3' ? 'selected' : '' }}>Term 3</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Year</label>
                <select name="year"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit"
                    class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition text-sm">
                Load
            </button>
            <a href="{{ route('admin.academics.class-results') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm">
                ← Back
            </a>
        </form>
    </div>

    {{-- Report Card --}}
    <div class="bg-white rounded-xl shadow overflow-hidden" id="reportCard">

        {{-- Header --}}
        <div class="bg-blue-900 text-white p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold">🏫 School Digital Platform</h2>
                    <p class="text-blue-300 text-sm mt-1">Academic Report Card</p>
                </div>
                <div class="text-right text-sm text-blue-300">
                    <p>{{ ucwords(str_replace('_', ' ', $selectedTerm)) }}</p>
                    <p>{{ $selectedYear }}</p>
                </div>
            </div>
        </div>

        {{-- Student Info --}}
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <x-avatar :photo="$student->photo" :name="$student->full_name" size="lg" />
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 flex-1">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Student Name</p>
                        <p class="font-semibold text-gray-800">{{ $student->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Adm. Number</p>
                        <p class="font-semibold text-blue-900">{{ $student->admission_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Class</p>
                        <p class="font-semibold">{{ $student->class ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Gender</p>
                        <p class="font-semibold capitalize">{{ $student->gender }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-gray-200">
            <div class="bg-white p-4 text-center">
                <p class="text-2xl font-bold text-blue-900">{{ $subjectCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Subjects</p>
            </div>
            <div class="bg-white p-4 text-center">
                <p class="text-2xl font-bold text-blue-900">{{ $meanScore }}</p>
                <p class="text-xs text-gray-500 mt-1">Mean Score</p>
            </div>
            <div class="bg-white p-4 text-center">
                <p class="text-2xl font-bold
                    {{ in_array($meanGrade, ['A','A-','B+']) ? 'text-green-600' :
                      (in_array($meanGrade, ['B','B-','C+']) ? 'text-blue-600' :
                      (in_array($meanGrade, ['C','C-','D+']) ? 'text-yellow-600' : 'text-red-600')) }}">
                    {{ $meanGrade }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Mean Grade</p>
            </div>
            <div class="bg-white p-4 text-center">
                <p class="text-2xl font-bold text-blue-900">{{ $totalPoints }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Points</p>
            </div>
        </div>

        {{-- Subjects Table --}}
        <div class="p-6">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Marks</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Out Of</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Grade</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Points</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                    @php $record = $records[$subject->id] ?? null; @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $subject->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 font-mono">{{ $subject->code }}</td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-800">
                            {{ $record?->marks ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-500">
                            {{ $subject->total_marks }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($record)
                            <span class="px-2 py-1 text-xs rounded font-bold
                                {{ in_array($record->grade, ['A','A-','B+']) ? 'bg-green-100 text-green-700' :
                                  (in_array($record->grade, ['B','B-','C+']) ? 'bg-blue-100 text-blue-700' :
                                  (in_array($record->grade, ['C','C-','D+']) ? 'bg-yellow-100 text-yellow-700' :
                                                                               'bg-red-100 text-red-700')) }}">
                                {{ $record->grade }}
                            </span>
                            @else
                            <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-semibold text-gray-700">
                            {{ $record?->points ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($record)
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $record->status == 'pass' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($record->status) }}
                            </span>
                            @else
                            <span class="text-gray-300 text-xs">Not Entered</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                            No subjects found for this class.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Performance Chart --}}
        @if(array_sum($chartData) > 0)
        <div class="px-6 pb-6">
            <h4 class="font-semibold text-gray-700 mb-4">📈 Performance Across Terms ({{ $selectedYear }})</h4>
            <canvas id="performanceChart" height="80"></canvas>
        </div>
        @endif

        {{-- Footer --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <p class="text-xs text-gray-400">Generated on {{ now()->format('d M Y') }}</p>
            <button onclick="window.print()"
                    class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                🖨️ Print Report Card
            </button>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(array_sum($chartData) > 0)
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Term 1', 'Term 2', 'Term 3'],
            datasets: [{
                label: 'Mean Score',
                data: @json(array_values($chartData)),
                borderColor: 'rgba(30, 58, 138, 1)',
                backgroundColor: 'rgba(30, 58, 138, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(30, 58, 138, 1)',
                pointRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `Mean Score: ${ctx.parsed.y}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 0,
                    max: 100,
                    ticks: { stepSize: 10 },
                    title: { display: true, text: 'Mean Score' }
                }
            }
        }
    });
    @endif
</script>

@endsection