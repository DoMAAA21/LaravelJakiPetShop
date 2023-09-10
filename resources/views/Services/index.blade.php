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
 <div><button type="button" class="btn btn-success" data-toggle="modal" data-target="#ServiceModal">
  Create New Service
</button></div>
<div class="col-xs-6">
       <form method="post" enctype="multipart/form-data" action="{{ url('/service/import') }}">
          @csrf
        <input type="file" id="uploadName" name="service_upload" required>
        
    </div>
  
    @error('pet_upload')
 <small>{{ $message }}</small>
    @enderror
         <button type="submit" class="btn btn-info btn-primary " >Import Excel File</button>
         </form> 
  </div>





  <div >
    {{$html->table(['class' => 'table table-bordered table-striped table-hover '], true)}}
  </div>
<div class="modal" id="ServiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
<div class="modal-header text-center">
          <p class="modal-title w-100 font-weight-bold">Add New Service</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST" action="{{route('service.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
          





                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __(' Service Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"   value="{{ old('name') }}" required autocomplete="name" autofocus >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="description" value="{{ old('name') }}" required autocomplete="description" autofocus>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="decimal" type="number" step=".01" class="form-control @error('name') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="description" autofocus>

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