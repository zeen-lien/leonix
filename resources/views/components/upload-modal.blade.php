@props(['folders' => [], 'cspNonce' => ''])

<div 
    x-data="uploadModalData()"
    x-init="init()"
    x-show="show"
    @close-upload-modal.window="show = false"
    @keydown.escape.window="show = false"
    class="fixed inset-0 z-50 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
    style="display: none;"
>
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" 
             @click="show = false" 
             aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl">
            
            <form @submit.prevent="submitForm()" id="upload-form">
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                        Unggah File Baru
                    </h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="folder_id_upload" class="block text-sm font-medium text-gray-300">Pilih Folder (Opsional)</label>
                            <select x-model="folderId" name="folder_id" id="folder_id_upload" class="mt-1 block w-full pl-3 pr-10 py-2 text-base text-white bg-gray-700 border-gray-600 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-md">
                                <option value="">Unggah ke Direktori Utama</option>
                                @foreach($folders as $folder)
                                    <option value="{{ $folder->id }}">
                                        {{ str_repeat('— ', optional($folder->ancestors)->count() ?? 0) }}{{ $folder->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- File Dropzone -->
                        <div 
                            x-on:dragover.prevent="dragging = true"
                            x-on:dragleave.prevent="dragging = false"
                            x-on:drop.prevent="handleFileDrop($event)"
                            @click="$refs.fileInput.click()"
                            class="relative w-full min-h-[12rem] border-2 border-dashed rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-300 p-4"
                            :class="{'border-[#FF5AF7] bg-[#FF5AF7]/10': dragging, 'border-gray-600 hover:border-[#00FFC6]': !dragging}"
                        >
                            <input type="file" multiple class="hidden" x-ref="fileInput" @change="handleFileSelect($event)">
                            
                            <template x-if="files.length === 0">
                                <div class="text-center">
                                    <x-lucide-upload-cloud class="mx-auto h-12 w-12 text-gray-500"/>
                                    <p class="mt-2 text-sm text-gray-400">Drag & drop atau <span class="font-semibold text-[#00FFC6]">jelajahi file</span></p>
                                    <p class="text-xs text-gray-500 mt-1">Maksimum 100MB per file</p>
                                </div>
                            </template>

                            <template x-if="files.length > 0">
                                <div class="w-full space-y-3">
                                    <template x-for="(file, index) in files" :key="index">
                                        <div class="p-3 rounded-lg bg-gray-900/50 flex items-center gap-4 text-left">
                                            <x-lucide-file class="w-6 h-6 text-cyan-400 flex-shrink-0"/>
                                            <div class="flex-1 min-w-0">
                                                <input type="text" 
                                                       :name="'names[' + index + ']'" 
                                                       x-model="file.displayName"
                                                       @click.stop
                                                       class="w-full bg-gray-700/50 border-gray-600 text-white text-sm rounded-md focus:ring-[#00FFC6] focus:border-[#00FFC6] block p-2"
                                                       placeholder="Nama tampilan file...">
                                                <p class="text-xs text-gray-400 mt-1" x-text="`${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`"></p>
                                            </div>
                                            <button @click.prevent="removeFile(index)" class="text-red-400 hover:text-red-300">
                                                <x-lucide-x class="w-5 h-5"/>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div x-show="progress > 0 && progress < 100" class="w-full bg-gray-700 rounded-full h-2.5 mt-4">
                            <div class="bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] h-2.5 rounded-full" :style="`width: ${progress}%`"></div>
                        </div>

                        <!-- Error/Success Messages -->
                        <div x-show="error" class="text-red-400 text-sm" x-text="error"></div>
                        <div x-show="success" class="text-green-400 text-sm" x-text="success"></div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-900/50 text-right">
                    <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600 mr-2">Batal</button>
                    <button type="submit" :disabled="files.length === 0 || progress > 0" class="px-4 py-2 text-sm font-medium text-gray-900 bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] rounded-lg disabled:opacity-50">
                        <span x-show="progress === 0">Unggah</span>
                        <span x-show="progress > 0">Mengunggah...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script nonce="{{ $cspNonce }}">
function uploadModalData() {
    return {
        show: false,
        files: [],
        folderId: null,
        error: '',
        success: '',
        progress: 0,
        dragging: false,
        
        init() {
            window.addEventListener('open-upload-modal', (event) => this.openModal(event));
        },

        openModal(event) {
            this.show = true;
            this.folderId = event.detail ? (event.detail.folderId || null) : null;
            this.files = [];
            this.error = '';
            this.success = '';
            this.progress = 0;
        },

        handleFileSelect(event) {
            this.addFiles(event.target.files);
        },

        handleFileDrop(event) {
            this.dragging = false;
            this.addFiles(event.dataTransfer.files);
        },

        addFiles(fileList) {
            Array.from(fileList).forEach(file => {
                this.files.push({
                    file: file,
                    name: file.name,
                    size: file.size,
                    displayName: file.name.split('.').slice(0, -1).join('.') || file.name
                });
            });
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        submitForm() {
            this.error = '';
            this.success = '';
            this.progress = 1;

            const formData = new FormData();
            formData.append('folder_id', this.folderId || '');
            
            this.files.forEach((file, index) => {
                formData.append(`file[${index}]`, file.file);
                formData.append(`names[${index}]`, file.displayName);
            });

            axios.post('{{ route('files.store') }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                onUploadProgress: (progressEvent) => {
                    this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                }
            }).then(response => {
                this.success = response.data.message || 'File berhasil diunggah!';
                this.progress = 100;
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }).catch(error => {
                this.progress = 0;
                if (error.response && error.response.status === 422) {
                    this.error = Object.values(error.response.data.errors).flat().join(' ');
                } else {
                    this.error = error.response?.data?.message || 'Terjadi kesalahan saat mengunggah.';
                }
            });
        }
    }
}
</script>