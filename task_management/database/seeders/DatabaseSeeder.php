<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run()
    {
        // Call only the ProjectSeeder
        $this->call(ProjectSeeder::class);
    }
}
