<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class FileController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $folders = Folder::where('user_id', $user->id)
                         ->whereNull('parent_id')
                         ->latest()
                         ->get();
                         
        $files = File::where('user_id', $user->id)
                     ->whereNull('folder_id')
                     ->latest()
                     ->paginate(20);

        $allFolders = Folder::where('user_id', $user->id)->get();
        
        return view('files.index', compact('files', 'folders', 'allFolders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|array',
            'file.*' => 'required|file|max:102400', // 100MB max
            'folder_id' => 'nullable|exists:folders,id,user_id,' . Auth::id(),
            'names' => 'required|array',
            'names.*' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $folderId = $request->folder_id;
        
        $createdFiles = [];
        foreach ($validated['file'] as $key => $uploadedFile) {
            
            // Get the display name from the request, fallback to original name
            $displayName = $validated['names'][$key] ?? pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            // Create the file record first
            $file = File::create([
                'user_id' => $user->id,
                'folder_id' => $folderId,
                'name' => $displayName, // Use the new display name
                'original_name' => $uploadedFile->getClientOriginalName(),
                'mime_type' => $uploadedFile->getMimeType(),
                'size' => $uploadedFile->getSize(),
                'extension' => $uploadedFile->getClientOriginalExtension(),
                'is_public' => false,
                'path' => '', // Will be updated by media library
            ]);

            // Add the file to the media library
            $media = $file->addMedia($uploadedFile)
                          ->toMediaCollection('files');
            
            // Update the file model with the path from the media library
            $file->update([
                'path' => $media->getPath(),
            ]);

            $createdFiles[] = $file->fresh()->toArray();
        }

        return response()->json([
            'success' => true,
            'message' => count($createdFiles) . ' file(s) uploaded successfully!',
            'files' => $createdFiles
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        // Check if user owns the file or if it's public
        if ($file->user_id !== Auth::id() && !$file->is_public) {
            abort(403);
        }

        return view('files.show', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        $this->authorize('update', $file);

        $folders = Auth::user()->folders()->get();

        return view('files.edit', compact('file', 'folders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        $this->authorize('update', $file);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'folder_id' => 'nullable|exists:folders,id,user_id,' . Auth::id(),
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);

        $file->update([
            'name' => $validated['name'],
            'folder_id' => $validated['folder_id'],
            'description' => $validated['description'],
            'is_public' => $request->boolean('is_public', false),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'File updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File moved to trash successfully.'
        ]);
    }

    /**
     * Display a listing of trashed resources.
     */
    public function trash()
    {
        $this->authorize('viewTrash', File::class);

        $trashedFiles = Auth::user()->files()->onlyTrashed()->latest()->paginate(20);
        $trashedFolders = Auth::user()->folders()->onlyTrashed()->latest()->paginate(20);

        return view('dashboard.trash', compact('trashedFiles', 'trashedFolders'));
    }
    
    /**
     * Empty the trash by permanently deleting all soft-deleted items.
     */
    public function emptyTrash()
    {
        $user = Auth::user();
        
        // Get all trashed files and folders
        $trashedFiles = $user->files()->onlyTrashed()->get();
        $trashedFolders = $user->folders()->onlyTrashed()->get();

        // Authorize that user can empty trash (e.g., must be logged in)
        // This policy method might need to be created if it doesn't exist.
        $this->authorize('emptyTrash', File::class);

        // Permanently delete each file and folder
        $trashedFiles->each->forceDelete();
        $trashedFolders->each->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Tempat sampah berhasil dikosongkan!'
        ]);
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore($id)
    {
        $file = File::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $this->authorize('restore', $file);

        $file->restore();

        return response()->json([
            'success' => true,
            'message' => 'File restored successfully!'
        ]);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $file = File::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $this->authorize('forceDelete', $file);

        // The Spatie Media Library package should handle deleting the associated file from disk 
        // when the model is force-deleted, if the model is configured correctly.
        $file->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'File permanently deleted!'
        ]);
    }

    /**
     * Download file.
     */
    public function download(File $file)
    {
        // Check if user owns the file or if it's public
        if ($file->user_id !== Auth::id() && !$file->is_public) {
            abort(403);
        }

        // Get the media file from the media library
        $media = $file->getFirstMedia('files');
        
        if (!$media) {
            abort(404, 'File not found');
        }

        // Get the actual file path from media library
        $path = $media->getPath();
        
        if (!file_exists($path)) {
            abort(404, 'File not found on disk');
        }

        return response()->download($path, $file->original_name);
    }

    /**
     * Preview file.
     */
    public function preview(File $file)
    {
        // Check if user owns the file or if it's public
        if ($file->user_id !== Auth::id() && !$file->is_public) {
            abort(403);
        }

        if (!$file->isPreviewable()) {
            return redirect()->route('files.download', $file);
        }

        // Get the media file from the media library
        $media = $file->getFirstMedia('files');
        
        if (!$media) {
            abort(404, 'File not found');
        }

        // Get the actual file path from media library
        $path = $media->getPath();
        
        if (!file_exists($path)) {
            abort(404, 'File not found on disk');
        }

        $content = file_get_contents($path);
        $mimeType = $file->mime_type;

        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $file->original_name . '"');
    }

    /**
     * Bulk delete files.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:files,id',
        ]);

        $user = Auth::user();
        File::where('user_id', $user->id)
            ->whereIn('id', $request->file_ids)
            ->get()
            ->each(function($file) {
                $this->authorize('delete', $file);
            $file->delete();
            });

        return redirect()->route('files.index')
            ->with('success', count($request->file_ids) . ' files moved to trash!');
    }

    /**
     * Bulk download files.
     */
    public function bulkDownload(Request $request)
    {
        $request->validate([
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:files,id',
        ]);

        $user = Auth::user();
        $files = $user->files()->whereIn('id', $request->file_ids)->get();
        
        if ($files->count() === 1) {
            return $this->download($files->first());
        }

        // Create ZIP file for multiple files
        $zipName = 'files_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipName);
        
        // Create temp directory if it doesn't exist
        $tempDir = dirname($zipPath);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE);
        
        foreach ($files as $file) {
            $media = $file->getFirstMedia('files');
            if ($media && file_exists($media->getPath())) {
                $zip->addFile($media->getPath(), $file->original_name);
            }
        }
        
        $zip->close();

        return response()->download($zipPath, $zipName)
            ->deleteFileAfterSend();
    }

    /**
     * Generate thumbnail for image files.
     */
    private function generateThumbnail(File $file)
    {
        $this->authorize('view', $file);

        $media = $file->getFirstMedia('files');

        if (!$media || !str_starts_with($media->mime_type, 'image/')) {
            abort(404);
            }
            
        $manager = new ImageManager();
        $image = $manager->make($media->getPath())->fit(100, 100);

        return $image->response();
    }
}
