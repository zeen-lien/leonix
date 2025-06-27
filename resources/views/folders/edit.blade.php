<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6 sm:p-8">
                <!-- Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold cyberpunk-gradient">Ubah Folder</h1>
                        <p class="mt-2 text-gray-400">Perbarui informasi dan lokasi folder.</p>
                    </div>
                    <a href="{{ url()->previous() }}" 
                       class="px-4 py-2 rounded-lg bg-gray-700/70 hover:bg-gray-600/70 border border-gray-600/90 text-white font-bold transition-all">
                        Kembali
                    </a>
                </div>

                <!-- Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Dasbor
                            </a>
                        </li>
                        @foreach($folder->ancestors as $ancestor)
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

                <!-- Edit Form -->
                <form method="POST" action="{{ route('folders.update', $folder) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Folder Name -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-cyan-400">Nama Folder</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $folder->name) }}" 
                               required
                               class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Folder -->
                    <div>
                        <label for="parent_id" class="block mb-2 text-sm font-medium text-cyan-400">Folder Induk</label>
                        <select name="parent_id" 
                                id="parent_id"
                                class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">
                            <option value="">Direktori Utama (Root)</option>
                            @foreach($folders as $parentFolder)
                                <option value="{{ $parentFolder->id }}" 
                                        @if(old('parent_id', $folder->parent_id) == $parentFolder->id) selected @endif>
                                    {{ str_repeat('— ', $parentFolder->ancestors->count()) }}{{ $parentFolder->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit" 
                                class="px-6 py-2 rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all duration-300 transform hover:scale-105">
                            Perbarui Folder
                        </button>
                    </div>
                </form>

                <!-- Danger Zone -->
                <div class="mt-12 p-6 border border-red-500/20 rounded-lg bg-red-500/5">
                    <h3 class="text-lg font-medium text-red-400 mb-4">Zona Berbahaya</h3>
                    <p class="text-gray-400 mb-4">
                        Memindahkan folder ini ke tempat sampah akan memindahkan semua isinya juga. Tindakan ini dapat dibatalkan dari halaman tempat sampah.
                    </p>
                    <button 
                        @click.prevent="$dispatch('show-confirm-dialog', {
                            title: 'Pindahkan ke Sampah?',
                            message: 'Yakin ingin memindahkan folder ini beserta isinya ke tempat sampah?',
                            action: '{{ route('folders.destroy', $folder) }}',
                            method: 'DELETE',
                            confirmButtonText: 'Ya, Pindahkan'
                        })"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition-all duration-300">
                        Pindahkan Folder ke Sampah
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 