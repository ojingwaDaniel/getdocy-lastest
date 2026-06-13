<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'level'])
                         ->orderBy('code')
                         ->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('value')->get();

        return view('admin.courses.create', compact('departments', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'code'          => 'required|string|max:20|unique:courses,code',
            'department_id' => 'required|exists:departments,id',
            'level_id'      => 'required|exists:levels,id',
            'credit_units'  => 'required|integer|min:1|max:6',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('value')->get();

        return view('admin.courses.edit', compact('course', 'departments', 'levels'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'code'          => 'required|string|max:20|unique:courses,code,' . $course->id,
            'department_id' => 'required|exists:departments,id',
            'level_id'      => 'required|exists:levels,id',
            'credit_units'  => 'required|integer|min:1|max:6',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course deleted.');
    }
}