<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Customer;
use View;
use Redirect;
use Validator;
use softDeletes;
use DB;
use Yajra\DataTables\Html\Builder;
use App\DataTables\PetDataTable;
use App\DataTables\PetSearchDataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Imports\PetImport;
use Excel;

class PetController extends Controller
{
    public function index(Builder $builder)
    {
        $customer= Customer::where('user_id',Auth()->id())->first();
         $pet = Pet::Join('breed','breed.id','breed_id')->Join('customers','customers.id','owner_id')->select('pets.pet_name','pets.id','breed.description','pets.pet_age','pets.gender','customers.fname',DB::raw("CONCAT(fname,' ',lname) AS cname"),'pets.img_path')->where('owner_id',$customer->id);
  
        if (request()->ajax()) {
       
    return DataTables::of($pet)->order(function ($query) {
                     $query->orderBy('pets.id', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('pet.edit', $row->id). "
        class=\"btn btn-warning\">Edit</a> <form action=". route('pet.destroy', $row->id). " method = \"POST\" >". csrf_field() .
                    '<input name="_met  hod" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                      </form>';
            })->addColumn('img_path', function ($row) {             
$url= asset('images/'.$row->img_path);            
return '<img src="'.$url.'" border="0" height="250" width="250" class="img-rounded" align="center" />';       
 })->
rawColumns(['action','img_path' ])->make(true);
        }

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'pets.id', 'title' => 'Id'],
                ['data' => 'pet_name', 'name' => 'pet_name', 'title' => 'Pet Name'],
                ['data' => 'description', 'name' => 'breed.description', 'title' => 'Breed'],
                 ['data' => 'gender', 'name' => 'pets.gender', 'title' => 'Gender'],
                ['data' => 'pet_age', 'name' => 'pets.pet_age', 'title' => 'Age'],
                ['data' => 'cname', 'name' => 'customers.fname', 'title' => 'Owner'],
              
                ['data' => 'img_path', 'name' => 'img_path', 'title' => 'Image'],
                ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
            ])->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(5)
                    ->buttons(
                         Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    )->parameters([
                        'buttons' => ['excel','pdf','csv'],
                    ]);


     $customers = Customer::select('*')->where('role','customer');
     $breeds = DB::select('SELECT * FROM breed');
      
       
    return view('pet.index', compact('html','customers','breeds'));
    }


    public function store(Request $request)
    {        

             $input = $request->all();
            if($request->hasFile('image')) {
            
           $file = $request->file('image') ;
          
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/images';
            
            $input['img_path'] = $fileName;
           
            $file->move($destinationPath,$fileName);
          
            $cus = Customer::select('id')->where('user_id',auth()->id())->first();
           $input['owner_id'] = $cus->id;
            Pet::create($input);
           
                }


            
       return Redirect::to('pet')->with('success','New Pet added!');
           

    }


    public function edit($id)
    {
       
        $pet = Pet::where('id',$id)->first();
        $customers = Customer::get();
        $breeds = DB::select('SELECT * FROM breed');
        return View::make('pet.edit',compact('pet','breeds','customers'));
    }

    public function update(Request $request,$id)
    {

        //dd($request->all());
              $input = $request->all();
            if($request->hasFile('image')) {
            
           $file = $request->file('image') ;
          
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/images';
            
            $input['img_path'] = $fileName;
           
            $file->move($destinationPath,$fileName);
          
           
            
           
                }


                $pet = Pet::find($id);
                $pet->breed_id = $request->breed_id;
                $pet->pet_name = $request->pet_name; 
                $pet->gender = $request->gender; 
                $pet->pet_age = $request->pet_age;
                $pet->img_path = $fileName;
                $pet->save();


       return Redirect::to('pet')->with('success','Pet Information Succesfully Edited!');
    }  

    public function destroy($id)
    {
       $pet = Pet::find($id);
       $pet->delete();


       return Redirect::to('pet')->with('success','Pet Deleted!');
    } 


     public function import(Request $request) {
        
        
         Excel::import(new PetImport, request()->file('pet_upload'));
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }

     public function indexsearch(Builder $builder)
    {   
         
    

       


  $pet = Pet::join('user_infos', 'owner_id', 'user_infos.id')->join('checkup_infos', 'pets.id', 'checkup_infos.pet_id')
    ->join('diseases','diseases.id','checkup_infos.disease_id')
    ->join('breed','breed.id','pets.breed_id')
->select('checkup_infos.id AS cid','pets.id','pets.pet_name','breed.description','diseases.name','checkup_infos.comments','checkup_infos.date')

->with('customer')
;


  
        if (request()->ajax()) {
       
    return DataTables::of($pet)->order(function ($query) {
                     $query->orderBy('checkup_infos.id', 'DESC');
                  })
    //->addColumn('action', function($row) {
        //             return "<a href=".route('pet.edit', $row->id). "
        // class=\"btn btn-warning\">Edit</a> <form action=". route('pet.destroy', $row->id). " method = \"POST\" >". csrf_field() .
        //             '<input name="_met  hod" type="hidden" value="DELETE">
        //             <button class="btn btn-danger" type="submit">Delete</button>
        //               </form>';
        //     })
        //             ->rawColumns(['action'])
                    ->toJson();
        }

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'checkup_infos.id', 'title' => 'Id'],
                ['data' => 'description', 'name' => 'breed.description', 'title' => 'Breed'],
                ['data' => 'pet_name', 'name' => 'pets.pet_name', 'title' => 'name'],
                 ['data' => 'name', 'name' => 'diseases.name', 'title' => 'disease'],
                ['data' => 'comments', 'name' => 'checkup_infos.comments', 'title' => 'comments'],
                
              
                
                
            ])->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(4)
                    ->buttons(
                         Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    )->parameters([
                        'buttons' => [],
                    ]);


     
      
       
    return view('search.pet', compact('html'));

























 

    }
        
        
    public function search(Request $request){
    
        $search = $request->input('search');

    

        $query = Pet::join('user_infos', 'owner_id', 'user_infos.id')->join('checkup_infos', 'pets.id', 'checkup_infos.pet_id')
    ->join('diseases','diseases.id','checkup_infos.disease_id')
    ->join('breed','breed.id','pets.breed_id')
->select('checkup_infos.id AS cid','pets.id','pets.pet_name','breed.description','diseases.name','checkup_infos.comments','checkup_infos.date')
->where('pets.pet_name', 'LIKE', "%{$search}%")
->with('customer')

        
           ->get();
        return view('search.pet', compact('query'));
    }



     public function allpets(Builder $builder)
    {
        $pet = Pet::Join('breed','breed.id','breed_id')->Join('customers','customers.id','owner_id')->select('pets.pet_name','pets.id','breed.description','pets.pet_age','pets.gender','customers.fname',DB::raw("CONCAT(fname,' ',lname) AS cname"),'pets.img_path');
  // dd($pet->get());
        if (request()->ajax()) {
       
    return DataTables::of($pet)->order(function ($query) {
                     $query->orderBy('pets.id', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('pet.edit', $row->id). "
        class=\"btn btn-warning\">Edit</a> <form action=". route('pet.destroy', $row->id). " method = \"POST\" >". csrf_field() .
                    '<input name="_met  hod" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                      </form>';
            })->addColumn('img_path', function ($row) {             
$url= asset('images/'.$row->img_path);            
return '<img src="'.$url.'" border="0" height="250" width="250" class="img-rounded" align="center" />';       
 })->
rawColumns(['action','img_path' ])->make(true);
        }

        $dataTable = $builder->columns([
                ['data' => 'id', 'name' => 'pets.id', 'title' => 'Id'],
                ['data' => 'pet_name', 'name' => 'pet_name', 'title' => 'Pet Name'],
                ['data' => 'description', 'name' => 'breed.description', 'title' => 'Breed'],
                 ['data' => 'gender', 'name' => 'pets.gender', 'title' => 'Gender'],
                ['data' => 'pet_age', 'name' => 'pets.pet_age', 'title' => 'Age'],
                ['data' => 'cname', 'name' => 'customers.fname', 'title' => 'Owner'],
                 ['data' => 'img_path', 'name' => 'img_path', 'title' => 'Image'],
                
                
            ])->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(5)
                    ->buttons(
                         Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    )->parameters([
                        'buttons' => ['excel','pdf','csv'],
                    ]);


     
      
       
    return view('pet.allpets', compact('dataTable'));
    }


}
