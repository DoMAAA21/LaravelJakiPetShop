    
@extends('layouts.base')

@section('body')


 <link href="{{ url('/src/css/app.css') }}" rel="stylesheet">
{{-- <link href="{{ url('/assets/feedback.css') }}" rel="stylesheet"> --}}
 
<div class="container">
<div align="left"><h2>FeedBacks</h2></div>
<div class="d-flex justify-content-center align-items-center container ">
<ul class="errors">

 </ul>









<form method="post" action="{{url('comment/store')}}" enctype="multipart/form-data" >

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
     @foreach($services as $serv)
     <center><h1> Service  Info</h1></center>
 <center> <h2><label for=""> {{ $serv->name }}  </label></h2></center>
@endforeach

 {{-- @foreach ($image->chunk(5) as $imageChunk)
        <div class="row">
            @foreach ($imageChunk as $img)
                <div class="col-sm-6 col-md-4">
                  <div class="thumbnail">
                    <img src="{{asset('/images/'.$img->img_path) }}" alt="..." width="300" height="300" class="img-responsive">
                    <div class="caption">
                           <h3><span></span></h3>
                      <p></p>
                      <div class="clearfix">
                            

                            
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
    @endforeach --}}






    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">

        <div class="carousel-inner">

@foreach($image as $img)

            <div class="carousel-item active">
                <img src="{{ asset('images/'.$img->img_path) }}" class="d-block w-100" alt="..." width="200" height="200">
                <div class="carousel-caption d-none d-md-block">
                    <div class="custom-carousel-content">
                        <h1>
                            <span>{{-- {{ $groom->title }} --}}</span>
                        </h1>
                        <p>
                            {{-- {{ $groom->description }} --}}
                        </p>
                        <div>
                            <a href="#" class="btn btn-slider">
                              
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
@endforeach

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

  











 
 
  
   


    <h2> Reviews/Comments </h2>
 
{{--   @if(!empty($comments)) --}}
  @foreach($comments as $com)
   

 
                <div class="comment mt-4 text-justify float-left"> 
                    <h4>{{$com->guest_name}}</h4> <span>{{$com->date}}</span> <br>
                    <p>{{$com->comments}}</p>
                </div>



  @endforeach
  




   @foreach($services as $serv)
  <input type="hidden" name="service_id" value="{{ $serv->id }}">
  @endforeach


    <div class="form-group"> 
    <label for="comments" class="control-label">Comments</label>
   <input type="text" class="form-control " id="comments" name="comments"  ></text> 
  </div>
   @if($errors->has('comments'))
      <small>{{ $errors->first('comments') }}</small>
    @endif

<br>

    <center><button type="submit" class="btn btn-primary">Add Comment</button>
  <a href="{{url('comment')}}" class="btn btn-default" role="button">Back</a>
  </div>  <center>   
</div>
</div>
</form> 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

@endsection