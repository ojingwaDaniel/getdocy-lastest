<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentRegisterController extends Controller
{
    //
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

        $user = DB::transaction(function () use ($validated) {
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
            return $user;
        });
        Auth::login($user);

        return redirect()->route('student.dashboard');
            
    }
}
