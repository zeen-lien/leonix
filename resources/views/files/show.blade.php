<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6 sm:p-8">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-3xl font-bold cyberpunk-gradient leading-tight">
                            {{ $file->original_name }}
                        </h2>
                        <div class="text-sm text-gray-400 mt-2">
                            Uploaded on {{ $file->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('files.download', $file) }}" class="btn-gradient">
                            Download
                        </a>
                        <a href="{{ route('files.edit', $file) }}" class="px-4 py-2 rounded-lg bg-gray-700/70 hover:bg-gray-600/70 border border-gray-600/90 text-white font-bold transition-all">
                            Edit
                        </a>
                    </div>
                </div>

                <!-- File Preview -->
                <div class="mb-8 border-2 border-gray-700/50 rounded-lg overflow-hidden bg-gray-900/50">
                    @if($file->isImage())
                        <img src="{{ route('files.preview', $file) }}" alt="Preview of {{ $file->original_name }}" class="w-full h-auto max-h-[70vh] object-contain">
                    @elseif($file->isVideo() || $file->isAudio())
                        <video controls class="w-full">
                            <source src="{{ route('files.preview', $file) }}" type="{{ $file->mime_type }}">
                            Your browser does not support the video tag.
                        </video>
                    @elseif($file->isPreviewable())
                         <iframe src="{{ route('files.preview', $file) }}" class="w-full h-[80vh]" frameborder="0"></iframe>
                    @else
                        <div class="p-12 text-center">
                            <h3 class="text-xl font-semibold text-gray-300">No preview available</h3>
                            <p class="text-gray-500 mt-2">
                                You can download the file to view it.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- File Details -->
                <div>
                    <h3 class="text-2xl font-bold cyberpunk-gradient mb-6">File Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6 text-gray-300">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">File Name</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-200">{{ $file->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Original Name</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-200">{{ $file->original_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Size</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-200">{{ $file->formatted_size }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">MIME Type</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-200">{{ $file->mime_type }}</dd>
                        </div>
                         <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-lg font-semibold prose prose-invert max-w-none text-gray-200">
                                {!! $file->description ? nl2br(e($file->description)) : '<span class="text-gray-400">No description provided.</span>' !!}
                            </dd>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout> 