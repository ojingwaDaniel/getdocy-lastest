<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Show documents relevant to the student's department & level
        $recentDocuments = Document::whereHas('course', function ($q) use ($user) {
                                $q->where('department_id', $user->department_id);
                            })
                            ->with('course')
                            ->latest()
                            ->take(6)
                            ->get();

        return view('student.dashboard', compact('recentDocuments'));
    }
}