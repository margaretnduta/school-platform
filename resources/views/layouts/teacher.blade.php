<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Platform - Teacher</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-800 text-white flex flex-col flex-shrink-0">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-lg flex-shrink-0">
                    🏫
                </div>
                <div>
                    <h1 class="text-base font-bold leading-tight">SchoolAdmin</h1>
                    <p class="text-xs text-slate-400 leading-tight">Teacher Portal</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <a href="{{ route('teacher.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('teacher.dashboard') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📊</span>
                Dashboard
            </a>

            <a href="{{ route('teacher.students') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('teacher.students') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">🎓</span>
                My Students
            </a>

            <a href="{{ route('teacher.attendance') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('teacher.attendance') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">✅</span>
                Attendance
            </a>

            <a href="{{ route('teacher.marks') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('teacher.marks') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📝</span>
                Enter Marks
            </a>

        </nav>

        {{-- User & Logout --}}
        <div class="px-3 py-4 border-t border-slate-700">
            <div class="flex items-center gap-3 px-3 py-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-sm flex-shrink-0">
                    👤
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">Teacher</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm
                               text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <span class="text-base w-5 text-center">🚪</span>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Header --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                <p class="text-xs text-gray-400 mt-0.5">@yield('page_subtitle', 'Teacher Portal')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ date('l, d M Y') }}</span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>