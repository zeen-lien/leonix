<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $parentId = $request->input('parent_id');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('folders')->where(function ($query) use ($parentId) {
                    return $query->where('parent_id', $parentId)
                                 ->where('user_id', Auth::id());
                }),
            ],
            'parent_id' => 'nullable|exists:folders,id,user_id,' . Auth::id()
        ], [
            'name.unique' => 'You already have a folder with this name in the same location.'
        ]);

        $folder = new Folder();
        $folder->name = $validated['name'];
        $folder->user_id = Auth::id();
        $folder->parent_id = $validated['parent_id'] ?? null;
        $folder->save();

        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil dibuat!',
            'folder' => $folder
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        $this->authorize('view', $folder);

        $folder->load('children', 'files');

        // Fetch all folders for the dropdown in the upload modal
        $allFolders = Auth::user()->folders()->get();

        return view('folders.show', compact('folder', 'allFolders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder)
    {
        $this->authorize('update', $folder);

        $folders = Auth::user()->folders()
            ->where('id', '!=', $folder->id)
            ->whereNotIn('id', $folder->getAncestorsAttribute()->pluck('id'))
            ->get();

        return view('folders.edit', compact('folder', 'folders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        $this->authorize('update', $folder);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => [
                'nullable',
                'exists:folders,id',
                function ($attribute, $value, $fail) use ($folder) {
                    if ($value == $folder->id) {
                        $fail('A folder cannot be its own parent.');
                    }
                    
                    // Check if the new parent is not a descendant of this folder
                    if ($value) {
                        $newParent = Folder::find($value);
                        if ($newParent && $newParent->user_id === Auth::id()) {
                            $ancestors = $newParent->getAncestorsAttribute();
                            if ($ancestors->contains('id', $folder->id)) {
                                $fail('Cannot move folder to its own descendant.');
                            }
                        }
                    }
                }
            ]
        ]);

        $folder->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('folders.show', $folder)
            ->with('success', 'Folder updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        $this->authorize('delete', $folder);

        // Soft delete the folder. Associated files/subfolders will be handled by the model's deleting event.
        $folder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Folder and its contents moved to trash!'
        ]);
    }

    /**
     * Restore the specified folder from trash.
     */
    public function restore($id)
    {
        $folder = Folder::with('children', 'files')->onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $this->authorize('restore', $folder);
        
        $folder->restore(); // The model's restoring event should handle children and files.

        return response()->json([
            'success' => true,
            'message' => 'Folder and its contents restored successfully!'
        ]);
    }

    /**
     * Permanently delete the specified folder.
     */
    public function forceDelete($id)
    {
        $folder = Folder::with('children', 'files')->onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $this->authorize('forceDelete', $folder);

        // The model's forceDeleting event should handle deleting children, files, and their associated media.
        $folder->forceDelete();
        
        return response()->json([
            'success' => true,
            'message' => 'Folder and its contents permanently deleted!'
        ]);
    }
}
