@extends('layouts.base')
@section('body')
 <div class="container">
      <h2>Edit Pet Information</h2><br/>
{{ Form::model($service,['route' => ['service.update',$service->id],'method'=>'POST','enctype'=>'multipart/form-data']) }}
       




           <div class="row mb-3">
                            <label for="pet_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('pet_name') is-invalid @enderror" name="name" value="{{ $service->name }}" required autocomplete="lname" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                            


                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('description') }}</label>

                            <div class="col-md-6">
                                <input id="pet_age" type="text" class="form-control @error('pet_age') is-invalid @enderror" name="description" value="{{ $service->description }}" required autocomplete="pet_age" autofocus>

                                @error('pet_age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="pet_age" type="number" step ="0.1"class="form-control @error('pet_age') is-invalid @enderror" name="price" value="{{ $service->price}}" required autocomplete="pet_age" autofocus>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
          


                        




                        



                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class=" form-control @error('image') is-invalid @enderror" name="image[]" required autocomplete="owner" autofocus  multiple >

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