@extends('layouts.admin')

@section('page_title', 'Review Application')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto">

    {{-- Application Header --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-blue-900">{{ $admission->full_name }}</h3>
                <p class="text-sm text-gray-500 mt-1">Application No: {{ $admission->application_number }}</p>
                <p class="text-sm text-gray-500">Submitted: {{ $admission->created_at->format('d M Y') }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                {{ $admission->status == 'pending'  ? 'bg-yellow-100 text-yellow-700' :
                   ($admission->status == 'approved' ? 'bg-green-100 text-green-700'  : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($admission->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        {{-- Student Details --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-4">Student Details</h4>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Full Name:</span>
                    <span class="font-semibold">{{ $admission->full_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Gender:</span>
                    <span class="font-semibold capitalize">{{ $admission->gender }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date of Birth:</span>
                    <span class="font-semibold">{{ $admission->date_of_birth }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Email:</span>
                    <span class="font-semibold">{{ $admission->email ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Phone:</span>
                    <span class="font-semibold">{{ $admission->phone ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Previous School:</span>
                    <span class="font-semibold">{{ $admission->previous_school ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Applying For:</span>
                    <span class="font-semibold">{{ $admission->applying_for_class }}</span>
                </div>
            </div>
        </div>

        {{-- Guardian Details --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-4">Guardian Details</h4>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Name:</span>
                    <span class="font-semibold">{{ $admission->guardian_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Phone:</span>
                    <span class="font-semibold">{{ $admission->guardian_phone }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Email:</span>
                    <span class="font-semibold">{{ $admission->guardian_email ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Relationship:</span>
                    <span class="font-semibold">{{ $admission->guardian_relationship ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Address:</span>
                    <span class="font-semibold">{{ $admission->address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Action Area — only show if pending --}}
    @if($admission->status == 'pending')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Approve Form --}}
        <div class="bg-white rounded-xl shadow p-6 border-t-4 border-green-500">
            <h4 class="font-semibold text-green-700 mb-4">✅ Approve Application</h4>
            <form action="{{ route('admin.admissions.approve', $admission) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Class *</label>
                    <select name="class"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->name }}"
                                {{ $admission->applying_for_class == $class->name ? 'selected' : '' }}>
                                {{ $class->name }} — {{ $class->available_spots }} spots left
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Dormitory (Optional)</label>
                    <select name="dormitory_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">— No Dormitory —</option>
                        @foreach($dormitories as $dormitory)
                            @if($dormitory->gender == $admission->gender || $dormitory->gender == 'mixed')
                                <option value="{{ $dormitory->id }}">
                                    {{ $dormitory->name }}
                                    ({{ ucfirst($dormitory->gender) }})
                                    — {{ $dormitory->available_beds }} beds available
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-500 transition font-semibold">
                    Approve & Create Student Record
                </button>
            </form>
        </div>

        {{-- Reject Form --}}
        <div class="bg-white rounded-xl shadow p-6 border-t-4 border-red-500">
            <h4 class="font-semibold text-red-700 mb-4">❌ Reject Application</h4>
            <form action="{{ route('admin.admissions.reject', $admission) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason *</label>
                    <textarea name="rejection_reason" rows="4" required
                              placeholder="Explain why this application is being rejected..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <button type="submit"
                        onclick="return confirm('Are you sure you want to reject this application?')"
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition font-semibold">
                    Reject Application
                </button>
            </form>
        </div>

    </div>

    {{-- If already approved show student record link --}}
    @elseif($admission->status == 'approved' && $admission->student)
    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
        <h4 class="font-semibold text-green-700 mb-2">✅ Application Approved</h4>
        <p class="text-sm text-gray-600 mb-4">
            Student record created with admission number:
            <span class="font-bold text-green-700">{{ $admission->student->admission_number }}</span>
        </p>
        <a href="{{ route('admin.students.show', $admission->student) }}"
           class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition text-sm">
            View Student Profile
        </a>
    </div>

    @elseif($admission->status == 'rejected')
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <h4 class="font-semibold text-red-700 mb-2">❌ Application Rejected</h4>
        <p class="text-sm text-gray-600">Reason: {{ $admission->rejection_reason }}</p>
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.admissions.index') }}"
           class="text-gray-500 hover:text-gray-700 text-sm">← Back to Admissions</a>
    </div>

</div>

@endsection