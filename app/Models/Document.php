<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'title',
        'description',
         'department_id', 
           'level_id',  
        'file_path',
        'file_type',
        'file_size',
        'category',
        'course_id',
        'uploaded_by',
        'download_count',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'file_size'   => 'integer',
    ];

    // ─── RELATIONSHIPS ────────────────────────────────────────

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ─── SCOPES ───────────────────────────────────────────────
    // Scopes are reusable query filters you chain like:
    // Document::approved()->forDepartment(1)->get()

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeForDepartment(Builder $query, int $departmentId): Builder
    {
        return $query->whereHas('course', fn($q) =>
            $q->where('department_id', $departmentId)
        );
    }

    public function scopeForLevel(Builder $query, int $levelId): Builder
    {
        return $query->whereHas('course', fn($q) =>
            $q->where('level_id', $levelId)
        );
    }

    // ─── HELPERS ──────────────────────────────────────────────

    // Human-readable file size: "2.4 MB"
    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    // Category label map
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'handout'       => 'Handout',
            'past_question' => 'Past Question',
            'textbook'      => 'Textbook',
            'note'          => 'Lecture Note',
            'assignment'    => 'Assignment',
            default         => 'Other',
        };
    }

    // Category badge colour for the UI
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'handout'       => 'blue',
            'past_question' => 'red',
            'textbook'      => 'green',
            'note'          => 'purple',
            'assignment'    => 'yellow',
            default         => 'gray',
        };
    }

    public function getDownloadUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }
}