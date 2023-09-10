@extends('layouts.base')
@section('body')
<center>
<div class="container">
    <div class="row">
        <div  class="text-center" class="col-md-4 col-md-offset-4">
            <h1> Profile Info</h1>
           
            <td><img src="{{ asset('/images/'.$customer->img_path) }}" width="200" height="200"/></td>
     
            


            <div class="form-group">
         <h3>  <strong> <label for=""></label>
           <td>{{$customer->lname.', '.$customer->fname}}</td>
            </div></strong></h3>
         
            <div class="form-group mb-3">
          <strong>  <label for="">Address : </label> </strong>
            <td>{{$customer->addressline}}</td>
             </div>
            <div class="form-group mb-3">
         <strong>  <label for="">Town : </label> </strong>
           <td>{{$customer->town}}</td>
            </div>       
            <div class="form-group mb-3">
          <strong>  <label for="">Zipcode : </label> </strong>
            <td>{{$customer->zipcode}}</td>
            </div>
            <div class="form-group mb-3">
         <strong>   <label for="">Phone</label> </strong>
            <td>{{$customer->phone}}</td>
           </div>
          
        </div>
     </div>
       </div>
   </center>
@endsection

