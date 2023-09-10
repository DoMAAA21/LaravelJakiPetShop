<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use DB;
class DiseaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disease = [
            ['name'=>'Hookworms','description' => 'worms' ],
             ['name'=>'Salmonella','description' => 'bacterias' ],
              ['name'=>'Skin Allergies','description' => 'allergies' ],
               ['name'=>'Ear Infection','description' => 'ear damage' ],
               ['name'=>'Vomiting','description' => 'upset stomach' ],
           
            
             ];


       
        
        DB::table('diseases')->insert($disease);
    }
}
