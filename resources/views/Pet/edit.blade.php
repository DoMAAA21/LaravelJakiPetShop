@extends('layouts.base')
@section('body')
 <div class="container">
      <h2>Edit Pet Information</h2><br/>
{{ Form::model($pet,['route' => ['pet.update',$pet->id],'method'=>'POST','enctype'=>'multipart/form-data']) }}
       
{{-- 
<input id="title" type="hidden" class="form-control" value = {{$customer->id}}>
 --}}
<div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Breed') }}</label>

                            <div class="col-md-6">
                                <select name="breed_id" id="breeds" class="form-select" >
      @foreach($breeds as $breed)
        {{-- <option value="{{$breed->id}}">{{$breed->description}}</option> --}}


        <option value="{{ $breed->id }}" {{ $breed->id == $breed->id ? 'selected' : '' }}>{{ $breed->description }}</option>
      @endforeach
    </select>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


           <div class="row mb-3">
                            <label for="pet_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="pet_name" type="text" class="form-control @error('pet_name') is-invalid @enderror" name="pet_name" value="{{ $pet->pet_name }}" required autocomplete="lname" autofocus>

                                @error('pet_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                            <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <select name="gender" id="breeds" class="form-select" >
      <option value="Male">Male</option>
  <option value="Female">Female</option>
  
    </select>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="pet_age" type="number" class="form-control @error('pet_age') is-invalid @enderror" name="pet_age" value="{{ $pet->pet_age }}" required autocomplete="pet_age" autofocus>

                                @error('pet_age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
          


                        







                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control @error('image') is-invalid @enderror" name="image" required autocomplete="owner" autofocus >

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




</div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
     {!! Form::close() !!}
    </div>
@endsection