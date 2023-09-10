
@extends('layouts.base')
{{-- <div style="background-image: url('{{url('/images/backgrounds/bgwhite.jpg')}}');"> --}}
@section('body')
 <link href="{{ url('/src/css/app.css') }}" rel="stylesheet">



{{-- <div  style="background-image: url('{{url('/images/backgrounds/bg1.jpg')}}');"> --}}




<div align="left"><h2>Checkup your Pet</h2></div>
<div class="d-flex justify-content-center align-items-center container ">
<ul class="errors">

 </ul>

  {{-- 
  <div  style="background-image: url('{{url('/images/backgrounds/bgwhite.jpeg')}}');"> --}}
  <form method="post" action="{{Url('postconsult')}}" enctype="multipart/form-data" >
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



    <div class="form-group"> 
    <label for="disease_id"> Disease  </label>
    <select name="disease_id" id="disease_id" class="form-select" >
      @foreach($diseases  as $disease)
        <option value="{{$disease->id}}">{{$disease->name}}</option>
      @endforeach
    </select>
  </div>
  @if($errors->has('disease_id'))
      <small>{{ $errors->first('disease_id') }}</small>
    @endif















    

  <div class="form-group"> 
    <label for="comments" class="control-label">Comments</label>
    <textarea type="textarea" class="form-control" id="comments" name="comments" value="{{old('{{-- comment --}}')}}" ></textarea> 
  </div>
   @if($errors->has('comment'))
      <small>{{ $errors->first('comment') }}</small>
    @endif


    



<center><button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>  <center>   
</div>
</div>
</form> 

@endsection