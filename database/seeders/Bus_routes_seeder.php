<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BusRoute;

class Bus_routes_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('bus_routes')->insert([
            [
                'id' => 1,
                'line' => '1',
            ],
            [
                'id' => 2,
                'line' => '2',
            ],
            [
                'id' => 5,
                'line' => '5',
            ],
            [
                'id' => 8,
                'line' => '8',
            ],
            [
                'id' => 9,
                'line' => '9',
            ],
            [
                'id' => 10,
                'line' => '10',
            ],
            [
                'id' => 11,
                'line' => '11',
            ],
            [
                'id' => 16,
                'line' => '16',
            ],
            [
                'id' => 17,
                'line' => '17',
            ],
            [
                'id' => 18,
                'line' => '18',
            ],
        ]);
       /* $busroute = new BusRoute;
        $busroute->line = "1";
        $busroute->save();
        
        $busroute = new BusRoute;
        $busroute->line = "2";
        $busroute->save();


        $busroute = new BusRoute;
        $busroute->line = "5";
        $busroute->save();

        $busroute = new BusRoute;
        $busroute->line = "9";
        $busroute->save();

        $busroute = new BusRoute;
        $busroute->line = "10";
        $busroute->save();

        $busroute = new BusRoute;
        $busroute->line = "11";
        $busroute->save();

        $busroute = new BusRoute;
        $busroute->line = "16";
        $busroute->save();

        $busroute = new BusRoute;
        $busroute->line = "17";
        $busroute->save();

        $busroute = new BusRoute;
        $busroute->line = "18";
        $busroute->save();
            */

       
    }
}
