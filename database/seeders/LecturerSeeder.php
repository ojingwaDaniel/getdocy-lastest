<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          $lecturer = User::firstOrCreate(
            [ "email" => "lecturer@getdocy.com"],
            [
            'name' => 'Daniel Ojingwa',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            ]
        );
        $lecturer->assignRole("lecturer");
    }
    
}
