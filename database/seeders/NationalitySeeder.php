<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalites = require database_path('initData/nationalities.php');

        foreach ($nationalites as $nationality) {
            Nationality::create($nationality);
        }
    }
}
