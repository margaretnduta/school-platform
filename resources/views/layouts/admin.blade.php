<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Platform - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-primary-700 to-primary-900 text-white flex flex-col flex-shrink-0 shadow-lg">

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-primary-600/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center text-xl">
                    🏫
                </div>
                <div>
                    <h1 class="text-lg font-bold">SchoolAdmin</h1>
                    <p class="text-xs text-primary-200 mt-0.5">Admin Portal</p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">📊</span> Dashboard
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.students.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">🎓</span> Students
            </a>

            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.staff.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">👨‍🏫</span> Staff
            </a>

            <a href="{{ route('admin.classes.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.classes.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">🏫</span> Classes
            </a>

            <a href="{{ route('admin.dormitories.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.dormitories.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">🛏️</span> Dormitories
            </a>

            <a href="{{ route('admin.admissions.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.admissions.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">📋</span> Admissions
            </a>

            <a href="{{ route('admin.attendance.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.attendance.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">✅</span> Attendance
            </a>

            <a href="{{ route('admin.meals.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.meals.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">🍽️</span> Meals
            </a>

            <a href="{{ route('admin.academics.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.academics.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">📚</span> Academics
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium {{ request()->routeIs('admin.events.*') ? 'bg-primary-600 shadow-md' : 'hover:bg-white/10' }}">
                <span class="mr-3 text-lg">📅</span> Events
            </a>

        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-primary-600/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-4 py-2.5 rounded-lg hover:bg-primary-600/50 transition font-medium hover:bg-white/10">
                    <span class="mr-3 text-lg">🚪</span> Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Navbar -->
        <header class="bg-white border-b border-gray-200 shadow-sm px-6 py-4 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">@yield('page_title', 'Dashboard')</h2>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>