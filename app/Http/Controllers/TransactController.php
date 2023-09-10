<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use View;
use Redirect;
use Validator;
use DB;
use Carbon;
use Session;
use Auth;
use App\Models\Service;
use App\Models\Pet;
use App\Models\Customer;
use PDF;
use Yajra\DataTables\Html\Builder;
use App\DataTables\TransactionDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\DataTables;
class TransactController extends Controller
{
    public function Index(){
        //  $items = Pet::all();



        // $services = DB::table('services')->join('cuts_images','services.id','cuts_images.service_id')->groupBy('services.name')
        //     ->select(DB::raw('count(services.name) as total'),'services.name','cuts_images.img_path')->get()
        //     ;

            //dd($grooming);
      $services = Service::all();
        return view('shop.index', compact('services'));
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getAddToCart(Request $request,$id){

        //dd($id);
        $product = Service::find($id);
        $oldCart = Session::has('cart') ? $request->session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
        Session::put('cart', $cart);
        $request->session()->save();
       return redirect()->back();
    }

    public function getRemoveItem($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
         return redirect()->route('item.shoppingCart');
    }


     public function reduceByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price']-= $this->items[$id]['item']['sell_price'];
        $this->totalQty --;
        $this->totalPrice -= $this->items[$id]['item']['sell_price'];
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }
    public function removeItem($id){
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }

   



    public function postCheckout(Request $request){

        //dd($request->all());
        if (!Session::has('cart')) {
            return redirect()->route('item.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $receiptmax = DB::table('groom_infos')->max('receipt_id');
        $receipt_id = $receiptmax + 1;
        try {
            DB::beginTransaction();
                      
            foreach($cart->items as $items){
            $id = $items['item']['id'];
                // dd($id);
                DB::table('groom_infos')->insert(

                    ['pet_id' => $request->pet_id,
                    'service_id' => $id, 
                    'receipt_id' => $receipt_id,
                     'date' => now(),
                     'status' => 'Pending'
                    ]

                    );

                  
               
            }
            // dd($order);
        }
catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // dd($order);
            return redirect()->route('item.shoppingCart')->with('error', $e->getMessage());
        }
        DB::commit();

        //dd(Session::get('cart'));
        Session::forget('cart');


        return redirect()->route('Item.receipt')->with('success','Successfully Purchased Your Products!!!');
    }


    public function pets()
    {
        
        $customer = Customer::where('user_id',Auth()->id())->first();
        $pets = Pet::where('owner_id',$customer->id)->get();


        return view::make('shop.pet',compact('pets'));
    }


    public function receipt()
    {
        $groom = DB::table('groom_infos')->max('receipt_id');
        $infos = DB::table('groom_infos')->max('id');
        $grooms = DB::table('groom_infos')
            ->join('pets','pet_id','pets.id')
            ->join('services','service_id','services.id')
            ->join('customers','pets.owner_id','customers.id')
            ->select('groom_infos.id AS gid','pets.id','services.id','services.name','services.price','pets.pet_name','pets.owner_id','customers.fname','customers.lname','groom_infos.date','customers.addressline','customers.town','customers.phone','customers.title','customers.zipcode','pets.created_at','pets.updated_at','pets.deleted_at','groom_infos.receipt_id')
            ->where('groom_infos.id',$infos)->get();


      
  
       $carts = DB::table('groom_infos')
            ->join('pets','pet_id','pets.id')
            ->join('services','service_id','services.id')
            ->join('customers','pets.owner_id','customers.id')
            ->select('groom_infos.id AS gid','pets.id','services.id','services.name','services.price','pets.pet_name','pets.owner_id','customers.fname','customers.lname','groom_infos.date','customers.addressline','customers.town','customers.phone','customers.title','customers.zipcode','pets.created_at','pets.updated_at','pets.deleted_at')
            ->where('groom_infos.receipt_id',$groom)->get();


            $total = DB::table('groom_infos')
            ->join('services','service_id','services.id')
            ->where('groom_infos.receipt_id',$groom)->sum('services.price');

         return View::make('shop.receipt',compact('grooms','carts','total'));
    }


    public function downloadPDF() {
        


        $groom = DB::table('groom_infos')->max('receipt_id');
        $infos = DB::table('groom_infos')->max('id');
        $grooms = DB::table('groom_infos')
            ->join('pets','pet_id','pets.id')
            ->join('services','service_id','services.id')
            ->join('customers','pets.owner_id','customers.id')
            ->select('groom_infos.id AS gid','pets.id','services.id','services.name','services.price','pets.pet_name','pets.owner_id','customers.fname','customers.lname','groom_infos.date','customers.addressline','customers.town','customers.phone','customers.zipcode','pets.created_at','pets.updated_at','pets.deleted_at','groom_infos.receipt_id')
            ->where('groom_infos.id',$infos)->get();


      
  
       $carts = DB::table('groom_infos')
            ->join('pets','pet_id','pets.id')
            ->join('services','service_id','services.id')
            ->join('customers','pets.owner_id','customers.id')
            ->select('groom_infos.id AS gid','pets.id','services.id','services.name','services.price','pets.pet_name','pets.owner_id','customers.fname','customers.lname','groom_infos.date','customers.addressline','customers.town','customers.phone','customers.zipcode','pets.created_at','pets.updated_at','pets.deleted_at')
            ->where('groom_infos.receipt_id',$groom)->get();


            $total = DB::table('groom_infos')
            ->join('services','service_id','services.id')
            ->where('groom_infos.receipt_id',$groom)->sum('services.price');






        $pdf = PDF::loadView('pdf', compact('grooms','carts','total'));
        
        return $pdf->download('receipt.pdf');
        }




         public function transaction(Builder $builder)
    {   


        $groominfo = DB::table('groom_infos')->join('services','service_id','services.id')->join('pets','pet_id','pets.id')->join('customers','pets.owner_id','customers.id')->select(DB::raw("CONCAT(customers.fname,' ' ,customers.lname) AS full_name"),'groom_infos.*','services.name','pets.pet_name');
      
        if (request()->ajax()) {
    
       
 return DataTables::of($groominfo)->order(function ($query) {
                     $query->orderBy('groom_infos.id', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('transact.transactionedit', $row->id). "
class=\"btn btn-warning\">Edit</a> <form action=". route('customer.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="DELETE">
                    
                      </form>';
            })
                    ->rawColumns(['action'])
                    ->toJson();
            }
           
        

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'name', 'name' => 'services.name', 'title' => 'Service'],

                ['data' => 'full_name', 'name' => 'customers.fname', 'title' => 'Customer'],
                
                ['data' => 'pet_name', 'name' => 'pets.pet_name', 'title' => 'Pet Name'],
                 ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
                  ['data' => 'date', 'name' => 'groom_infos.date', 'title' => 'Date'],
        

                
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

    return view('shop.transaction', compact('html'));

    }

    public function transactionedit($id)
    {       


           $transaction = DB::table('groom_infos')->where('id',$id)->first();

          // dd($transaction);
             return view('shop.editstatus', compact('transaction'));
    }


    public function transactionupdate(Request $request,$id)
    {


        //dd($id);
          DB::table('groom_infos')
    ->where('id', $id)
    ->update(['status' => $request->status]);


             return Redirect::to('transactions')->with('success','Transaction Updated');
    }





}
