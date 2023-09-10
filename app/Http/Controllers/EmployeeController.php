<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Pet;
use View;
use Redirect;
use Validator;
use softDeletes;
use DB;
use Yajra\DataTables\Html\Builder;
use App\DataTables\EmployeeDataTable;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Imports\EmployeeImport;
use Excel;
use Auth;
class EmployeeController extends Controller
{
     public function index(Builder $builder)
    {   

        $employee = Employee::join('users','user_id','users.id')->select('employees.*','users.role','users.email');
      //dd($customer);
        if (request()->ajax()) {
    
       
 return DataTables::of($employee)->order(function ($query) {
                     $query->orderBy('employees.id', 'DESC');
                 })->addColumn('action', function($row) {
                    return " <form action=". route('employee.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Change Role</button>
                      </form>';
            })->addColumn('img_path', function ($row) {             
$url= asset('images/'.$row->img_path);            
return '<img src="'.$url.'" border="0" height="250" width="250" class="img-rounded" align="center" />';       
 })->
rawColumns(['action','img_path' ])->make(true);
            }
           
        

        $html = $builder->columns([
             ['data' => 'img_path', 'name' => 'img_path', 'title' => 'Image'],
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'fname', 'name' => 'fname', 'title' => 'First name'],
                 ['data' => 'lname', 'name' => 'lname', 'title' => 'Surname'],
                ['data' => 'addressline', 'name' => 'addressline', 'title' => 'Address'],
                ['data' => 'town', 'name' => 'town', 'title' => 'Town'],
                
                ['data' => 'zipcode', 'name' => 'zipcode', 'title' => 'Zip'],
                ['data' => 'phone', 'name' => 'phone', 'title' => 'phone'],

                ['data' => 'email', 'name' => 'users.email', 'title' => 'Email'],

               
                ['data' => 'role', 'name' => 'users.role', 'title' => 'Role'],
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

    return view('employee.index', compact('html'));

    }


     public function store(Request $request)
    {
        
       $user = new User();
       
       $user->email = $request->email;
       $user->password = bcrypt($request->password);
       $user->role = 'employee';
       $user->save();
       $lid = DB::getPdo()->lastInsertId();
        $employee = new Employee();
        $employee->user_id =  $lid ;
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->addressline = $request->addressline;
        $employee->town = $request->town;
        $employee->zipcode = $request->zipcode;
        $employee->phone = $request->phone;
        
        $employee->save();
     


      

       return Redirect::to('/employee')->with('success','New Employee added!');
 
  



    }


     public function edit($id)
    {
       //dd($id);
         $employee = Employee::where('id',$id)->first();
        $user = User::where('user_id',$id)->first();
        
        return View::make('employee.edit',compact('employee', 'user'));
    }


    public function update(Request $request,$id)
    {
        

                
           if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
          
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/images';
            
            $input['img_path'] = $fileName;
           
            $file->move($destinationPath,$fileName);
            }

            $employee = Employee::find($id);
            $employee->title = $request->title;
            $employee->fname = $request->fname;
            $employee->lname = $request->lname;
            $employee->addressline = $request->addressline;
            $employee->town = $request->town;
            $employee->zipcode = $request->zipcode;
            $employee->phone = $request->phone;
            $employee->role = 'employee';
            $employee->img_path = $fileName;
            $employee->save();
            $user = User::where('user_id',$id)->first();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        
         return Redirect::to('/employee')->with('success','Employee Information Successfully Edited');
    }


     public function destroy($id)
    {     $emp = Employee::select('user_id')->where('id',$id)->first();
        $employee = Employee::where('id',$id)->first();
        $user = User::where('id',$emp->user_id)->first();

       
        
        return View::make('employee.adminedit',compact('employee', 'user'));
    }

    public function import(Request $request) {
        
        
         Excel::import(new EmployeeImport, request()->file('employee_upload'));
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }


    public function admin(Builder $builder)
    {
        $employee = Employee::select('*');
      //dd($employee);
       if(request()->ajax())
    {
        return DataTables::of($employee)->order(function ($query) {
                     $query->orderBy('lname', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('employee.admin/edit', $row->id). "
class=\"btn btn-warning\">Edit</a> <form action=". route('employee.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
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

    return view('employee.admin', compact('html'));
    }


     public function adminedit($id)
    {
       //dd($id);
         $employee = Employee::where('id',$id)->first();
        $user = User::where('user_id',$id)->first();
        
        return View::make('employee.adminedit',compact('employee', 'user'));
    }


     public function adminupdate(Request $request,$id)
    {
        
         $emp = Employee::select('user_id')->where('id',$id)->first();
            $user = User::where('id',$emp->user_id)->first();
    
            $user->role = $request->role;
           
            $user->save();
       
        
        return Redirect::to('/employee')->with('success','Role Changed');
           
    }



     public function register()
    {

      
        return View::make('employee.register');
    }


    public function postregister(Request $request)
    {

          $user = new User();
      
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'employee';
        $user->save();
        $last = DB::getPdo()->lastInsertId();


       
        $employee = new Employee();
        $employee->user_id =  $last;
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->addressline = $request->addressline;
        $employee->town = $request->town;
        $employee->zipcode = $request->zipcode;
        $employee->phone = $request->phone;
        $employee->img_path = 'employee.jpg';
        $employee->save();
         Auth::login($user);
        return Redirect::to('/home');
       
    }



}

