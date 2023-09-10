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
use Yajra\DataTables\Html\Builder;
use App\DataTables\CustomerDataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Imports\CustomerImport;
use Excel;
use Mail;
use App\Mail\ContactMail;
use Event;
use App\Events\SendMail;
use Auth;
class CustomerController extends Controller
{
     public function index(Builder $builder)
    {   


        $customer = Customer::select('*')->withTrashed();
      
        if (request()->ajax()) {
    
       
 return DataTables::of($customer)->order(function ($query) {
                     $query->orderBy('lname', 'DESC');
                 })->addColumn('action', function($row) {
                    return " <form action=". route('customer.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Deactivate</button>
                      </form>';
            })->addColumn('deleted_at',function ($customer) {
                    return ($customer->trashed() ? 'No' : 'Yes');
                })->addColumn('img_path', function ($row) {             
$url= asset('images/'.$row->img_path);            
return '<img src="'.$url.'" border="0" height="250" width="250" class="img-rounded" align="center" />';       
 })->
rawColumns(['action','img_path' ])->make(true);
            }
           
        

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'fname', 'name' => 'fname', 'title' => 'First name'],
                 ['data' => 'lname', 'name' => 'lname', 'title' => 'Surname'],
                ['data' => 'addressline', 'name' => 'addressline', 'title' => 'Address'],
                ['data' => 'town', 'name' => 'town', 'title' => 'Town'],
                
                ['data' => 'zipcode', 'name' => 'zipcode', 'title' => 'Zip'],
                ['data' => 'phone', 'name' => 'phone', 'title' => 'Phone'],
                 ['data' => 'img_path', 'name' => 'img_path', 'title' => 'Image'],

            
                 ['data' => 'deleted_at', 'name' => 'deleted_at', 'title' => 'Active'],
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

    return view('customer.index', compact('html'));

    }


    public function store(Request $request)
    {
 
        
        $customer = new Customer();
        $customer->title = $request->title;
        $customer->fname = $request->fname;
        $customer->lname = $request->lname;
        $customer->addressline = $request->addressline;
        $customer->town = $request->town;
        $customer->zipcode = $request->zipcode;
        $customer->phone = $request->phone;
        $customer->role = 'customer';
        $customer->save();
       $lid = DB::getPdo()->lastInsertId();

       $user = new User();
       $user->customer()->associate($lid);
       $user->email = $request->email;
        $user->password = bcrypt($request->password);
       $user->save();

      

       

        $data = array(
            'sender'   => $request->fname.' '.$request->fname,
            'title'   =>  $request->title,
            'body'   =>   $request->body
            
        );
        
         Mail::to('administrator@bands.com.ph')->send(new ContactMail($data));
        return Redirect::to('/customer')->with('success','New Customer added!');

        // Event::dispatch(new SendMail($customer));

    }


    public function edit($id)
    {
       
         $customer = Customer::where('id',$id)->first();
        $user = User::where('user_id',$id)->first();
        
        return View::make('customer.edit',compact('customer', 'user'));
    }



    public function update(Request $request,$id)
    {
        


         if ($request->image == null)
         {
            $customer = Customer::find($id);
            $customer->title = $request->title;
            $customer->fname = $request->fname;
            $customer->lname = $request->lname;
            $customer->addressline = $request->addressline;
            $customer->town = $request->town;
            $customer->zipcode = $request->zipcode;
            $customer->phone = $request->phone;
            $customer->role = 'customer';
            $customer->img_path = 'default.jpg';
            $customer->save();
            $user = User::where('user_id',$id)->first();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

         }
         else
         {
                
           if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
          
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/images';
            
            $input['img_path'] = $fileName;
           
            $file->move($destinationPath,$fileName);
            }

            $customer = Customer::find($id);
            $customer->title = $request->title;
            $customer->fname = $request->fname;
            $customer->lname = $request->lname;
            $customer->addressline = $request->addressline;
            $customer->town = $request->town;
            $customer->zipcode = $request->zipcode;
            $customer->phone = $request->phone;
            $customer->role = 'customer';
            $customer->img_path = $fileName;
            $customer->save();
            $user = User::where('user_id',$id)->first();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
         }

         return Redirect::to('/customer')->with('success','Customer Information Successfully Edited');
    }


    public function destroy($id)
    {   
      
        $cus = Customer::withTrashed()->find($id);


        if($cus->trashed())
        {


            $customer = Customer::withTrashed()->find($id);
            Customer::withTrashed()->find($id)->restore();
             User::withTrashed()->where('id',$customer->user_id)->restore();
           
             return Redirect::to('/customer')->with('success','Customer Restored');
        }
        else
        {
        $customer = Customer::withTrashed()->find($id);
       
        $cus = Customer::select('user_id')->where('id',$id)->first();

        

        $user = User::where('id',$cus->user_id)->first();
          $customer->delete();
        $user->delete();

         return Redirect::to('/customer')->with('success','Customer Deleted');
        }
    }


     public function import(Request $request) {
        
        
         Excel::import(new CustomerImport, request()->file('album_upload'));
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }

    public function register()
    {
        return View::make('customer.register');
    }



     public function customerhistory()
    {   
         
    

        $query = DB::table('customers')
            ->join('pets','customers.id','pets.owner_id')
            ->join('groom_infos','pets.id','groom_infos.pet_id')
            ->join('services','groom_infos.service_id','services.id')
            ->select('customers.id AS cid','customers.title','customers.fname','customers.lname','pets.id AS pid','pets.pet_name','groom_infos.date','services.name')
          ->orderBy('cid','DESC')->get();

           //dd($query);
        return view('search.customer', compact('query'));
    }


    public function search(Request $request){
    
 

    $search = $request->input('search');




        $query = DB::table('customers')
            ->join('pets','customers.id','pets.owner_id')
            ->join('groom_infos','pets.id','groom_infos.pet_id')
            ->join('services','groom_infos.service_id','services.id')
            ->select('customers.id AS cid','customers.title','customers.fname','customers.lname','pets.id AS pid','pets.pet_name','groom_infos.date','services.name')
        ->where('customers.lname', 'LIKE', "%{$search}%")
        ->orWhere('customers.fname', 'LIKE', "%{$search}%")
           ->get();
        return view('search.customer', compact('query'));
    }


     public function indexsearch(Builder $builder)
    {   
         
    

       


  $customer = Customer::join('pets', 'user_infos.id', 'pets.owner_id')->join('groom_infos', 'pets.id', 'groom_infos.pet_id')
    ->join('services','groom_infos.service_id','services.id')
->select('user_infos.*',DB::raw("CONCAT(user_infos.fname,' ',user_infos.lname) as full_name"),'user_infos.id AS cid','pets.id AS pid','pets.pet_name','user_infos.fname','user_infos.lname','services.id AS sid','services.name','services.price','groom_infos.date')

->with('pet')
;

//dd($customer);
  
        if (request()->ajax()) {
       
    return DataTables::of($customer)->order(function ($query) {
                     $query->orderBy('groom_infos.date', 'DESC');
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
                ['data' => 'full_name', 'name' => 'user_infos.fname', 'title' => 'First Name'],
               
                ['data' => 'pet_name', 'name' => 'pets.pet_name', 'title' => 'Pet Name'],
                 ['data' => 'name', 'name' => 'services.name', 'title' => 'Service'],
                ['data' => 'price', 'name' => 'services.price', 'title' => 'Price'],
                 ['data' => 'date', 'name' => 'groom_infos.date', 'title' => 'Date'],
                
              
                
                
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


     
      
       
    return view('search.customer', compact('html'));

}

     public function admin(Builder $builder)
    {
        $customer = Customer::onlyTrashed()->where('role','customer');
      //dd($employee);
       if(request()->ajax())
    {
        return DataTables::of($customer)->order(function ($query) {
                     $query->orderBy('lname', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('customer.edit', $row->id). "
class=\"btn btn-warning\">Edit</a> <form action=". route('customer.restore', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="POST">
                    <button class="btn btn-danger" type="submit">Activate</button>
                      </form>';
            })
                    ->rawColumns(['action'])
                    ->toJson();
            }
   
           
        

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'fname', 'name' => 'fname', 'title' => 'First name'],
                 ['data' => 'lname', 'name' => 'lname', 'title' => 'Surname'],
                ['data' => 'addressline', 'name' => 'addressline', 'title' => 'Address'],
                ['data' => 'town', 'name' => 'town', 'title' => 'Town'],
                
                ['data' => 'zipcode', 'name' => 'zipcode', 'title' => 'Zip'],
                ['data' => 'phone', 'name' => 'phone', 'title' => 'Phone'],
                ['data' => 'role', 'name' => 'role', 'title' => 'Role'],


                
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

    return view('customer.admin', compact('html'));
    }


 

    
    public function restore($id)

    {

       // dd($id);


        
        Customer::withTrashed()->find($id)->restore();
        User::withTrashed()->where('user_id',$id)->restore();
        return redirect()->back()->with('success','Customer Restored');
    }


     public function customerprofile($id)
    {
         
         $user = User::where('id',Auth()->id())->first();
        $customer = Customer::where('user_id',Auth()->id())->first();
       

       
        
        return View::make('customer.editcustomer',compact('customer', 'user'));
    }


     public function profileupdate(Request $request, $id)
    {
        

         if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
          
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/images';
            
            $input['img_path'] = $fileName;
           
            $file->move($destinationPath,$fileName);
            }
            $user = User::where('id',Auth()->id())->first();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            $customer = Customer::find($id);
            $customer->fname = $request->fname;
            $customer->lname = $request->lname;
            $customer->addressline = $request->addressline;
            $customer->town = $request->town;
            $customer->zipcode = $request->zipcode;
            $customer->phone = $request->phone;
            $customer->img_path = $fileName;
            $customer->save();
            
            
            
             $customer = Customer::find($id);
            return View::make('customer.profile',compact('customer'));


    }


  
}
