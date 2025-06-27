<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\FileSizeFormatter;

class File extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, FileSizeFormatter;

    protected $fillable = [
        'user_id',
        'folder_id',
        'name',
        'original_name',
        'path',
        'mime_type',
        'size',
        'extension',
        'description',
        'metadata',
        'is_public',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_public' => 'boolean',
        'size' => 'integer',
    ];

    protected $appends = [
        'formatted_size',
        'file_icon',
        'download_url',
        'preview_url',
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the folder that owns the file.
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedSizeAttribute()
    {
        return $this->formatFileSize($this->size);
    }

    /**
     * Get file icon based on extension.
     */
    public function getFileIconAttribute()
    {
        return $this->getFileIcon($this->extension);
    }

    /**
     * Get download URL.
     */
    public function getDownloadUrlAttribute()
    {
        return route('files.download', $this->id);
    }

    /**
     * Get preview URL.
     */
    public function getPreviewUrlAttribute()
    {
        if ($this->isPreviewable()) {
            return route('files.preview', $this->id);
        }
        return null;
    }

    /**
     * Check if file is previewable.
     */
    public function isPreviewable()
    {
        $previewableTypes = [
            'pdf', 'txt', 'md', 'html', 'css', 'js', 'json', 'xml',
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp',
            'mp4', 'avi', 'mov', 'wmv', 'flv', 'webm',
            'mp3', 'wav', 'ogg', 'aac', 'flac'
        ];

        return in_array(strtolower($this->extension), $previewableTypes);
    }

    /**
     * Check if file is an image.
     */
    public function isImage()
    {
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        return in_array(strtolower($this->extension), $imageTypes);
    }

    /**
     * Check if file is a video.
     */
    public function isVideo()
    {
        $videoTypes = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];
        return in_array(strtolower($this->extension), $videoTypes);
    }

    /**
     * Check if file is an audio.
     */
    public function isAudio()
    {
        $audioTypes = ['mp3', 'wav', 'ogg', 'aac', 'flac'];
        return in_array(strtolower($this->extension), $audioTypes);
    }

    /**
     * Check if file is a document.
     */
    public function isDocument()
    {
        $documentTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'md'];
        return in_array(strtolower($this->extension), $documentTypes);
    }

    /**
     * Get file icon.
     */
    private function getFileIcon($extension)
    {
        $icons = [
            'pdf' => '📄',
            'doc' => '📝',
            'docx' => '📝',
            'xls' => '📊',
            'xlsx' => '📊',
            'ppt' => '📽️',
            'pptx' => '📽️',
            'jpg' => '🖼️',
            'jpeg' => '🖼️',
            'png' => '🖼️',
            'gif' => '🖼️',
            'bmp' => '🖼️',
            'svg' => '🖼️',
            'webp' => '🖼️',
            'mp4' => '🎥',
            'avi' => '🎥',
            'mov' => '🎥',
            'wmv' => '🎥',
            'flv' => '🎥',
            'webm' => '🎥',
            'mp3' => '🎵',
            'wav' => '🎵',
            'ogg' => '🎵',
            'aac' => '🎵',
            'flac' => '🎵',
            'zip' => '📦',
            'rar' => '📦',
            '7z' => '📦',
            'tar' => '📦',
            'gz' => '📦',
            'txt' => '📄',
            'md' => '📄',
            'html' => '🌐',
            'css' => '🎨',
            'js' => '⚡',
            'json' => '📋',
            'xml' => '📋',
        ];

        return $icons[strtolower($extension)] ?? '📄';
    }

    /**
     * Scope for user's files.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for public files.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for search.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('original_name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
