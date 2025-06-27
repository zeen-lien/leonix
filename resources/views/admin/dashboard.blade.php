<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="mb-8 p-6 bg-transparent rounded-lg border border-indigo-500/50">
                <h1 class="text-3xl font-bold admin-title-gradient">
                    Admin Mission Control
                </h1>
                <p class="text-gray-400 mt-1">Selamat datang kembali, {{ Auth::user()->name }}. Berikut adalah ringkasan sistem Anda.</p>
            </div>

            <!-- Stat Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-transparent p-6 rounded-lg border border-blue-500/50 flex items-center space-x-4">
                    <div class="bg-blue-500/10 p-3 rounded-full">
                        <x-lucide-users class="w-6 h-6 text-blue-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Total Pengguna</p>
                        <p class="text-2xl font-bold text-white">{{ $totalUsers }}</p>
                    </div>
                </div>
                <!-- Active Users -->
                <div class="bg-transparent p-6 rounded-lg border border-purple-500/50 flex items-center space-x-4">
                    <div class="bg-purple-500/10 p-3 rounded-full">
                        <x-lucide-user-check class="w-6 h-6 text-purple-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Pengguna Aktif</p>
                        <p class="text-2xl font-bold text-white">{{ $activeUsers }}</p>
                    </div>
                </div>
                <!-- Total Files -->
                <div class="bg-transparent p-6 rounded-lg border border-pink-500/50 flex items-center space-x-4">
                    <div class="bg-pink-500/10 p-3 rounded-full">
                         <x-lucide-file-text class="w-6 h-6 text-pink-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Total Berkas</p>
                        <p class="text-2xl font-bold text-white">{{ $totalFiles }}</p>
                    </div>
                </div>
                <!-- Total Storage -->
                <div class="bg-transparent p-6 rounded-lg border border-teal-500/50 flex items-center space-x-4">
                     <div class="bg-teal-500/10 p-3 rounded-full">
                        <x-lucide-database class="w-6 h-6 text-teal-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Total Penyimpanan</p>
                        <p class="text-2xl font-bold text-white">{{ $totalStorage }}</p>
                    </div>
                </div>
            </div>
            <!-- Stat Cards Grid Bawah -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Storage Tersisa -->
                <div class="bg-transparent p-6 rounded-lg border border-green-500/50 flex items-center space-x-4">
                    <div class="bg-green-500/10 p-3 rounded-full">
                        <x-lucide-battery-charging class="w-6 h-6 text-green-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Storage Tersisa</p>
                        <p class="text-2xl font-bold text-white">{{ $storageRemaining }} <span class="text-xs text-gray-400">/ {{ $storageLimitFormatted }}</span></p>
                    </div>
                </div>
                <!-- Jumlah Folder -->
                <div class="bg-transparent p-6 rounded-lg border border-cyan-500/50 flex items-center space-x-4">
                    <div class="bg-cyan-500/10 p-3 rounded-full">
                        <x-lucide-folder-tree class="w-6 h-6 text-cyan-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Jumlah Folder</p>
                        <p class="text-2xl font-bold text-white">{{ $totalFolders }}</p>
                    </div>
                </div>
                <!-- Aktivitas Hari Ini -->
                <div class="bg-transparent p-6 rounded-lg border border-yellow-500/50 flex items-center space-x-4">
                    <div class="bg-yellow-500/10 p-3 rounded-full">
                        <x-lucide-flame class="w-6 h-6 text-yellow-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Aktivitas Hari Ini</p>
                        <p class="text-2xl font-bold text-white">{{ $todayUploads }} <span class="text-xs text-gray-400">file diupload</span></p>
                    </div>
                </div>
                <!-- File di Trash -->
                <div class="bg-transparent p-6 rounded-lg border border-red-500/50 flex items-center space-x-4">
                    <div class="bg-red-500/10 p-3 rounded-full">
                        <x-lucide-trash-2 class="w-6 h-6 text-red-400"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">File di Trash</p>
                        <p class="text-2xl font-bold text-white">{{ $trashFiles }}</p>
                    </div>
                </div>
            </div>

            <!-- Grafik dan Aktivitas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Grafik Upload File -->
                <div class="bg-transparent p-6 rounded-lg border border-cyan-500/50">
                    <h3 class="text-lg font-semibold text-white mb-4">Upload File (7 Hari Terakhir)</h3>
                    <div class="relative h-80">
                        <div id="fileUploadApexChart" style="height: 320px;"></div>
                    </div>
                </div>
                <!-- Grafik Pendaftaran User + Filter -->
                <div class="bg-transparent p-6 rounded-lg border border-indigo-500/50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white">Pendaftaran Pengguna</h3>
                        <form method="GET" action="" class="flex items-center space-x-2">
                            <label for="user_chart_range" class="text-sm text-gray-400">Rentang:</label>
                            <select name="user_chart_range" id="user_chart_range" class="bg-gray-800 border border-gray-600 text-white rounded px-2 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                                <option value="7" @if($range == '7') selected @endif>7 Hari</option>
                                <option value="30" @if($range == '30') selected @endif>30 Hari</option>
                                <option value="180" @if($range == '180') selected @endif>6 Bulan</option>
                                <option value="365" @if($range == '365') selected @endif>1 Tahun</option>
                            </select>
                        </form>
                    </div>
                    <div class="relative h-80">
                        <div id="userRegistrationApexChart" style="height: 320px;"></div>
                    </div>
                </div>
            </div>
            <!-- Aktivitas Berkas Terbaru -->
            <div class="bg-transparent p-6 rounded-lg border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Aktivitas Berkas Terbaru</h3>
                <ul class="space-y-4">
                    @forelse($recentFiles as $file)
                        <li class="flex items-center space-x-3">
                            <div class="p-2 bg-gray-700 rounded-full">
                                <x-lucide-file-up class="w-5 h-5 text-gray-300"/>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-white truncate">{{ $file->name }}</p>
                                <p class="text-xs text-gray-400">
                                    diunggah oleh <span class="font-semibold">{{ $file->user->name ?? 'N/A' }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                 <p class="text-sm font-medium text-gray-300">{{ $file->formatted_size }}</p>
                                 <p class="text-xs text-gray-500">{{ $file->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-gray-500 py-4">
                            Belum ada aktivitas berkas.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ApexCharts untuk upload file
            var optionsUpload = {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false },
                    foreColor: '#e5e7eb',
                    fontFamily: 'inherit',
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3, colors: ['#FF9100'] },
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorStops: [
                            { offset: 0, color: '#FFD200', opacity: 0.8 },
                            { offset: 50, color: '#FF9100', opacity: 0.5 },
                            { offset: 100, color: '#FF5AF7', opacity: 0.2 }
                        ]
                    }
                },
                series: [{
                    name: 'File Diupload',
                    data: @json($fileChartData)
                }],
                xaxis: {
                    categories: @json($fileChartLabels),
                    labels: { style: { colors: '#a1a1aa' } }
                },
                yaxis: {
                    labels: { style: { colors: '#a1a1aa' } }
                },
                markers: {
                    size: 5,
                    colors: ['#FFD200'],
                    strokeColors: '#FF9100',
                    strokeWidth: 3,
                    hover: { size: 7 }
                },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: val => `${val} File` }
                },
                grid: { borderColor: 'rgba(255,255,255,0.05)' }
            };
            var chartUpload = new ApexCharts(document.querySelector("#fileUploadApexChart"), optionsUpload);
            chartUpload.render();

            // ApexCharts untuk pendaftaran user
            var optionsUser = {
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: { show: false },
                    foreColor: '#e5e7eb',
                    fontFamily: 'inherit',
                },
                dataLabels: { enabled: false },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '50%',
                    }
                },
                colors: ['#FF9100'],
                stroke: { show: true, width: 3, colors: ['#FFD200'] },
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorStops: [
                            { offset: 0, color: '#FFD200', opacity: 0.8 },
                            { offset: 100, color: '#FF9100', opacity: 0.2 }
                        ]
                    }
                },
                series: [{
                    name: 'Pengguna Baru',
                    data: @json($chartData)
                }],
                xaxis: {
                    categories: @json($chartLabels),
                    labels: { style: { colors: '#a1a1aa' } }
                },
                yaxis: {
                    labels: { style: { colors: '#a1a1aa' } }
                },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: val => `${val} User` }
                },
                grid: { borderColor: 'rgba(255,255,255,0.05)' }
            };
            var chartUser = new ApexCharts(document.querySelector("#userRegistrationApexChart"), optionsUser);
            chartUser.render();
        });
    </script>
    @endpush
</x-admin-layout> 