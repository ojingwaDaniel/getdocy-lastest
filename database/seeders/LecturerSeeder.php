<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::transaction(function (){
            $lecturer = User::firstOrCreate(
            [ "email" => "lecturer@getdocy.com"],
            [
            'name' => 'E O Elijah',
            'password' => Hash::make('password'),
            "department_id"=> 5,
            'email_verified_at' => now(),
            ]
        );
        $lecturer->assignRole("lecturer");
        Lecturer::firstOrCreate(
            ["user_id"=> $lecturer->id],
            [
                "department_id" => 5,
                "status" => "active"
            ]
        );

        });
          
    }
    
}
