@extends('layouts.base')
@section('body')
 <div class="container">
      <h2>Edit Employee</h2><br/>
{{ Form::model($employee,['route' => ['employee.update',$employee->id],'method'=>'POST','enctype'=>'multipart/form-data']) }}
       

<div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('lname') is-invalid @enderror" name="title" value="{{ $employee->title }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


           <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ $employee->fname }}" required autocomplete="lname" autofocus>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


          <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ $employee->lname }}" required autocomplete="lname" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



           <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Addressline') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('lname') is-invalid @enderror" name="addressline" value="{{ $employee->addressline }}" required autocomplete="lname" autofocus>

                                @error('addressline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

         

           <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Town') }}</label>

                            <div class="col-md-6">
                                <input id="town" type="text" class="form-control @error('lname') is-invalid @enderror" name="town" value="{{ $employee->town }}" required autocomplete="town" autofocus>

                                @error('town')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


          <div class="row mb-3">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-end">{{ __('Zipcode') }}</label>

                            <div class="col-md-6">
                                <input id="zipcode" type="text" class="form-control @error('lname') is-invalid @enderror" name="zipcode" value="{{$employee->zipcode }}" required autocomplete="zipcode" autofocus>

                                @error('zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

         <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('lname') is-invalid @enderror" name="phone" value="{{ $employee->phone }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


           <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
 <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('lname') }}" required autocomplete="password" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control @error('password') is-invalid @enderror" name="image" required autocomplete="password" autofocus>

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