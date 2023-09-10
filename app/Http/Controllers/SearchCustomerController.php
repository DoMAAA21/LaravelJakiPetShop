<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Pet;
use View;
use Redirect;
use Validator;
use softDeletes;
use DB;

use Yajra\DataTables\Html\Column;
use Spatie\Searchable\Search;
class SearchCustomerController extends Controller
{
     public function index()
   {
    return view::make('search.customer');
   }



   public function search(Request $request)
    {
        //dd($request->all());


        $searchterm = $request->input('search');
 
        $searchResults = (new Search())
                    ->registerModel(Customer::class, 'fname','lname')
                   
                    ->perform($searchterm);

                   


    return view('search.customer', compact('searchResults', 'searchterm'));
  



    
    }

    public function show($id)
    {

          $customers = Customer::join('pets', 'customers.id', 'pets.owner_id')->join('groom_infos', 'pets.id', 'groom_infos.pet_id')
    ->join('services','groom_infos.service_id','services.id')
->select('customers.*',DB::raw("CONCAT(customers.fname,' ',customers.lname) as full_name"),'customers.id AS cid','pets.id AS pid','pets.pet_name','customers.fname','customers.lname','services.id AS sid','services.name','services.price','groom_infos.date')->where('customers.id',$id)->get();


     return view('search.customershow', compact('customers'));
    }
}
