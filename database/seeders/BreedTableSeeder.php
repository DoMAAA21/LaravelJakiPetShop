<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use DB;
class BreedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            $brd = [
            ['description' => 'Labrador' ],
            ['description' => 'Tsiwawa' ],
            ['description' => 'Ragdoll' ],
            ['description' => 'Persian' ],
            ['description' => 'Aspin' ]
            
             ];


       
        
        DB::table('breed')->insert($brd);
    }
}
