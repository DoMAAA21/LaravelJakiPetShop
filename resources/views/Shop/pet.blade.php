
@extends('layouts.base')

@section('body')
 <link href="{{ url('/src/css/app.css') }}" rel="stylesheet">






<div class="container ">
    <div style="background-image: url('{{url('/images/backgrounds/bgwhite.jpg')}}');">
<div align="left"><h2>Choose Pet</h2></div>
<div class="d-flex justify-content-center align-items-center container ">
<ul class="errors">

 </ul>

  {{-- 
  <div  style="background-image: url('{{url('/images/backgrounds/bgwhite.jpeg')}}');"> --}}
  <form method="post" action="{{route('checkout')}}" enctype="multipart/form-data" >
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
<div class="form-group"> 
    <label for="pet_id"> Pet  </label>
    <select name="pet_id" id="pet_id" class="form-select" >
      @foreach($pets  as $pet)
        <option value="{{$pet->id}}">{{$pet->pet_name}}</option>
      @endforeach
    </select>
  </div>
  @if($errors->has('pet_id'))
      <small>{{ $errors->first('pet_id') }}</small>
    @endif



<center><button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>  <center>   
</div>
</div>
</form> 

@endsection