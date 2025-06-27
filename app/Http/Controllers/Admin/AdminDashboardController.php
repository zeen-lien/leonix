<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\FileSizeFormatter;

class AdminDashboardController extends Controller
{
    use FileSizeFormatter;

    public function index(Request $request)
    {
        // Filter range untuk grafik pendaftaran user
        $range = $request->input('user_chart_range', '7');
        $days = 7;
        if ($range === '30') $days = 30;
        if ($range === '180') $days = 180;
        if ($range === '365') $days = 365;

        // 1. Stat Cards
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalFiles = File::count();
        $totalFolders = Folder::count();
        $totalStorage = $this->formatFileSize(File::sum('size'));

        // File terbanyak diakses (jika ada kolom views)
        $mostViewedFile = File::orderByDesc('views')->first();
        $trashFiles = File::onlyTrashed()->count();

        // 2. Recent Files
        $recentFiles = File::with('user')->latest()->take(5)->get();

        // 3. User Registration Chart Data (by filter)
        $userRegistrationData = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subDays($days))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        $chartLabels = $userRegistrationData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartData = $userRegistrationData->pluck('count');

        // Grafik upload file per 7 hari terakhir
        $fileUploadData = File::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        $fileChartLabels = $fileUploadData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $fileChartData = $fileUploadData->pluck('count');

        // Storage tersisa (misal limit 1TB = 1_000_000_000_000 bytes)
        $storageLimit = 1000000000000; // 1 TB
        $storageUsed = File::sum('size');
        $storageRemaining = $this->formatFileSize($storageLimit - $storageUsed);
        $storageLimitFormatted = $this->formatFileSize($storageLimit);

        // Aktivitas hari ini (jumlah upload file hari ini)
        $todayUploads = File::whereDate('created_at', Carbon::today())->count();
        // (Jika ingin download juga, perlu tracking event download di tabel lain)

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalFiles',
            'totalFolders',
            'totalStorage',
            'recentFiles',
            'chartLabels',
            'chartData',
            'mostViewedFile',
            'trashFiles',
            'fileChartLabels',
            'fileChartData',
            'range',
            'storageRemaining',
            'todayUploads',
            'storageLimit',
            'storageLimitFormatted'
        ));
    }
}
