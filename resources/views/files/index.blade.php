<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header -->
            <div class="glass-card">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold cyberpunk-gradient">Berkas Saya</h1>
                        <p class="mt-2 text-gray-400">Kelola semua file dan folder Anda di satu tempat.</p>
                    </div>
                    <div class="flex space-x-2">
                        <button 
                            @click="$dispatch('open-upload-modal', { folderId: null })"
                            class="px-3 py-2 text-sm rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all duration-300 transform hover:scale-105">
                            Upload File
                        </button>
                        <button 
                            @click="$dispatch('open-folder-modal', { parentId: null })"
                            class="px-3 py-2 text-sm rounded-lg bg-gradient-to-r from-[#FF5AF7] to-[#00FFC6] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#FF5AF7]/20 transition-all duration-300 transform hover:scale-105">
                            Folder Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Folders -->
            @if($folders->isNotEmpty())
                <div class="glass-card">
                    <h2 class="text-xl font-bold cyberpunk-gradient mb-6">Folders</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                        @foreach ($folders as $folder)
                            <div class="relative group">
                                <a href="{{ route('folders.show', $folder) }}" 
                                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:border-[#FF5AF7] transition-all duration-300 aspect-square">
                                    <svg class="w-16 h-16 text-[#FF5AF7]/80 group-hover:text-[#FF5AF7] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm font-medium text-center text-gray-200 truncate" title="{{ $folder->name }}">
                                        {{ $folder->name }}
                                    </p>
                                </a>
                                <!-- Folder Actions -->
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="flex space-x-1">
                                        <a href="{{ route('folders.edit', $folder) }}" class="p-1.5 bg-gray-700 rounded-full text-white hover:bg-gray-600 transition-colors" title="Ubah Folder">
                                            <x-lucide-pencil class="w-4 h-4" />
                                        </a>
                                        <button 
                                            @click.prevent="$dispatch('show-confirm-dialog', {
                                                title: 'Hapus Folder',
                                                message: 'Anda yakin ingin menghapus folder \'{{ addslashes($folder->name) }}\'? Semua file dan subfolder di dalamnya akan dipindahkan ke tempat sampah.',
                                                action: '{{ route('folders.destroy', $folder->id) }}'
                                            })"
                                            class="p-1.5 bg-red-600 rounded-full text-white hover:bg-red-500 transition-colors" 
                                            title="Hapus Folder">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Files -->
            <div class="glass-card">
                <h2 class="text-xl font-bold cyberpunk-gradient mb-6">Files</h2>
                @if($files->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($files as $file)
                            <div class="p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:border-[#00FFC6] transition-all duration-300 group">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#00FFC6]/10 to-[#FF5AF7]/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        {{-- Icon logic here based on file type --}}
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-200 truncate" title="{{ $file->name }}">{{ $file->name }}</h3>
                                        <p class="mt-1 text-xs text-gray-400">{{ $file->formatted_size }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('files.show', $file) }}" class="p-2 rounded-lg hover:bg-[#00FFC6]/10 text-[#00FFC6] transition-colors" title="View">
                                            <x-lucide-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('files.download', $file) }}" class="p-2 rounded-lg hover:bg-[#FF5AF7]/10 text-[#FF5AF7] transition-colors" title="Download">
                                            <x-lucide-download class="w-4 h-4" />
                                        </a>
                                        <button @click.prevent="$dispatch('show-confirm-dialog', {
                                            title: 'Pindahkan File ke Sampah?',
                                            message: 'Yakin ingin memindahkan file \'{{ addslashes($file->name) }}\' ke tempat sampah?',
                                            action: '{{ route('files.destroy', $file) }}'
                                        })" class="p-2 rounded-lg hover:bg-red-500/10 text-red-500 transition-colors" title="Hapus">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($folders->isEmpty())
                     <div class="text-center text-gray-500 py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                           <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                       </svg>
                       <p class="mt-4 text-sm font-semibold">Tidak ada berkas</p>
                       <p class="mt-1 text-xs">Mulai dengan mengunggah file atau membuat folder baru.</p>
                   </div>
                @endif

                @if($files->hasPages())
                <div class="mt-8">
                    {{ $files->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    <x-folder-create-modal :folders="$allFolders" />
    <x-upload-modal :folders="$allFolders" />
</x-app-layout> 