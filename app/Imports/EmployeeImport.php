<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Employee;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
class EmployeeImport implements ToCollection,WithHeadingRow
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
            $user->role = 'employee';
            $user->save();

                $lid = DB::getPdo()->lastInsertId();
             $employee = new Employee();
            
                $employee->fname = $row['fname'];
                $employee->user_id = $lid;
                $employee->lname = $row['lname'];
                $employee->addressline = $row['addressline'];
                $employee->town = $row['town'];
                $employee->zipcode = $row['zipcode'];
                $employee->phone = $row['phone'];
                
                
                $employee->save();
          

            
            
        }
    }
}
