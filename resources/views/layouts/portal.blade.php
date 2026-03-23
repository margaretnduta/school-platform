<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Platform — Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

<div class="min-h-screen">

    {{-- Top Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold">🏫 SchoolAdmin Kenya</h1>
            <p class="text-xs text-blue-300">Student / Parent Portal</p>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-blue-200">👤 {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- Portal Navigation --}}
    <div class="bg-white border-b border-gray-200 px-6 py-3 flex space-x-6">
        @if(auth()->user()->hasRole('parent'))
            <a href="{{ route('parent.dashboard') }}"
               class="text-sm font-medium {{ request()->routeIs('parent.dashboard') ? 'text-blue-900 border-b-2 border-blue-900 pb-1' : 'text-gray-500 hover:text-blue-900' }}">
                Dashboard
            </a>
            <a href="{{ route('parent.admissions.index') }}"
               class="text-sm font-medium {{ request()->routeIs('parent.admissions.*') ? 'text-blue-900 border-b-2 border-blue-900 pb-1' : 'text-gray-500 hover:text-blue-900' }}">
                Admissions
            </a>
        @endif

        @if(auth()->user()->hasRole('student'))
            <a href="{{ route('student.dashboard') }}"
               class="text-sm font-medium {{ request()->routeIs('student.dashboard') ? 'text-blue-900 border-b-2 border-blue-900 pb-1' : 'text-gray-500 hover:text-blue-900' }}">
                Dashboard
            </a>
            <a href="{{ route('student.admissions.index') }}"
               class="text-sm font-medium {{ request()->routeIs('student.admissions.*') ? 'text-blue-900 border-b-2 border-blue-900 pb-1' : 'text-gray-500 hover:text-blue-900' }}">
                My Application
            </a>
        @endif
    </div>

    {{-- Page Title --}}
    <div class="bg-white border-b border-gray-100 px-6 py-4">
        <h2 class="text-lg font-semibold text-gray-700">@yield('page_title')</h2>
    </div>

    {{-- Content --}}
    <main class="p-6">
        @yield('content')
    </main>

</div>

</body>
</html>