<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['course.department', 'uploader'])
                         ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->forDepartment($request->department_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents  = $query->paginate(20)->withQueryString();
        $pendingCount = Document::pending()->count();

        return view('admin.documents.index', compact('documents', 'pendingCount'));
    }

    public function approve(Document $document)
    {
        $document->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
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