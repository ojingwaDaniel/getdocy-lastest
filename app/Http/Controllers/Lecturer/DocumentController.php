<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Upload history — only THIS lecturer's documents
    public function index()
    {
        $documents = Document::where('uploaded_by', auth()->id())
                             ->with('course')
                             ->latest()
                             ->paginate(15);

        return view('lecturer.documents.index', compact('documents'));
    }

    // Show upload form
    public function create()
    {
        // Only courses in this lecturer's department
        $courses = Course::where('department_id', auth()->user()->department_id)
                         ->with('level')
                         ->orderBy('code')
                         ->get();

        return view('lecturer.documents.create', compact('courses'));
    }

    // Handle the file upload
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'course_id'   => 'required|exists:courses,id',
            'category'    => 'required|in:handout,past_question,textbook,note,assignment,other',
            'file'        => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480', // 20MB max
        ]);
        $course = Course::findOrFail($validated['course_id']);
        // Store the file
        // Storage::disk('public') saves to storage/app/public/
        // The path returned is relative e.g. "documents/abc123.pdf"
        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Document::create([
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'course_id'    => $validated['course_id'],
            'department_id' => $course->department_id,
            'level_id'      => $course->level_id,
            'category'     => $validated['category'],
            'file_path'    => $path,
            'file_type'    => $file->getClientOriginalExtension(),
            'file_size'    => $file->getSize(),
            'uploaded_by'  => auth()->id(),
            'status'       => 'pending', // always starts as pending
        ]);

        return redirect()->route('lecturer.documents.index')
                         ->with('success', 'Document uploaded successfully. Awaiting admin approval.');
    }

    // Lecturer can delete their own pending documents
    public function destroy(Document $document)
    {
        // Security: only owner can delete, and only if pending
        if ($document->uploaded_by !== auth()->id()) {
            abort(403, 'You do not own this document.');
        }

        if ($document->isApproved()) {
            return back()->with('error', 'Approved documents cannot be deleted.');
        }

        // Delete the actual file from disk
        Storage::disk('public')->delete($document->file_path);

        $document->delete();

        return redirect()->route('lecturer.documents.index')
                         ->with('success', 'Document deleted.');
    }
}