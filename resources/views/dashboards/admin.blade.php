@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Card 1 -->
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">🎓</div>
        <div>
            <p class="text-sm text-gray-500">Total Students</p>
            <p class="text-2xl font-bold text-blue-900">0</p>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">👨‍🏫</div>
        <div>
            <p class="text-sm text-gray-500">Total Staff</p>
            <p class="text-2xl font-bold text-blue-900">0</p>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">🏫</div>
        <div>
            <p class="text-sm text-gray-500">Total Classes</p>
            <p class="text-2xl font-bold text-blue-900">0</p>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="text-4xl">📋</div>
        <div>
            <p class="text-sm text-gray-500">Pending Admissions</p>
            <p class="text-2xl font-bold text-blue-900">0</p>
        </div>
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Welcome to School Platform 👋</h3>
    <p class="text-gray-500">Use the sidebar to manage all school operations.</p>
</div>

@endsection