<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'course_id',
        'uploaded_by',
        'type',
        'download_count',
    ];

    // A document belongs to a course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // A document was uploaded by a user
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}