@extends('layouts.base')
@section('body')
<div class="container">
   {{-- {{dd($diseaseChart)}}  --}}.
   <center>
  <div class="row">
    <div  class="col-sm-6 col-md-6">
        <h1>Disease Chart</h1>
    @if(empty($diseaseChart))
        <div ></div>
    @else
          <div>{!! $diseaseChart->container() !!}</div>
        {!! $diseaseChart->script() !!}
     @endif   
    </div>

    </div>
</center>
</div>
@endsection