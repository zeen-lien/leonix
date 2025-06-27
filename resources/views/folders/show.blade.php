<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header & Breadcrumbs -->
            <div class="glass-card">
                <!-- Breadcrumbs -->
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('files.index') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Berkas
                            </a>
                        </li>
                        @foreach ($folder->ancestors as $ancestor)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="{{ route('folders.show', $ancestor) }}" class="ml-1 text-sm font-medium text-gray-400 hover:text-white md:ml-2">{{ $ancestor->name }}</a>
                            </div>
                        </li>
                        @endforeach
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">{{ $folder->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold cyberpunk-gradient">{{ $folder->name }}</h1>
                        <p class="mt-2 text-gray-400">Kelola file dan subfolder di dalam folder ini.</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('folders.edit', $folder) }}" 
                           class="px-3 py-2 text-sm rounded-lg bg-gray-700/70 hover:bg-gray-600/70 border border-gray-600/90 text-white font-bold transition-all">
                            Ubah Folder
                        </a>
                        <button 
                            @click="$dispatch('open-upload-modal', { folderId: {{ $folder->id }} })"
                            class="px-3 py-2 text-sm rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all duration-300 transform hover:scale-105">
                            Unggah File
                        </button>
                        <button 
                            @click="$dispatch('open-folder-modal', { parentId: {{ $folder->id }} })"
                            class="px-3 py-2 text-sm rounded-lg bg-gradient-to-r from-[#FF5AF7] to-[#00FFC6] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#FF5AF7]/20 transition-all duration-300 transform hover:scale-105">
                            Folder Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Child Folders -->
            @if($folder->children->isNotEmpty())
                <div class="glass-card">
                    <h2 class="text-xl font-bold cyberpunk-gradient mb-6">Subfolder</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                        @foreach ($folder->children as $child)
                            <div class="relative group">
                                <a href="{{ route('folders.show', $child) }}" 
                                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:border-[#FF5AF7] transition-all duration-300 aspect-square">
                                    <svg class="w-16 h-16 text-[#FF5AF7]/80 group-hover:text-[#FF5AF7] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm font-medium text-center text-gray-200 truncate" title="{{ $child->name }}">
                                        {{ $child->name }}
                                    </p>
                                </a>
                                <!-- Folder Actions -->
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="flex space-x-1">
                                        <a href="{{ route('folders.edit', $child) }}" class="text-gray-400 hover:text-white mr-2" title="Ganti Nama">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        </a>
                                        <button @click.prevent="$dispatch('show-confirm-dialog', {
                                            title: 'Pindahkan Folder ke Sampah?',
                                            message: 'Yakin ingin memindahkan folder \'{{ $child->name }}\' ke tempat sampah?',
                                            action: '{{ route('folders.destroy', $child) }}',
                                            method: 'DELETE',
                                            confirmButtonText: 'Ya, Pindahkan'
                                        })" class="text-red-400 hover:text-red-300" title="Pindahkan ke Sampah">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Files in Folder -->
            <div class="glass-card">
                <h2 class="text-xl font-bold cyberpunk-gradient mb-6">File</h2>
                @if($folder->files->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($folder->files as $file)
                            <div class="p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:border-[#00FFC6] transition-all duration-300 group">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#00FFC6]/10 to-[#FF5AF7]/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        {{-- Icon logic here based on file type --}}
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-200 truncate" title="{{ $file->original_name }}">{{ $file->original_name }}</h3>
                                        <p class="mt-1 text-xs text-gray-400">{{ $file->formatted_size }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('files.show', $file) }}" class="p-2 rounded-lg hover:bg-[#00FFC6]/10 text-[#00FFC6] transition-colors" title="Lihat">
                                            <x-lucide-eye class="w-4 h-4"/>
                                        </a>
                                        <a href="{{ route('files.download', $file) }}" class="p-2 rounded-lg hover:bg-[#FF5AF7]/10 text-[#FF5AF7] transition-colors" title="Unduh">
                                            <x-lucide-download class="w-4 h-4"/>
                                        </a>
                                        <button @click.prevent="$dispatch('show-confirm-dialog', {
                                            title: 'Pindahkan File ke Sampah?',
                                            message: 'Yakin ingin memindahkan file \'{{ addslashes($file->original_name) }}\' ke tempat sampah?',
                                            action: '{{ route('files.destroy', $file) }}'
                                        })" class="p-2 rounded-lg hover:bg-red-500/10 text-red-500 transition-colors" title="Hapus">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <p class="mt-4 text-sm font-semibold">Folder ini kosong</p>
                        <p class="mt-1 text-xs">Mulai dengan mengunggah file atau membuat subfolder baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    <x-upload-modal :folders="$allFolders" />
    <x-folder-create-modal :folders="$allFolders"/>
</x-app-layout> 