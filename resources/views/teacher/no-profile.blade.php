@extends('layouts.teacher')

@section('page_title', 'No Profile Found')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-xl shadow p-10 text-center mt-10">
    <p class="text-5xl mb-4">⚠️</p>
    <h3 class="text-xl font-bold text-gray-700 mb-2">No Staff Profile Found</h3>
    <p class="text-gray-500 text-sm">
        Your account is not linked to a staff profile yet.
        Please contact the administrator to link your account.
    </p>
    <p class="text-xs text-gray-400 mt-3">
        Make sure your staff profile email matches: <strong>{{ auth()->user()->email }}</strong>
    </p>
</div>
@endsection