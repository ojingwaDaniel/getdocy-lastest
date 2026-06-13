<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = User::role('lecturer')
                         ->with(['department', 'lecturer'])
                         ->paginate(15);

        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.lecturers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'staff_id'      => 'required|string|unique:lecturers,staff_id',
            'title'         => 'nullable|string|max:20',
            'password'      => 'required|min:8|confirmed',
        ]);

        // Wrap in a transaction — both records must save or neither does
        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'phone'         => $validated['phone'] ?? null,
                'department_id' => $validated['department_id'],
                'password'      => Hash::make($validated['password']),
            ]);

            $user->assignRole('lecturer');

            Lecturer::create([
                'user_id'  => $user->id,
                'staff_id' => $validated['staff_id'],
                'title'    => $validated['title'] ?? null,
            ]);
        });

        return redirect()->route('admin.lecturers.index')
                         ->with('success', 'Lecturer account created.');
    }

    public function edit(User $lecturer)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.lecturers.edit', compact('lecturer', 'departments'));
    }

    public function update(Request $request, User $lecturer)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'title'         => 'nullable|string|max:20',
            'staff_id'      => 'required|string|unique:lecturers,staff_id,' . $lecturer->lecturer->id,
        ]);

        DB::transaction(function () use ($validated, $lecturer) {
            $lecturer->update([
                'name'          => $validated['name'],
                'phone'         => $validated['phone'],
                'department_id' => $validated['department_id'],
            ]);

            $lecturer->lecturer->update([
                'staff_id' => $validated['staff_id'],
                'title'    => $validated['title'],
            ]);
        });

        return redirect()->route('admin.lecturers.index')
                         ->with('success', 'Lecturer updated.');
    }

    public function destroy(User $lecturer)
    {
        $lecturer->delete(); 
        return redirect()->route('admin.lecturers.index')
                         ->with('success', 'Lecturer removed.');
    }
}