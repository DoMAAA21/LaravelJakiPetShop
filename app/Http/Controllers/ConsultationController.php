<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\User;
use View;
use Redirect;
use DB;
use Mail;

use App\Mail\ConsultMail;
use Event;
use App\Events\ConsultSendMail;
class ConsultationController extends Controller
{
    public function index()
    {
       
        $diseases = DB::table('diseases')->select()->orderBy('id', 'ASC')
            ->get();
        $customer = Customer::where('user_id',auth()->id())->select('id')->first();
         $pets = Pet::where('owner_id', $customer->id)->get();
           
       
        return View::make('consultation.index',compact('pets','diseases'));
    }

     public function store(Request $request)
    {


        DB::beginTransaction();

        try {

        $pet_id =$request->pet_id;
        $pet = Pet::find( $pet_id);



            $pet->consult()->attach([$request->pet_id => ['comments' => $request->comments, 'date' => now(),'disease_id' => $request->disease_id ]]);
        } 
    
    catch (\Throwable $e) {
    DB::rollback();
    throw $e;


    return redirect()->route('/consultation')->with('error', $e->getMessage());
    }

    DB::commit();


    


    $pet = Pet::with('customer')->where('id',$request->pet_id)->select('*')->first();

   

   
$customer = Customer::with('pet')->where('id',$pet->owner_id)->select('*')->first();

 $user = User::where('id',$customer->user_id)->first();

   $id =  DB::table('checkup_infos')->max('id');
   $disease  =  DB::table('diseases')->where('id',$request->disease_id)->first();

      $data = array(
            'fname'   => $customer->fname,
            'lname'   =>   $customer->lname,
            'title'   =>  $customer->title,
            'addressline'   =>  $customer->addressline,
            'town'   =>  $customer->town,
            'zipcode'   =>  $customer->zipcode,
            'phone'   =>  $customer->phone,
            'title'   =>  $customer->title,
            'pet_name'   =>  $pet->pet_name,
            'gender'   =>  $pet->gender,
            'email'   =>  $user->email,
            'orderid'   =>  $id,
            'comment'   =>  $request->comments,
            'disease'  => $disease->name,
            'email' => $user->email
        );
        
        Event::dispatch(new ConsultSendMail($data));
       
       
    return View::make('consultation.success');



    }
}
