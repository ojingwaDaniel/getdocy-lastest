<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Course;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
      $user = auth()->user()->load(["department",
    'student.level'
]);


     
        $recentDocuments = Document::whereHas('course', function ($q) use ($user) {
                                $q->where('department_id', $user->department_id);
                            })
                            ->with('course')
                            ->latest()
                            ->take(6)
                            ->get();

        return view('student.dashboard', compact('recentDocuments',"user"));
    }
}