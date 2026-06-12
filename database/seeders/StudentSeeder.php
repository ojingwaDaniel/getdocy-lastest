<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $student = User::firstOrCreate(
            ['email' => 'student@getdocy.com'],
            [
            'name' => 'Daniel Ojingwa',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            ]


        );
        $student->assignRole("student");
    }
}
