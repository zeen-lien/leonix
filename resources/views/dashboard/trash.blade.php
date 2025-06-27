@php
    $trashedFiles = $trashedFiles ?? collect();
    $trashedFolders = $trashedFolders ?? collect();
    $isEmpty = $trashedFiles->isEmpty() && $trashedFolders->isEmpty();
@endphp
<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-white">Tempat Sampah</h1>
                @if(!$isEmpty)
                <button 
                    @click.prevent="$dispatch('show-confirm-dialog', {
                        title: 'Kosongkan Sampah?',
                        message: 'Yakin ingin mengosongkan tempat sampah? Semua item di dalamnya akan dihapus permanen dan tindakan ini tidak dapat diurungkan.',
                        action: '{{ route('trash.empty') }}',
                        method: 'POST',
                        confirmButtonText: 'Ya, Kosongkan!'
                    })"
                    class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-700 border border-red-500/50 text-white font-bold transition-all duration-300 transform hover:scale-105">
                    <x-lucide-trash-2 class="inline-block w-4 h-4 mr-2" />
                    Kosongkan Sampah
                </button>
                @endif
            </div>

            @if($isEmpty)
            <div class="text-center text-gray-500 py-16 glass-card">
                <svg class="mx-auto h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <p class="mt-4 text-lg font-semibold">Tempat Sampah Kosong</p>
                <p class="mt-1 text-sm">Semua berkas dan folder yang Anda hapus akan muncul di sini.</p>
            </div>
            @else
                <!-- Combined List -->
                <div class="glass-card">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-800/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipe</th>
                                    <th scope="col" class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Dihapus Pada</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800/40 divide-y divide-gray-700/50">
                                <!-- Trashed Folders -->
                                @foreach($trashedFolders as $folder)
                                <tr class="hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                        <div class="flex items-center">
                                            <x-lucide-folder-x class="w-5 h-5 mr-3 text-[#FF5AF7]" />
                                            <span class="truncate">{{ $folder->name }}</span>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-400">Folder</td>
                                    <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $folder->deleted_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-2">
                                            <button @click.prevent="$dispatch('show-confirm-dialog', {
                                                title: 'Pulihkan Folder?',
                                                message: 'Memulihkan folder ini juga akan memulihkan semua isinya. Lanjutkan?',
                                                action: '{{ route('folders.restore', $folder->id) }}',
                                                method: 'POST',
                                                confirmButtonText: 'Ya, Pulihkan'
                                            })" class="p-2 rounded-lg hover:bg-[#00FFC6]/10 text-[#00FFC6] transition-colors" title="Pulihkan Folder">
                                                <x-lucide-undo-2 class="w-4 h-4" />
                                            </button>
                                            <button @click.prevent="$dispatch('show-confirm-dialog', {
                                                title: 'Hapus Permanen?',
                                                message: 'Folder \'{{ $folder->name }}\' dan semua isinya akan dihapus permanen. Tindakan ini tidak dapat diurungkan.',
                                                action: '{{ route('folders.force-delete', $folder->id) }}',
                                                method: 'DELETE',
                                                confirmButtonText: 'Ya, Hapus Permanen'
                                            })" class="p-2 rounded-lg hover:bg-red-500/10 text-red-500 transition-colors" title="Hapus Permanen">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                <!-- Trashed Files -->
                                @foreach($trashedFiles as $file)
                                <tr class="hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $file->file_icon }}</span>
                                            <span class="truncate">{{ $file->original_name }}</span>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-400">File</td>
                                    <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $file->deleted_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-2">
                                            <button @click.prevent="$dispatch('show-confirm-dialog', {
                                                title: 'Pulihkan File?',
                                                message: 'Yakin ingin memulihkan file \'{{ $file->original_name }}\'?',
                                                action: '{{ route('files.restore', $file->id) }}',
                                                method: 'POST',
                                                confirmButtonText: 'Ya, Pulihkan'
                                            })" class="p-2 rounded-lg hover:bg-[#00FFC6]/10 text-[#00FFC6] transition-colors" title="Pulihkan File">
                                                <x-lucide-undo-2 class="w-4 h-4" />
                                            </button>
                                            <button @click.prevent="$dispatch('show-confirm-dialog', {
                                                title: 'Hapus Permanen?',
                                                message: 'File \'{{ $file->original_name }}\' akan dihapus permanen. Tindakan ini tidak dapat diurungkan.',
                                                action: '{{ route('files.force-delete', $file->id) }}',
                                                method: 'DELETE',
                                                confirmButtonText: 'Ya, Hapus Permanen'
                                            })" class="p-2 rounded-lg hover:bg-red-500/10 text-red-500 transition-colors" title="Hapus Permanen">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($trashedFolders->hasPages())
                    <div class="mt-6">
                        {{ $trashedFolders->links() }}
                    </div>
                    @endif
                     @if($trashedFiles->hasPages())
                    <div class="mt-6">
                        {{ $trashedFiles->links() }}
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 