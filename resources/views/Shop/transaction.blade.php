@extends('layouts.base')
@section('body')
  <div class="container">
   
    @if ( Session::has('success'))
      <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
      </div><br />
     @endif
  </div>

   
 

<center><h3>Transactions</h3></center>



  <div >
    {{$html->table(['class' => 'table table-bordered table-striped table-hover '], true)}}
  </div>



        
</div
  @push('scripts')
    {{$html->scripts()}}
  @endpush
@endsection