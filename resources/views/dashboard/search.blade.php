<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search Header -->
            <div class="glass-card p-4 sm:p-6">
                <h1 class="text-2xl font-bold cyberpunk-gradient">Hasil Pencarian untuk:</h1>
                <p class="mt-1 text-xl text-white font-mono bg-gray-800/50 px-3 py-1 rounded-md inline-block">{{ $query }}</p>
                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-gray-700/70 hover:bg-gray-600/70 border border-gray-600/90 text-white font-bold transition-all">
                        <x-lucide-arrow-left class="w-4 h-4" />
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Folders Results -->
            @if($folders->count() > 0)
                <div class="glass-card">
                    <h2 class="text-xl font-bold cyberpunk-gradient mb-4">Folder</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach ($folders as $folder)
                            <a href="{{ route('folders.show', $folder) }}" 
                               class="relative group flex flex-col items-center justify-center p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:border-[#FF5AF7] transition-all duration-300 aspect-square">
                                <x-lucide-folder class="w-12 h-12 text-[#FF5AF7]/80 group-hover:text-[#FF5AF7] transition-colors"/>
                                <p class="mt-2 text-sm font-medium text-center text-gray-200 truncate w-full" title="{{ $folder->name }}">{{ $folder->name }}</p>
                            </a>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $folders->links() }}
                    </div>
                </div>
            @endif

            <!-- Files Results -->
            @if($files->count() > 0)
                <div class="glass-card">
                    <h2 class="text-xl font-bold cyberpunk-gradient mb-4">Berkas</h2>
                    <div class="space-y-3">
                        @foreach ($files as $file)
                            <div class="p-3 rounded-lg bg-gray-800/50 hover:bg-gray-700/50 transition-colors flex items-center gap-4">
                                <span class="text-2xl">{{ $file->file_icon }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate" title="{{ $file->name }}">{{ $file->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $file->formatted_size }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('files.download', $file) }}" class="text-gray-400 hover:text-white" title="Unduh"><x-lucide-download class="w-4 h-4"/></a>
                                    <a href="{{ route('files.show', $file) }}" class="text-gray-400 hover:text-white" title="Lihat"><x-lucide-eye class="w-4 h-4"/></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $files->links() }}
                    </div>
                </div>
            @endif
            
            @if($files->count() === 0 && $folders->count() === 0)
                <div class="glass-card text-center text-gray-500 py-16">
                    <x-lucide-search-x class="mx-auto h-16 w-16 text-gray-600" />
                    <p class="mt-4 text-lg font-semibold">Tidak Ada Hasil Ditemukan</p>
                    <p class="mt-1 text-sm">Coba gunakan kata kunci pencarian yang berbeda.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout> 