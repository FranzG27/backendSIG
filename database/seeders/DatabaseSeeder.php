<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(
            [
                UserSeeder::class,
               // Bus_routes_seeder::class,
                //Entry_points_seeder::class,
                
            ]
        );
        $this->call(Bus_routes_seeder::class);
        $this->call(Entry_points_seeder::class);
       $this->call(Exit_points_seeder::class);
    }
}
