@extends('layouts.base')
@section('body')
  <div class="container">
    <br />
    @if ( Session::has('success'))
      <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
      </div><br />
     @endif
  </div>
 <div><button type="button" class="btn btn-success" data-toggle="modal" data-target="#PetModal">
  Create New Pet
</button></div>






  <div >
    {{$html->table(['class' => 'table table-bordered table-striped table-hover '], true)}}
  </div>
<div class="modal" id="PetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
<div class="modal-header text-center">
          <p class="modal-title w-100 font-weight-bold">Add New Pet</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST" action="{{route('pet.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
          


<div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Breed') }}</label>

                            <div class="col-md-6">
                                <select name="breed_id" id="breeds" class="form-select" >
      @foreach($breeds as $breed)
        <option value="{{$breed->id}}">{{$breed->description}}</option>
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
                            <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('Pet Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('pet_name') is-invalid @enderror" name="pet_name" value="{{ old('pet_name') }}" required autocomplete="pet_name" autofocus>

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
                                <input id="pet_age" type="number" class="form-control @error('pet_age') is-invalid @enderror" name="pet_age" value="{{ old('pet_age') }}" required autocomplete="pet_age" autofocus>

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
                                <input id="file" type="file" class="form-control @error('password') is-invalid @enderror" name="image" >

                                @error('image')
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
        </form>
</div>
    </div>
    
  </div>
  @push('scripts')
    {{$html->scripts()}}
  @endpush
@endsection