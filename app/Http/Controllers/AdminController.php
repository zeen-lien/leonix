<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->statisticsService = $statisticsService;
    }

    /**
     * Show admin dashboard.
     */
    public function index()
    {
        $stats = $this->statisticsService->getAdminStats();
        
        return view('admin.dashboard', $stats);
    }

    /**
     * Show all users.
     */
    public function users()
    {
        $users = User::with('files')
            ->withCount('files')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details.
     */
    public function showUser(User $user)
    {
        $user->load('files');
        $files = $user->files()->latest()->paginate(20);
        
        return view('admin.users.show', compact('user', 'files'));
    }

    /**
     * Edit user.
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        // Don't allow admin to delete themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account!');
        }

        // Delete user's files
        foreach ($user->files as $file) {
            if (file_exists(storage_path('app/public/' . $file->path))) {
                unlink(storage_path('app/public/' . $file->path));
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Show all files.
     */
    public function files()
    {
        $files = File::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.files.index', compact('files'));
    }

    /**
     * Show file details.
     */
    public function showFile(File $file)
    {
        $file->load('user');
        return view('admin.files.show', compact('file'));
    }

    /**
     * Delete file.
     */
    public function deleteFile(File $file)
    {
        // Delete physical file
        if (file_exists(storage_path('app/public/' . $file->path))) {
            unlink(storage_path('app/public/' . $file->path));
        }

        $file->forceDelete();

        return redirect()->route('admin.files.index')
            ->with('success', 'File deleted successfully!');
    }

    /**
     * Show system settings.
     */
    public function settings()
    {
        $stats = [
            'total_users' => User::count(),
            'total_files' => File::count(),
            'total_size' => $this->statisticsService->formatFileSize(File::sum('size')),
            'disk_usage' => $this->statisticsService->getDiskUsage(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];

        return view('admin.settings', compact('stats'));
    }

    /**
     * Get system statistics (for AJAX).
     */
    public function statistics()
    {
        return response()->json($this->statisticsService->getSystemStats());
    }

    /**
     * Search users.
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('admin.users.index');
        }

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->withCount('files')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users', 'query'));
    }

    /**
     * Search files.
     */
    public function searchFiles(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('admin.files.index');
        }

        $files = File::where('name', 'like', "%{$query}%")
            ->orWhere('original_name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.files.index', compact('files', 'query'));
    }

    /**
     * Bulk delete users.
     */
    public function bulkDeleteUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $deletedCount = 0;

        foreach ($users as $user) {
            // Don't delete admin's own account
            if ($user->id === Auth::id()) {
                continue;
            }

            // Delete user's files
            foreach ($user->files as $file) {
                if (file_exists(storage_path('app/public/' . $file->path))) {
                    unlink(storage_path('app/public/' . $file->path));
                }
            }

            $user->delete();
            $deletedCount++;
        }

        return redirect()->route('admin.users.index')
            ->with('success', "{$deletedCount} users deleted successfully!");
    }

    /**
     * Bulk delete files.
     */
    public function bulkDeleteFiles(Request $request)
    {
        $request->validate([
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:files,id',
        ]);

        $files = File::whereIn('id', $request->file_ids)->get();
        
        foreach ($files as $file) {
            if (file_exists(storage_path('app/public/' . $file->path))) {
                unlink(storage_path('app/public/' . $file->path));
            }
            $file->forceDelete();
        }

        return redirect()->route('admin.files.index')
            ->with('success', count($files) . ' files deleted successfully!');
    }
}
