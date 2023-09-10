@extends('layouts.base')
@section('body')

<div class="card pmd-card bg-dark text-white">
 <div class="container">
      <h2>Edit Role<br/>
{{ Form::model($employee,['route' => ['employee.admin/update',$employee->id],'method'=>'POST','enctype'=>'multipart/form-data']) }}
       






           <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select name="role" id="role">
  <option value="Employee">Employee</option>
  <option value="Groomer">Groomer</option>
  <option value="Veterinarian">Veterinarian</option>
  <option value="Admin">Admin</option>
</select>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
    </div>
@endsection