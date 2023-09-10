
@extends('layouts.base')
<div style="background-image: url('{{url('/images/backgrounds/bg1.jpg')}}');">
@section('body')
 <link href="{{ url('/src/css/app.css') }}" rel="stylesheet">

 
<div class="container">
<div align="left"><h2>Who are you?</h2></div>
<div class="d-flex justify-content-center align-items-center container ">
<ul class="errors">

 </ul>

 
  <div  style="background-image: url('{{url('/images/backgrounds/bgwhite.jpeg')}}');">
  <form method="post" action="{{url('/grooming')}}" enctype="multipart/form-data" >

  <input type="hidden" name="_token" value="{{ csrf_token() }}">

    
    <div class="form-group"> 
    <label for="owner_id"> Owner  </label>
    <select name="owner_id" id="owner_id" class="form-select" >
      @foreach($customers as $cst)
        <option value="{{$cst->id}}">{{$cst->fname.' '.$cst->lname}}</option>
      @endforeach
    </select>
  </div>
  @if($errors->has('owner_id'))
      <small>{{ $errors->first('owner_id') }}</small>
    @endif


     



    <center><button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>  <center>   
</div>
</div>
</form> 

@endsection