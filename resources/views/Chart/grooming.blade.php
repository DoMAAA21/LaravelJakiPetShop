@extends('layouts.base')
@section('body')
<div class="container">
   {{-- {{dd($diseaseChart)}}  --}}
  <div class="row">
    <div  class="col-sm-6 col-md-6">
        <h2>Demographics</h2>

        <div><button type="button" class="btn btn-sm" data-toggle="modal" data-target="#DateModal">
 Search Data From
</button></div>
       
    </div>
    @if(empty($groomingChart))
        <div ></div>
    @else
          <div>{!! $groomingChart->container() !!}</div>
        {!! $groomingChart->script() !!}
     @endif   
    </div>

    </div>

 
    <div class="modal" id="DateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
<div class="modal-header text-center">
            <center> <p class="modal-title w-100 font-weight-bold">Show Data Between</p></center>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    
        <form  method="POST" action="{{route('dashboard.groomingtimepick')}}">
        {{csrf_field()}}
          
        






        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="date" class="form-control @error('startdate') is-invalid @enderror" name="startdate" value="{{ old('startdate') }}" required autocomplete="startdate" autofocus>

                                @error('startdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="date" class="form-control @error('enddate') is-invalid @enderror" name="enddate" value="{{ old('enddate') }}" required autocomplete="enddate" autofocus>

                                @error('enddate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

<div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Save</button>
            <button class="btn btn-light" data-dismiss="modal">Cancel</button>
          </div>
</div>

<script type="text/javascript">
        $(function() {
           $('#CalendarDateTime').datetimepicker();
        });
    </script> 
@endsection