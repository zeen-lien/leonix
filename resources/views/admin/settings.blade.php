@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-cyan-400">System Settings</h1>
                            <p class="text-gray-400 mt-2">Monitor system performance and configuration.</p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white font-bold transition-all duration-300">
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-400 truncate">Total Users</dt>
                                    <dd class="text-lg font-medium text-white">{{ $stats['total_users'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Files -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-400 truncate">Total Files</dt>
                                    <dd class="text-lg font-medium text-white">{{ $stats['total_files'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Storage -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-400 truncate">Total Storage</dt>
                                    <dd class="text-lg font-medium text-white">{{ $stats['total_size'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disk Usage -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-400 truncate">Disk Usage</dt>
                                    <dd class="text-lg font-medium text-white">{{ $stats['disk_usage']['used'] }} / {{ $stats['disk_usage']['total'] }}</dd>
                                    <dd class="text-sm text-gray-400">{{ $stats['disk_usage']['percentage'] }}% used</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- System Details -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white mb-4">System Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-400">PHP Version:</span>
                                <span class="text-white">{{ $stats['php_version'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Laravel Version:</span>
                                <span class="text-white">{{ $stats['laravel_version'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Server Time:</span>
                                <span class="text-white">{{ now()->format('Y-m-d H:i:s') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Timezone:</span>
                                <span class="text-white">{{ config('app.timezone') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Environment:</span>
                                <span class="text-white">{{ config('app.env') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Debug Mode:</span>
                                <span class="text-white">
                                    @if(config('app.debug'))
                                        <span class="text-green-400">Enabled</span>
                                    @else
                                        <span class="text-red-400">Disabled</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Storage Information -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Storage Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Storage Driver:</span>
                                <span class="text-white">{{ config('filesystems.default') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Public Disk:</span>
                                <span class="text-white">{{ config('filesystems.disks.public.driver') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Storage Path:</span>
                                <span class="text-white">{{ storage_path('app/public') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Max File Size:</span>
                                <span class="text-white">100 MB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Allowed Extensions:</span>
                                <span class="text-white">All</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Actions -->
            <div class="mt-8 bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Maintenance Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold transition-all duration-300">
                            Clear Cache
                        </button>
                        <button class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-bold transition-all duration-300">
                            Optimize Database
                        </button>
                        <button class="px-4 py-2 rounded-lg bg-yellow-600 hover:bg-yellow-700 text-white font-bold transition-all duration-300">
                            Backup System
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 