<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Pet;
use Yajra\DataTables\Html\Builder;
use App\DataTables\PetMedicalDataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use View;
use Redirect;
use Validator;
use DB;
use Spatie\Searchable\Search;
class SearchPetController extends Controller
{
    public function index()
   {
    return view::make('search.pet');
   }


    public function search(Request $request)
    {
  
            // dd($request->all());

        $searchterm = $request->input('search');
 
        $searchResults = (new Search())
                    ->registerModel(Pet::class, 'pet_name')
                   
                    ->perform($searchterm);

                   


        return view('search.pet', compact('searchResults', 'searchterm'));
  



    
    }



    public function show($id)
    {


       $pets = Pet::join('customers', 'owner_id', 'customers.id')->join('checkup_infos', 'pets.id', 'checkup_infos.pet_id')
    ->join('diseases','diseases.id','checkup_infos.disease_id')
    ->join('breed','breed.id','pets.breed_id')
    ->select('checkup_infos.id AS cid','pets.id','pets.pet_name','breed.description','diseases.name','checkup_infos.comments','checkup_infos.date','customers.fname','customers.lname')->where('pets.id',$id)->get();

     return view('search.petshow', compact('pets'));
    }
}
