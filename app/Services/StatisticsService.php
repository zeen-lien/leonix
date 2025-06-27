<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use App\Traits\FileSizeFormatter;

class StatisticsService
{
    use FileSizeFormatter;

    /**
     * Get user dashboard statistics.
     */
    public function getUserStats($user)
    {
        $totalFiles = File::where('user_id', $user->id)->count();
        $storageUsed = File::where('user_id', $user->id)->sum('size');
        $trashFiles = File::where('user_id', $user->id)->onlyTrashed()->count();
        $latestFile = File::where('user_id', $user->id)->latest()->first();

        return [
            'totalFiles' => $totalFiles,
            'storageUsed' => $this->formatFileSize($storageUsed),
            'trashFiles' => $trashFiles,
            'latestFile' => $latestFile ? $latestFile->original_name : 'No files yet'
        ];
    }

    /**
     * Get admin dashboard statistics.
     */
    public function getAdminStats()
    {
        $totalUsers = User::count();
        $totalFiles = File::count();
        $totalSize = $this->formatFileSize(File::sum('size'));
        $recentUsers = User::latest()->take(5)->get();
        $recentFiles = File::with('user')->latest()->take(10)->get();
        
        // File type statistics
        $fileTypes = File::selectRaw('extension, COUNT(*) as count')
            ->groupBy('extension')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        // User registration statistics (last 30 days)
        $userStats = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // File upload statistics (last 30 days)
        $fileStats = File::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'totalUsers' => $totalUsers,
            'totalFiles' => $totalFiles,
            'totalSize' => $totalSize,
            'recentUsers' => $recentUsers,
            'recentFiles' => $recentFiles,
            'fileTypes' => $fileTypes,
            'userStats' => $userStats,
            'fileStats' => $fileStats
        ];
    }

    /**
     * Get file statistics for user.
     */
    public function getFileStats($user)
    {
        return [
            'total_files' => $user->files()->count(),
            'total_size' => $user->formatted_storage_used,
            'file_types' => $user->files()
                ->selectRaw('extension, COUNT(*) as count')
                ->groupBy('extension')
                ->orderBy('count', 'desc')
                ->get(),
            'recent_uploads' => $user->files()
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->count(),
        ];
    }

    /**
     * Get disk usage information.
     */
    public function getDiskUsage()
    {
        $totalSpace = disk_total_space(storage_path('app/public'));
        $freeSpace = disk_free_space(storage_path('app/public'));
        $usedSpace = $totalSpace - $freeSpace;
        $usagePercentage = round(($usedSpace / $totalSpace) * 100, 2);

        return [
            'total' => $this->formatFileSize($totalSpace),
            'used' => $this->formatFileSize($usedSpace),
            'free' => $this->formatFileSize($freeSpace),
            'percentage' => $usagePercentage
        ];
    }

    /**
     * Get system statistics.
     */
    public function getSystemStats()
    {
        return [
            'total_users' => User::count(),
            'total_files' => File::count(),
            'total_size' => $this->formatFileSize(File::sum('size')),
            'disk_usage' => $this->getDiskUsage(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'file_types' => File::selectRaw('extension, COUNT(*) as count')
                ->groupBy('extension')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get(),
            'recent_uploads' => File::whereDate('created_at', '>=', now()->subDays(7))->count(),
            'recent_users' => User::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
} 