<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Customer;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
class CustomerImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
         foreach ($rows as $row) 
        {
            
            
            $user = new User();
           
            $user->email = $row['email'];
            $user->password = bcrypt($row['password']);
            $user->role = 'customer';
            $user->save();
             $lid = DB::getPdo()->lastInsertId();
                $customer = new Customer();
                $customer->user_id = $lid;
                $customer->fname = $row['fname'];
                $customer->lname = $row['lname'];
                $customer->addressline = $row['addressline'];
                $customer->town = $row['town'];
                $customer->zipcode = $row['zipcode'];
                $customer->phone = $row['phone'];
               
                
                $customer->save();
         
           

            
        }
    }
}
