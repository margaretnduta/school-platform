<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Digital Administration Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold">🏫 SchoolAdmin Kenya</h1>
            <p class="text-xs text-blue-300">Digital Administration Platform</p>
        </div>
        <div class="space-x-4">
            <a href="{{ route('login') }}"
               class="bg-white text-blue-900 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-50 transition">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 transition">
                Register
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="bg-blue-900 text-white py-20 px-6 text-center">
        <h2 class="text-4xl font-bold mb-4">Welcome to School Digital Administration</h2>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto mb-8">
            A modern platform for managing school admissions, attendance, academics,
            dormitories, and more — built for Kenyan schools.
        </p>
        <a href="{{ route('register') }}"
           class="bg-white text-blue-900 px-8 py-3 rounded-lg font-bold text-lg hover:bg-blue-50 transition">
            Apply for Admission
        </a>
    </div>

    {{-- Features --}}
    <div class="max-w-6xl mx-auto px-6 py-16">
        <h3 class="text-2xl font-bold text-center text-gray-700 mb-12">What You Can Do</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-5xl mb-4">👨‍👩‍👦</div>
                <h4 class="text-lg font-bold text-blue-900 mb-2">Parents</h4>
                <p class="text-gray-500 text-sm">
                    Register and apply for your child's admission online.
                    Track their academic progress, attendance, and fee statements.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-5xl mb-4">🎓</div>
                <h4 class="text-lg font-bold text-blue-900 mb-2">Students</h4>
                <p class="text-gray-500 text-sm">
                    Apply directly for admission. View your results,
                    timetable, and school announcements after enrollment.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="text-5xl mb-4">👨‍💼</div>
                <h4 class="text-lg font-bold text-blue-900 mb-2">Administration</h4>
                <p class="text-gray-500 text-sm">
                    Manage admissions, classes, dormitories, attendance,
                    meals, and generate reports — all in one place.
                </p>
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-blue-900 text-blue-300 text-center py-6 text-sm">
        © {{ date('Y') }} SchoolAdmin Kenya. All rights reserved.
    </footer>

</body>
</html>