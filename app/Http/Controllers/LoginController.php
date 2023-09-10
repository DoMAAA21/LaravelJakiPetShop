<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\User;
use DB;
use App\Mail\ContactMail;
use Event;
use App\Events\SendMail;
use Mail;
use Redirect;
use View;

class LoginController extends Controller
{
    public function getSignup(){
        return view('login.register');
    }
    public function postSignup(Request $request){

        //dd($request->all());
        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required| min:4|confirmed'
        ]);

        $user = new User;
         $user->email = $request->email;
          $user->password = bcrypt($request->password);
          $user->role = 'customer';
                $user->save();
                $lid = DB::getPdo()->lastInsertId();

        $info = new Customer([
        'title' => $request->title,
        'user_id' => $lid,
         'lname' => $request->lname,
         'fname' => $request->fname,
         'addressline' => $request->address,
         'town' => $request->town,
         'zipcode' => $request->zipcode,
         'phone' => $request->phone,
            
               
        ]);
        $info->save();
        

     
        
          
         Auth::login($user);
         
        $data = array(
            'sender'   => $request->fname.' '.$request->fname,
            'title'   =>  $request->title,
            'email'   =>   $request->email
            
        );
        Event::dispatch(new SendMail($data));
      return Redirect::to('home');
     }

    
    public function getProfile(){
 
        return view('login.profile');
    }
    public function getLogout(){
        Auth::logout();
        return redirect('/signin');
    }
    public function getSignin(){
        return view('login.login');
    }
    public function postSignin(Request $request){
        $this->validate($request, [
            'email' => 'email| required',
            'password' => 'required| min:4'
        ]);
         if(Auth::attempt(['email' => $request->input('email'),'password' => $request->password])){

            $r  = Auth::user()->role;
            // dd($r);
                if($r == 'customer')
            {


                $customer = Customer::where('user_id',auth()->id())->first();
            
                 return View::make('customer.profile',compact('customer'));
            }
            else if($r == 'employee')
            {
               
                return Redirect::to('home');
            }
            else
            {
                 return Redirect::to('home');
            }

            
        } else{
            return redirect()->back();
        };
     }

}
