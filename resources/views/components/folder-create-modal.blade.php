@props(['folders' => []])

<div x-data="folderCreateModal()" x-show="show" @open-folder-modal.window="open($event.detail)"
     @keydown.escape.window="close()"
     class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div @click="close()" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div x-show="show" x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-gray-800 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            
            <h3 class="text-lg font-medium leading-6 text-white" id="modal-title">
                Buat Folder Baru
            </h3>
            <form data-action="{{ route('folders.store') }}" @submit.prevent="submit($el)" class="mt-4">
                @csrf

                <div class="mt-6 space-y-4">
                    <div>
                        <label for="folder_name" class="block text-sm font-medium text-gray-300">Nama Folder</label>
                        <input type="text" x-model="name" x-ref="folderNameInput" name="name" id="folder_name"
                            class="block w-full mt-1 text-white bg-gray-700 border-gray-600 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                            placeholder="misal: Dokumen Pribadi">
                        <template x-if="errors.name">
                            <p class="mt-2 text-sm text-red-500" x-text="errors.name[0]"></p>
                        </template>
                    </div>
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-300">Lokasi (Folder Induk)</label>
                        <select name="parent_id" id="parent_id" x-model="parentId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base text-white bg-gray-700 border-gray-600 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-md">
                            <option value="">Direktori Utama (Root)</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">
                                    {{ str_repeat('— ', $folder->ancestors->count()) }}{{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="close()"
                            class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] rounded-lg hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all">
                        Buat Folder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 