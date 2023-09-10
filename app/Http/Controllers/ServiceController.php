<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pet;
use App\Models\Service;
use View;
use Redirect;
use Validator;
use softDeletes;
use DB;
use Yajra\DataTables\Html\Builder;
use App\DataTables\ServiceDataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Imports\ServiceImport;
use Excel;
class ServiceController extends Controller
{
    public function index(Builder $builder)
    {
            $services = Service::select('*');
  
        if (request()->ajax()) {
       
    return DataTables::of($services)->order(function ($query) {
                     $query->orderBy('id', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('service.edit', $row->id). "
        class=\"btn btn-warning\">Edit</a> <form action=". route('service.destroy', $row->id). " method = \"POST\" >". csrf_field() .
                    '<input name="_met  hod" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                      </form>';
            })
                    ->rawColumns(['action'])
                    ->toJson();
        }

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
                ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
                 ['data' => 'price', 'name' => 'price', 'title' => 'Price'],

              
                
                ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
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
                        'buttons' => ['excel','pdf','csv'],
                    ]);


      
       
    return view('services.index', compact('html'));
    }

    public function img_upload($filename)
    {
        $photo = array('photo' => $filename);
        $destinationPath = public_path().'/images'; // upload path
        $original_filename = time().$filename->getClientOriginalName(); // getting image extension
        $extension = $filename->getClientOriginalExtension(); // getting image extension
        //$fileName = rand(11111,99999).'.'.$extension; // renameing image
        $filename->move($destinationPath, $original_filename); 
    }



    public function store(Request $request)
    {
             //dd($request->all());


            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description; 
            $service->price = $request->price;
            $service->save();
            $lid = DB::getPdo()->lastInsertId();
                  
           //  $count = 0;
            
           // if($request->hasFile('image')) {

           //  foreach($request->file('image') as $file)
              
           //    dd($request->file('image'));
           //   $name = $file->getClientOriginalName();
           //      $file->move(public_path() . '/images/', $name);
                
               
               
               

           //      }



         $files = $request->file('image');
        $file_count = count($request->file('image'));      
        foreach ($files as $file) {          
                $this->img_upload($file);
                $multi['img_path']=time().$file->getClientOriginalName();
                $multi['service_id'] = $lid ;
                DB::table('cuts_images')->insert($multi);
        }










               
              
                 return Redirect::to('/services')->with('success','New Service added!');
            }


    public function edit($id)
    {
       
        $service = Service::where('id',$id)->first();
       
        return View::make('services.edit',compact('service'));
    }


    public function update(Request $request,$id)
    {
            $service = Service::find($id);
            $service->name = $request->name;
            $service->description = $request->description; 
            $service->price = $request->price;
            $service->save();
            
                  
           
            DB::table('cuts_images')
->where('service_id',$id)
->delete();

         $files = $request->file('image');
        $file_count = count($request->file('image'));      
        foreach ($files as $file) {          
                $this->img_upload($file);
                $multi['img_path']=time().$file->getClientOriginalName();
                $multi['service_id'] = $id ;
                DB::table('cuts_images')->insert($multi);
            }



            return Redirect::to('/services')->with('success','Services Updated!');
    
        }


        public function destroy($id)
        {
            $service = Service::find($id);
            DB::table('cuts_images')
            ->where('service_id',$id)
                ->delete();
            $service->delete();

            return Redirect::to('/services')->with('success','Services Deleted');
    

        }

        public function import(Request $request) {
        
        
         Excel::import(new ServiceImport, request()->file('service_upload'));
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }
}