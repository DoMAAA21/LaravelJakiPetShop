<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use View;
use Redirect;
use DB;
class CommentController extends Controller
{
     public function index()
    {
        


      
      
         $services = DB::table('services')->select()->orderBy('id', 'ASC')
            ->get();

            

               
         
       
        return View::make('comment.index',compact('services'));
    }



     public function comment($id)
    {
        

            //dd($id);

        $customers = Customer::all();
        $services = DB::table('services')->select()->where('id',$id)->get();
        $image = DB::table('services')->join('cuts_images','services.id','cuts_images.service_id')->select('services.id','services.name','services.price','services.description','img_path')->where('services.id',$id)->orderBy('id', 'ASC')
             ->get();
        $comments = DB::table('comments')
        // ->join('customers','comments.customer_id','customers.id')
        ->select()->where('service_id',$id)->get();
       
        return View::make('comment.create',compact('customers','services','comments','image'));
    }


    public function store(Request $request)
    {
        

    $cus = Customer::where('user_id',Auth()->id())->first();
        $string = app('profanityFilter')->replaceWith('#')->replaceFullWords(false)->filter($request->comments);
            //dd($request->all());

        
        DB::table('comments')->insert([
        'guest_name' => $cus->fname.' '.$cus->lname ,
        'service_id' => $request->service_id,
         'comments'  =>  $string,
         'date' => now()
        ]);

         return redirect()->back();

        //return View::make('comment.success');
    }
}
