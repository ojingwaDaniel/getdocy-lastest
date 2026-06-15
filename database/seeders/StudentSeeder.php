<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function (){
            $student = User::firstOrCreate(
            ['email' => 'student@getdocy.com'],
            [
            'name' => 'Daniel Ojingwa',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            ]


        );
        $student->assignRole("student");
        Student::firstOrCreate(
        ['user_id' => $student->id],
        [
            'matric_number' => '2021/1/84310PM',   
            'level_id' => 5,                      
            'status' => 'active',
        ]
    );


        });
        
        
    }
}
