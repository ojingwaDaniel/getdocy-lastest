<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
 
    public function index()
    {
        $departments = Department::withCount('courses')
                                 ->orderBy('name')
                                 ->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    // SHOW create form
    public function create()
    {
        return view('admin.departments.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|max:10|unique:departments,code',
            'faculty' => 'nullable|string|max:255',
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department created successfully.');
    }

  
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }


    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|max:10|unique:departments,code,' . $department->id,
            'faculty' => 'nullable|string|max:255',
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department updated successfully.');
    }


    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department deleted.');
    }
}