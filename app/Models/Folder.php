<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Folder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'parent_id',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($folder) {
            // Soft delete all children folders recursively
            foreach ($folder->children as $child) {
                $child->delete();
            }
            // Soft delete all files in this folder
            $folder->files()->delete();
        });

        static::restoring(function ($folder) {
            // Restore direct children folders
            $folder->children()->onlyTrashed()->get()->each(function($child) {
                $child->restore();
            });

            // Restore files in this folder
            $folder->files()->onlyTrashed()->restore();
        });

        static::forceDeleting(function ($folder) {
            // Permanently delete all files in this folder first to trigger their own deleting events
            $folder->files()->withTrashed()->get()->each(function ($file) {
                $file->forceDelete();
            });

            // Permanently delete all children folders recursively
            $folder->children()->withTrashed()->get()->each(function($child) {
                $child->forceDelete();
            });
        });
    }

    /**
     * Get the user that owns the folder.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent folder.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    /**
     * Get the children folders.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
    
    /**
     * Get all ancestor folders using an accessor.
     */
    public function getAncestorsAttribute()
    {
        $ancestors = collect([]);
        $parent = $this->parent;

        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Get the files for the folder.
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
    
    /**
     * Get all descendant folders recursively.
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }
}
