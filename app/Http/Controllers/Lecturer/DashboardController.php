<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'my_uploads'    => Document::where('uploaded_by', $user->id)->count(),
            'total_downloads' => Document::where('uploaded_by', $user->id)->sum('download_count'),
        ];

        $recentDocuments = Document::where('uploaded_by', $user->id)
                                   ->with('course')
                                   ->latest()
                                   ->take(5)
                                   ->get();

        return view('lecturer.dashboard', compact('stats', 'recentDocuments'));
    }
}