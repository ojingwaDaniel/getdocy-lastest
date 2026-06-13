<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use Dom\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'    => User::role('student')->count(),
            'total_lecturers'   => User::role('lecturer')->count(),
            'total_departments' => Department::count(),
            'total_courses'     => Course::count(),
            'total_documents'   => Document::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

}
