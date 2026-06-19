<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Document;
use App\Models\Level;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
   public function index(Request $request)
{
    $query = Document::with(['course.department', 'course.level', 'uploader']);


    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    
    if ($request->filled('department_id')) {
        $query->forDepartment($request->department_id);
    }

  
    if ($request->filled('level_id')) {
        $query->forLevel($request->level_id);
    }

    // Search by title
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $documents = $query->latest()
                       ->paginate(20)
                       ->withQueryString();

    $pendingCount = Document::pending()->count();
    $departments  = Department::orderBy('name')->get();
    $levels       = Level::orderBy('value')->get();

    return view('admin.documents.index', compact(
        'documents', 'pendingCount', 'departments', 'levels'
    ));
}

   
    public function create()
    {
        $courses = Course::with(['department', 'level'])
                         ->orderBy('code')
                         ->get();

        return view('admin.documents.create', compact('courses'));
    }

  
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'course_id'   => 'required|exists:courses,id',
            'category'    => 'required|in:handout,past_question,textbook,note,assignment,other',
            'file'        => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480',
        ]);
        $course = Course::findOrFail($validated['course_id']);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Document::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'course_id'   => $validated['course_id'],
            "department_id" => $course->department_id,
            "level_id" => $course->level_id,
            'category'    => $validated['category'],
            'file_path'   => $path,
            'file_type'   => $file->getClientOriginalExtension(),
            'file_size'   => $file->getSize(),
            'uploaded_by' => auth()->id(),
            // Auto-approved — admin uploads don't need review
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.documents.index')
                         ->with('success', 'Document uploaded and published successfully.');
    }

    public function approve(Document $document)
    {
        $document->update([
            'status'           => 'approved',
            'approved_by'      => auth()->id(),
            'approved_at'      => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', "'{$document->title}' has been approved.");
    }

    public function reject(Request $request, Document $document)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $document->update([
            'status'           => 'rejected',
            'approved_by'      => auth()->id(),
            'approved_at'      => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', "'{$document->title}' has been rejected.");
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted.');
    }
}