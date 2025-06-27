<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get stats using service
        $stats = $this->statisticsService->getUserStats($user);

        // Fetch recent files
        $recentFiles = File::where('user_id', $user->id)
                            ->latest()
                            ->take(6)
                            ->get();
        
        // Fetch root folders
        $folders = Folder::where('user_id', $user->id)
                         ->whereNull('parent_id')
                         ->latest()
                         ->get();

        $allFolders = Folder::where('user_id', $user->id)->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentFiles' => $recentFiles,
            'folders' => $folders,
            'allFolders' => $allFolders,
        ]);
    }

    /**
     * Search files and folders.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $user = Auth::user();
        
        // Handle empty query for both request types
        if (empty($query)) {
            return $request->expectsJson()
                ? response()->json(['files' => [], 'folders' => []])
                : redirect()->route('dashboard');
        }

        // Base queries
        $filesQuery = $user->files()->where('name', 'like', "%{$query}%")->latest();
        $foldersQuery = $user->folders()->where('name', 'like', "%{$query}%")->latest();

        // Handle AJAX request for live search dropdown
        if ($request->expectsJson()) {
            $files = $filesQuery->take(5)->get();
            $folders = $foldersQuery->take(5)->get();
            return response()->json(compact('files', 'folders'));
        }

        // Handle full page request
        $files = $filesQuery->paginate(15, ['*'], 'files_page')->withQueryString();
        $folders = $foldersQuery->paginate(15, ['*'], 'folders_page')->withQueryString();

        return view('dashboard.search', compact('files', 'folders', 'query'));
    }

    /**
     * Get dashboard statistics (for AJAX).
     */
    public function statistics()
    {
        $user = Auth::user();
        return response()->json($this->statisticsService->getUserStats($user));
    }
}
