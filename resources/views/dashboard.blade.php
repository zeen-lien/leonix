<x-app-layout>
    <style>
        body {
            background: #10101a;
        }
        .glass-card {
            background: rgba(24, 24, 40, 0.82);
            border: 1.5px solid #2dd4bf;
            border-radius: 1.2rem;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 12px 0 rgba(0,0,0,0.08);
            padding: 1.5rem 1.7rem;
            color: #fff;
            position: relative;
            transition: border-color 0.18s, box-shadow 0.18s, transform 0.18s;
        }
        .glass-card:hover {
            border-color: #a78bfa;
            box-shadow: 0 4px 24px 0 rgba(167,139,250,0.10);
            transform: translateY(-2px) scale(1.02);
        }
        .glass-title {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, #2dd4bf 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass-value {
            font-size: 2.1rem;
            font-weight: bold;
            letter-spacing: 0.04em;
            margin-bottom: 0.2rem;
            transition: color 0.2s;
        }
        .sidebar-min {
            background: rgba(24,24,40,0.92);
            border-right: 1.5px solid #23234a;
            min-width: 64px;
            width: 64px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 0 1rem 0;
            gap: 2rem;
        }
        .sidebar-min .icon {
            width: 32px; height: 32px;
            color: #2dd4bf;
            opacity: 0.8;
            transition: color 0.18s, opacity 0.18s;
        }
        .sidebar-min .icon.active, .sidebar-min .icon:hover {
            color: #a78bfa;
            opacity: 1;
        }
        .sidebar-min .logo {
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            color: #2dd4bf;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #2dd4bf 0%, #a78bfa 100%);
            color: #181828;
            font-weight: bold;
            border-radius: 0.8rem;
            padding: 0.9rem 2.2rem;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px 0 rgba(45,212,191,0.08);
            transition: background 0.18s, box-shadow 0.18s, transform 0.18s;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, #a78bfa 0%, #2dd4bf 100%);
            box-shadow: 0 4px 16px 0 rgba(167,139,250,0.10);
            transform: scale(1.04);
        }
        .recent-file-card {
            background: rgba(24,24,40,0.92);
            border: 1.5px solid #23234a;
            border-radius: 1rem;
            padding: 1.1rem 1.3rem;
            display: flex; align-items: center; gap: 1.1rem;
            transition: border-color 0.18s, box-shadow 0.18s, transform 0.18s;
        }
        .recent-file-card:hover {
            border-color: #2dd4bf;
            box-shadow: 0 2px 12px 0 rgba(45,212,191,0.08);
            transform: translateY(-2px) scale(1.01);
        }
        .recent-file-icon {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 0.6rem;
            background: #181828;
            border: 1.5px solid #23234a;
        }
        .recent-file-name {
            font-weight: 600;
            color: #fff;
            font-size: 1.1rem;
        }
        .recent-file-date {
            font-size: 0.92rem;
            color: #a78bfa;
        }
        .fade-in {
            animation: fadeIn 0.7s cubic-bezier(.77,0,.18,1);
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(16px) scale(0.98); }
            100% { opacity: 1; transform: none; }
        }
        .fab-toggle {
            position: fixed;
            right: 1.5rem;
            bottom: 1.5rem;
            z-index: 50;
            width: 56px; height: 56px;
            border-radius: 50%;
            background: linear-gradient(90deg, #00FFC6 0%, #FF5AF7 100%);
            color: #111;
            font-size: 2rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 16px #00FFC6, 0 0 32px #FF5AF7;
            border: none;
            outline: none;
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .fab-toggle:active {
            transform: scale(0.93);
            box-shadow: 0 0 32px #FF5AF7, 0 0 16px #00FFC6;
        }
        @media (min-width: 1024px) {
            .fab-toggle { display: none !important; }
        }
        .notif-login {
            position: fixed;
            top: 2.5rem; right: 2.5rem;
            z-index: 100;
            background: rgba(20,20,30,0.98);
            border: 2.5px solid transparent;
            border-image: linear-gradient(90deg, #00FFC6 0%, #FF5AF7 100%) 1;
            box-shadow: 0 0 24px #00FFC6, 0 0 48px #FF5AF7;
            border-radius: 1.2rem;
            padding: 1.3rem 2.2rem 1.1rem 1.7rem;
            color: #fff;
            display: flex; align-items: center; gap: 1.1rem;
            min-width: 260px;
            animation: notifIn 1s cubic-bezier(.77,0,.18,1);
        }
        @media (max-width: 600px) {
            .notif-login { right: 0.7rem; top: 1.1rem; min-width: 180px; padding: 1rem 1.2rem; }
        }
        @keyframes notifIn {
            0% { opacity: 0; transform: translateY(-32px) scale(0.98); filter: blur(12px); }
            100% { opacity: 1; transform: none; filter: blur(0); }
        }
        .notif-login .icon {
            font-size: 2.1rem;
            color: #00FFC6;
            filter: drop-shadow(0 0 8px #00FFC6);
        }
        .notif-login .close {
            margin-left: auto;
            color: #FF5AF7;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.15s;
        }
        .notif-login .close:hover { opacity: 1; }
    </style>
    <div 
        id="dashboard-wrapper" 
        x-data='{ stats: @json($stats), folders: @json($folders) }'
        @folder-created.window="if ($event.detail.folder.parent_id === null) folders.unshift($event.detail.folder)"
    >
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Header -->
                <div class="glass-card">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold cyberpunk-gradient">Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
                            <p class="mt-2 text-gray-400">Kelola semua file dan folder Anda di satu tempat.</p>
                        </div>
                        <div class="flex space-x-2">
                             <button 
                                @click="$dispatch('open-upload-modal', { folderId: null })"
                                class="px-4 py-2 text-sm rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all duration-300 transform hover:scale-105">
                                Unggah File
                            </button>
                            <button 
                                @click="$dispatch('open-folder-modal', { parentId: null })"
                                class="px-4 py-2 text-sm rounded-lg bg-gray-700/70 hover:bg-gray-600/70 border border-gray-600/90 text-white font-bold transition-all">
                                Folder Baru
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Search -->
                <div 
                    x-data="{ 
                        query: '', 
                        results: { files: [], folders: [] }, 
                        loading: false, 
                        open: false,
                        fetchResults() {
                            this.loading = true;
                            this.open = true;
                            fetch(`{{ route('search') }}?q=${this.query}`, {
                                headers: { 'Accept': 'application/json' }
                            })
                            .then(response => response.json())
                            .then(data => {
                                this.results = data;
                                this.loading = false;
                            });
                        }
                    }"
                    @click.away="open = false" 
                    class="relative"
                >
                    <div class="glass-card p-0 flex">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Cari berkas dan folder Anda di sini..." 
                            autocomplete="off"
                            x-model.debounce.300ms="query"
                            @input="if (query.length > 2) fetchResults(); else { open = false; }"
                            @focus="if (query.length > 2) open = true"
                            class="flex-1 bg-transparent border-none text-white placeholder-gray-400 focus:ring-0 block p-4"
                        >
                        <button 
                            type="submit" 
                            @click.prevent="fetchResults"
                            class="bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] text-gray-900 px-5 m-2 rounded-lg font-bold hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all duration-300"
                        >
                            <span x-show="!loading"><x-lucide-search class="w-5 h-5"/></span>
                            <div x-show="loading" class="w-5 h-5 border-2 border-dashed rounded-full animate-spin border-gray-900"></div>
                        </button>
                    </div>

                    <!-- Search Results Dropdown -->
                    <div 
                        x-show="open && query.length > 2"
                        x-transition
                        class="absolute mt-2 w-full bg-gray-900/90 backdrop-blur-md border border-gray-700 rounded-lg shadow-xl z-10 overflow-hidden"
                        style="display: none;"
                    >
                        <div class="p-4 max-h-96 overflow-y-auto">
                            <template x-if="loading">
                                <p class="text-center text-gray-400 py-4">Mencari...</p>
                            </template>
                            <template x-if="!loading && results.files.length === 0 && results.folders.length === 0">
                                <p class="text-center text-gray-400 py-4">Tidak ada hasil ditemukan untuk "<span x-text="query"></span>"</p>
                            </template>

                            <template x-if="!loading && (results.files.length > 0 || results.folders.length > 0)">
                                <div>
                                    <template x-if="results.folders.length > 0">
                                        <div>
                                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Folder</h3>
                                            <ul>
                                                <template x-for="folder in results.folders" :key="`folder-${folder.id}`">
                                                    <li>
                                                        <a :href="`/folders/${folder.id}`" class="flex items-center gap-3 px-3 py-2.5 rounded-md hover:bg-gray-700/50 transition-colors">
                                                            <x-lucide-folder class="w-5 h-5 text-amber-400"/>
                                                            <span class="text-white font-medium" x-text="folder.name"></span>
                                                        </a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                    <template x-if="results.files.length > 0 && results.folders.length > 0">
                                        <hr class="border-gray-700 my-3">
                                    </template>
                                    <template x-if="results.files.length > 0">
                                        <div>
                                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Berkas</h3>
                                            <ul>
                                                <template x-for="file in results.files" :key="`file-${file.id}`">
                                                    <li>
                                                        <a :href="`/files/${file.id}/preview`" class="flex items-center gap-3 px-3 py-2.5 rounded-md hover:bg-gray-700/50 transition-colors">
                                                            <x-lucide-file class="w-5 h-5 text-cyan-400"/>
                                                            <span class="text-white font-medium" x-text="file.name"></span>
                                                        </a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <div class="bg-gray-800/50 px-4 py-2 text-center text-sm">
                            <a :href="`/search?q=${query}`" class="font-semibold text-[#00FFC6] hover:text-[#FF5AF7] transition-colors">
                                Lihat semua hasil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="glass-card p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="glass-title">Total Berkas</div>
                                <div class="glass-value" x-text="stats.totalFiles">0</div>
                            </div>
                            <div class="p-3 rounded-full bg-cyan-500/10 text-cyan-400"><x-lucide-files class="w-6 h-6" /></div>
                        </div>
                    </div>
                    <div class="glass-card p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="glass-title">Penyimpanan</div>
                                <div class="glass-value" x-text="stats.storageUsed">0 B</div>
                            </div>
                            <div class="p-3 rounded-full bg-amber-500/10 text-amber-400"><x-lucide-database class="w-6 h-6" /></div>
                        </div>
                    </div>
                    <div class="glass-card p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="glass-title">Di Tempat Sampah</div>
                                <div class="glass-value" x-text="stats.trashFiles">0</div>
                            </div>
                            <div class="p-3 rounded-full bg-red-500/10 text-red-400"><x-lucide-trash-2 class="w-6 h-6" /></div>
                        </div>
                    </div>
                     <div class="glass-card p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0 flex-1">
                                <div class="glass-title">Berkas Terakhir</div>
                                <p class="glass-value text-xl truncate" x-text="stats.latestFile" :title="stats.latestFile"></p>
                            </div>
                            <div class="p-3 rounded-full bg-fuchsia-500/10 text-fuchsia-400"><x-lucide-file-clock class="w-6 h-6" /></div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Files & Folders -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    <!-- Recent Files -->
                    <div class="lg:col-span-3 glass-card">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold cyberpunk-gradient">Berkas Terbaru</h2>
                            <a href="{{ route('files.index') }}" class="text-sm text-[#00FFC6] hover:text-[#FF5AF7] transition-colors">Lihat semua</a>
                        </div>
                        <div class="space-y-3">
                             @forelse($recentFiles as $file)
                                <div class="p-3 rounded-lg bg-gray-800/50 hover:bg-gray-700/50 transition-colors flex items-center gap-4">
                                    <span class="text-2xl">{{ $file->file_icon }}</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-white truncate" title="{{ $file->name }}">{{ $file->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $file->formatted_size }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('files.download', $file) }}" class="text-gray-400 hover:text-white" title="Unduh"><x-lucide-download class="w-4 h-4"/></a>
                                        <a href="{{ route('files.show', $file) }}" class="text-gray-400 hover:text-white" title="Lihat"><x-lucide-eye class="w-4 h-4"/></a>
                                        <button @click.prevent="$dispatch('show-confirm-dialog', {
                                            title: 'Pindahkan File ke Sampah?',
                                            message: 'Yakin ingin memindahkan file \'{{ addslashes($file->name) }}\' ke tempat sampah?',
                                            action: '{{ route('files.destroy', $file) }}'
                                        })" class="text-red-400 hover:text-red-300" title="Hapus">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-8">
                                    <x-lucide-file-x class="mx-auto h-12 w-12 text-gray-600" />
                                    <p class="mt-4 text-sm font-semibold">Belum Ada Berkas</p>
                                    <p class="mt-1 text-xs">Unggah berkas pertama Anda untuk melihatnya di sini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Folders -->
                    <div class="lg:col-span-2 glass-card">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold cyberpunk-gradient">Folder</h2>
                                <a href="{{ route('files.index') }}" class="text-sm text-[#00FFC6] hover:text-[#FF5AF7] transition-colors">Lihat semua</a>
                        </div>
                        
                        <!-- Alpine-controlled grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" x-show="folders.length > 0" style="display: none;">
                            <template x-for="folder in folders" :key="folder.id">
                                <a :href="`/folders/${folder.id}`" 
                                class="relative group flex flex-col items-center justify-center p-4 rounded-lg bg-gray-800/50 border border-gray-700/50 hover:border-[#FF5AF7] transition-all duration-300 aspect-square">
                                    <svg class="w-12 h-12 text-[#FF5AF7]/80 group-hover:text-[#FF5AF7] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm font-medium text-center text-gray-200 truncate w-full" x-text="folder.name" :title="folder.name"></p>
                                </a>
                            </template>
                        </div>

                        <!-- Alpine-controlled empty state -->
                        <div x-show="folders.length === 0" class="text-center text-gray-500 py-8" style="display: none;">
                            <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <p class="mt-4 text-sm font-semibold">Belum Ada Folder</p>
                            <p class="mt-1 text-xs">Buat folder pertama Anda untuk mengatur berkas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <x-folder-create-modal :folders="$allFolders" />
    <x-upload-modal :folders="$allFolders" />
</x-app-layout>
