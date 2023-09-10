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


<div class="col-xs-6">
       <form method="post" enctype="multipart/form-data" action="{{ url('/pet/import') }}">
          @csrf
        <input type="file" id="uploadName" name="pet_upload" required>
        
    </div>
  
    @error('album_upload')
 <small>{{ $message }}</small>
    @enderror
         <button type="submit" class="btn btn-info btn-primary " >Import Excel File</button>
         </form> 
  </div>





  <div >
    {{$dataTable->table(['class' => 'table table-bordered table-striped table-hover '], true)}}
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
        <form  method="POST" enctype="multipart/form-data" action="{{url('pet')}}">
        {{csrf_field()}}

<div class="card pmd-card bg-primary text-dark">

    <div class="card-body"> 
        <!-- Regulat Input With Floating Label -->



        <div class="form-group pmd-textfield pmd-textfield-floating-label">
            <label for="inverse_regularfloating">Pet Name</label>
            <input id="inverse_regularfloating" class="form-control" type="text" name = "name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
             @enderror
        </div>
      

     


      
            <label for="inverse_regularfloating" >Breed</label>
              <select name="breed" id="breeds" class="dropdown-toggle"   style="width:350px;height:40px;"> >
            <option value="Komondor">Komondor</option>
            <option value="Bichon Frise">Bichon Frise</option>
            <option value="Sheep Dog">Sheep Dog</option>
            <option value="Main Coon">Main Coon</option>
             <option value="Ragdoll">Ragdoll</option>
  
                 </select>
             @error('breed')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
             @enderror
      

            </div>
       

        <div class="form-group pmd-textfield pmd-textfield-floating-label">
            <label for="inverse_regularfloating">Sex   &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</label>
              <select name="sex" id="breeds" class="form-select" style="width:350px;height:40px;">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
  
                 </select>
             @error('sex')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
             @enderror
        </div>

         

        <div class="form-group pmd-textfield pmd-textfield-floating-label">
            <label for="inverse_regularfloating">Age</label>
            <input id="inverse_regularfloating" class="form-control" type="number" name = "age" class="form-control @error('age') is-invalid @enderror"  value="{{ old('age') }}" required autocomplete="age" autofocus>
             @error('age')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
             @enderror
        </div>


          <div class="form-group pmd-textfield pmd-textfield-floating-label">
            <label for="inverse_regularfloating">Image</label>
            <input id="inverse_regularfloating" class="form-control" type="file" name = "image" class="form-control @error('image') is-invalid @enderror"  value="{{ old('image') }}" required autocomplete="image" autofocus>
             @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
             @enderror
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
    {{$dataTable->scripts()}}
  @endpush
@endsection