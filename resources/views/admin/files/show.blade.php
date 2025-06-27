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
                            <h1 class="text-3xl font-bold text-cyan-400">File Details</h1>
                            <p class="text-gray-400 mt-2">View detailed information about this file.</p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.files.index') }}" 
                               class="px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white font-bold transition-all duration-300">
                                Back to Files
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- File Details -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start space-x-4 mb-6">
                                <div class="w-16 h-16 rounded-lg bg-gray-600 flex items-center justify-center">
                                    <span class="text-3xl">{{ $file->file_icon }}</span>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-white mb-2">{{ $file->original_name }}</h2>
                                    <p class="text-gray-400">{{ $file->extension }} • {{ $file->formatted_size }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-lg font-medium text-white mb-4">File Information</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">File Name:</span>
                                            <span class="text-white">{{ $file->name }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Original Name:</span>
                                            <span class="text-white">{{ $file->original_name }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">File Type:</span>
                                            <span class="text-white">{{ $file->mime_type }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">File Size:</span>
                                            <span class="text-white">{{ $file->formatted_size }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Extension:</span>
                                            <span class="text-white">{{ $file->extension }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Uploaded:</span>
                                            <span class="text-white">{{ $file->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Last Modified:</span>
                                            <span class="text-white">{{ $file->updated_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Public:</span>
                                            <span class="text-white">
                                                @if($file->is_public)
                                                    <span class="text-green-400">Yes</span>
                                                @else
                                                    <span class="text-red-400">No</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-medium text-white mb-4">Owner Information</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Owner:</span>
                                            <span class="text-white">{{ $file->user->name }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Email:</span>
                                            <span class="text-white">{{ $file->user->email }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">User ID:</span>
                                            <span class="text-white">{{ $file->user->id }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Joined:</span>
                                            <span class="text-white">{{ $file->user->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($file->description)
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-white mb-2">Description</h3>
                                <p class="text-gray-300">{{ $file->description }}</p>
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="mt-8 flex space-x-4">
                                @if($file->preview_url)
                                <a href="{{ $file->preview_url }}" target="_blank"
                                   class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold transition-all duration-300">
                                    Preview
                                </a>
                                @endif
                                <a href="{{ $file->download_url }}" 
                                   class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-bold transition-all duration-300">
                                    Download
                                </a>
                                <form method="POST" action="{{ route('admin.files.delete', $file) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to permanently delete this file? This action cannot be undone.')"
                                            class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition-all duration-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Preview -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white mb-4">File Preview</h3>
                            
                            @if($file->isImage())
                                <img src="{{ $file->preview_url }}" alt="{{ $file->original_name }}" 
                                     class="w-full h-48 object-cover rounded-lg">
                            @elseif($file->isVideo())
                                <video controls class="w-full h-48 object-cover rounded-lg">
                                    <source src="{{ $file->preview_url }}" type="{{ $file->mime_type }}">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif($file->isAudio())
                                <audio controls class="w-full">
                                    <source src="{{ $file->preview_url }}" type="{{ $file->mime_type }}">
                                    Your browser does not support the audio tag.
                                </audio>
                            @else
                                <div class="w-full h-48 bg-gray-700 rounded-lg flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="text-4xl mb-2 block">{{ $file->file_icon }}</span>
                                        <p class="text-gray-400 text-sm">Preview not available</p>
                                        <a href="{{ $file->download_url }}" 
                                           class="text-cyan-400 hover:text-cyan-300 text-sm mt-2 inline-block">
                                            Download to view
                                        </a>
                                    </div>
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