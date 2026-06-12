<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
{
    $levels = [
        ['name' => '100 Level', 'value' => 100],
        ['name' => '200 Level', 'value' => 200],
        ['name' => '300 Level', 'value' => 300],
        ['name' => '400 Level', 'value' => 400],
        ['name' => '500 Level', 'value' => 500],
    ];

    foreach ($levels as $level) {
        \App\Models\Level::firstOrCreate(['value' => $level['value']], $level);
    }
}
}
