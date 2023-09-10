<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use App\Models\Pet;
class PetImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
         foreach ($rows as $row) 
        {
            
            
            //dd($row->all());
               $pet = new Pet();
                $breed = DB::table('breed')->select('id')->where('description',$row['breed'])->first();
                $pet->breed_id =  $breed->id;
                $pet->pet_name = $row['pet_name'];
                $pet->pet_age = $row['age'];
                $pet->gender = $row['gender'];

                $owner = DB::table('customers')->select('id')->where('fname',$row['owner_fname'])->where('lname',$row['owner_lname'])->first();

               // dd($owner);
                $pet->owner_id =   $owner->id;
                $pet->img_path  = 'pet.jpg';
                $pet->save();
        }
    }
}
