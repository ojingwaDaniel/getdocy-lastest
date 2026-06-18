<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Document;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Base: approved + student's department only
        $query = Document::approved()
                         ->forDepartment($user->department_id)
                         ->with(['course', 'uploader']);

        // Filter by level
        if ($request->filled('level_id')) {
            $query->forLevel($request->level_id);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents = $query->latest()->paginate(12)->withQueryString();

        // For filter dropdowns — only courses in this student's dept
        $courses = Course::where('department_id', $user->department_id)
                         ->orderBy('code')->get();
        $levels  = Level::orderBy('value')->get();

        return view('student.documents.index', compact('documents', 'courses', 'levels'));
    }

    public function download(Document $document)
    {
        // Only approved documents can be downloaded
        if (!$document->isApproved()) {
            abort(403, 'This document is not available.');
        }

        // Only students in the right department can download
        $user = auth()->user();
        if ($document->course->department_id !== $user->department_id) {
            abort(403, 'This document is not for your department.');
        }

        // Increment download count
        $document->increment('download_count');

        // Return the file as a download
        return Storage::disk('public')->download(
            $document->file_path,
            $document->title . '.' . $document->file_type
        );
    }
}