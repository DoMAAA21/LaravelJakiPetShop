@extends('layouts.base')
@section('body')
 <div class="container">
      <h2>Edit Transaction Status</h2><br/>
{{ Form::model($transaction,['route' => ['transaction.update',$transaction->id],'method'=>'POST','enctype'=>'multipart/form-data']) }}
       

        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <select name="status" id="status" class="form-select" >
      <option value="Pending">Pending</option>
  <option value="Paid">Paid</option>
  

  
    </select>

                                @error('status')
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