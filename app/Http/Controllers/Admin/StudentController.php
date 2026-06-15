<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::role('student')
                        ->with(['department', 'student.level'])
                        ->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('value')->get();
        return view('admin.students.create', compact('departments', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'matric_number' => 'required|string|unique:students,matric_number',
            'level_id'      => 'required|exists:levels,id',
            'password'      => 'required|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'phone'         => $validated['phone'] ?? null,
                'department_id' => $validated['department_id'],
                'password'      => Hash::make($validated['password']),
            ]);

            $user->assignRole('student');

            Student::create([
                'user_id'       => $user->id,
                'matric_number' => $validated['matric_number'],
                'level_id'      => $validated['level_id'],
            ]);
        });

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student account created.');
    }

    public function edit(User $student)
{
    $departments = Department::orderBy('name')->get();
    $levels = Level::orderBy('value')->get();
    return view('admin.students.edit', compact('student', 'departments', 'levels'));
}

public function update(Request $request, User $student)
{
   
    $studentRecordId = $student->student?->id ?? 0;

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'phone'         => 'nullable|string|max:20',
        'department_id' => 'required|exists:departments,id',
        'matric_number' => 'required|string|unique:students,matric_number,' . $studentRecordId,
        'level_id'      => 'required|exists:levels,id',
    ]);

    DB::transaction(function () use ($validated, $student) {
        // Update the user record
        $student->update([
            'name'          => $validated['name'],
            'phone'         => $validated['phone'],
            'department_id' => $validated['department_id'],
        ]);

        $student->student()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'matric_number' => $validated['matric_number'],
                'level_id'      => $validated['level_id'],
            ]
        );
    });

    return redirect()->route('admin.students.index')
                     ->with('success', 'Student updated.');
}

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')
                         ->with('success', 'Student removed.');
    }
}