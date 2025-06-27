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
                            <h1 class="text-3xl font-bold text-cyan-400">User Details</h1>
                            <p class="text-gray-400 mt-2">View detailed information about this user.</p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold transition-all duration-300">
                                Edit User
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white font-bold transition-all duration-300">
                                Back to Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Profile -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <div class="w-24 h-24 mx-auto bg-gray-600 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-3xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                                <p class="text-gray-400">{{ $user->email }}</p>
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 mt-2">Admin</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mt-2">User</span>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Joined:</span>
                                    <span class="text-white">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Email Verified:</span>
                                    <span class="text-white">
                                        @if($user->email_verified_at)
                                            <span class="text-green-400">Yes</span>
                                        @else
                                            <span class="text-yellow-400">No</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Total Files:</span>
                                    <span class="text-white">{{ $user->files->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Storage Used:</span>
                                    <span class="text-white">{{ $user->formatted_storage_used }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Files -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-6">User Files</h3>
                            
                            @if($files->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-700">
                                        <thead class="bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">File</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Size</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Uploaded</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                                            @foreach($files as $file)
                                            <tr class="hover:bg-gray-700">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8">
                                                            <div class="h-8 w-8 rounded bg-gray-600 flex items-center justify-center">
                                                                <span class="text-sm">{{ $file->file_icon }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm font-medium text-white">{{ $file->original_name }}</div>
                                                            @if($file->is_public)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Public</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                                    {{ $file->formatted_size }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ strtoupper($file->extension) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                                    {{ $file->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        @if($file->preview_url)
                                                        <a href="{{ $file->preview_url }}" 
                                                           target="_blank"
                                                           class="text-blue-400 hover:text-blue-300"
                                                           title="Preview">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                        @endif
                                                        <a href="{{ $file->download_url }}" 
                                                           class="text-green-400 hover:text-green-300"
                                                           title="Download">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($files->hasPages())
                                <div class="mt-6">
                                    {{ $files->links() }}
                                </div>
                                @endif
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-gray-600 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-white mb-2">No files uploaded</h3>
                                    <p class="text-gray-400">This user hasn't uploaded any files yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 