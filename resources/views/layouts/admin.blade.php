<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Platform - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-900 text-white flex flex-col flex-shrink-0">

        <!-- Logo -->
        <div class="px-6 py-5 border-b border-blue-800">
            <h1 class="text-xl font-bold">🏫 SchoolAdmin</h1>
            <p class="text-xs text-blue-300 mt-1">Administration Panel</p>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">📊</span> Dashboard
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.students.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">🎓</span> Students
            </a>

            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.staff.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">👨‍🏫</span> Staff
            </a>

            <a href="{{ route('admin.classes.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.classes.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">🏫</span> Classes
            </a>

            <a href="{{ route('admin.dormitories.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.dormitories.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">🛏️</span> Dormitories
            </a>

            <a href="{{ route('admin.admissions.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.admissions.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">📋</span> Admissions
            </a>

            <a href="{{ route('admin.attendance.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.attendance.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">✅</span> Attendance
            </a>

            <a href="{{ route('admin.meals.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.meals.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">🍽️</span> Meals
            </a>

            <a href="{{ route('admin.academics.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.academics.*') ? 'bg-blue-800' : '' }}">
                <span class="mr-3">📚</span> Academics
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.events.*') ? 'bg-blue-800' :'' }}">
                <span class="mr-3">📅</span> Events
            </a>

        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-blue-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-4 py-2 rounded-lg hover:bg-blue-800 transition text-left">
                    <span class="mr-3">🚪</span> Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Navbar -->
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-700">@yield('page_title', 'Dashboard')</h2>
            <div class="text-sm text-gray-500">
                👤 {{ auth()->user()->name }} &nbsp;|&nbsp; Admin
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