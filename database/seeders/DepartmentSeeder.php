<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CSC', 'faculty' => 'Science'],
            ['name' => 'Electrical Engineering', 'code' => 'EEE', 'faculty' => 'Engineering'],
            ['name' => 'Mass Communication', 'code' => 'MAC', 'faculty' => 'Arts'],
            ['name' => 'Accounting', 'code' => 'ACC', 'faculty' => 'Management Sciences'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }
    }
}