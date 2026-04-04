<x-app-layout>
    <x-slot name="header">
        <h2 class="text-heading">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Stats Cards -->
            <x-card>
                <x-card-body>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">250</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a2 2 0 002-2v-2a3 3 0 00-5.856-1.487M6 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                </x-card-body>
            </x-card>

            <x-card>
                <x-card-body>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Students</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">180</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-success-500 to-success-600 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                    </div>
                </x-card-body>
            </x-card>

            <x-card>
                <x-card-body>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Staff</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">45</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM9 19c-4.35 0-8 1.343-8 3v2h16v-2c0-1.657-3.65-3-8-3z" />
                            </svg>
                        </div>
                    </div>
                </x-card-body>
            </x-card>

            <x-card>
                <x-card-body>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Attendance Rate</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">92%</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-warning-500 to-warning-600 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </x-card-body>
            </x-card>
        </div>

        <!-- Recent Activity -->
        <x-card class="mb-8">
            <x-card-header>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                </div>
                <a href="#" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </x-card-header>
            <x-card-body>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">New student admission</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                        <x-badge variant="success">New</x-badge>
                    </div>
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-success-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Attendance recorded</p>
                            <p class="text-xs text-gray-500">4 hours ago</p>
                        </div>
                        <x-badge variant="success">Complete</x-badge>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-warning-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Pending approvals</p>
                            <p class="text-xs text-gray-500">6 hours ago</p>
                        </div>
                        <x-badge variant="warning">Pending</x-badge>
                    </div>
                </div>
            </x-card-body>
        </x-card>
    </div>
</x-app-layout>
