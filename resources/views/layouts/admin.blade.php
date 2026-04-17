<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Platform - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-blue-900 text-white flex flex-col flex-shrink-0">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-blue-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-lg flex-shrink-0">
                    🏫
                </div>
                <div>
                    <h1 class="text-base font-bold leading-tight">SchoolAdmin</h1>
                    <p class="text-xs text-blue-300 leading-tight">Administration Portal</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📊</span>
                Dashboard
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.students.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">🎓</span>
                Students
            </a>

            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.staff.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">👨‍🏫</span>
                Staff
            </a>

            <a href="{{ route('admin.classes.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.classes.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">🏫</span>
                Classes
            </a>

            <a href="{{ route('admin.dormitories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.dormitories.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">🛏️</span>
                Dormitories
            </a>

            <a href="{{ route('admin.admissions.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.admissions.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📋</span>
                Admissions
            </a>

            <a href="{{ route('admin.attendance.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.attendance.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">✅</span>
                Attendance
            </a>

            <a href="{{ route('admin.meals.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.meals.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">🍽️</span>
                Meals
            </a>

            <a href="{{ route('admin.academics.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.academics.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📚</span>
                Academics
            </a>

            <a href="{{ route('admin.exams.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.exams.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📝</span>
                Exams
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.events.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <span class="text-base w-5 text-center">📅</span>
                Events
            </a>

        </nav>

        {{-- User & Logout --}}
        <div class="px-3 py-4 border-t border-blue-800">
            <div class="flex items-center gap-3 px-3 py-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-sm flex-shrink-0">
                    👤
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-blue-300 truncate">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm
                               text-blue-100 hover:bg-white/10 hover:text-white transition-colors">
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
                <p class="text-xs text-gray-400 mt-0.5">@yield('page_subtitle', 'School Digital Administration Platform')</p>
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