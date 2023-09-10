@extends('layouts.master')

@section('title')
    Groom your Pet
@endsection
 @section('content')
   @foreach ($services->chunk(2) as $serviceChunk)
        <div class="row">
            @foreach ($serviceChunk as $service)
                <div class="col-sm-6 col-md-4">
                  <div class="thumbnail">

                    @php
                   
    $image = DB::table('cuts_images')->select('img_path')->where('service_id', $service->id)->first();

    

@endphp
                    <img src="{{ asset('/images/'.$image->img_path) }}" alt="..." width = "200" height="200" class="img-responsive">
                    <div class="caption">
                           <h3>{{ $service->title }}<span>${{ $service->price }}</span></h3>
                      <p>{{ $service->description }}</p>
                      <div class="clearfix">
                           <a href="{{ route('item.addToCart', ['id'=>$service->id]) }}" class="btn btn-primary"  role="button"><i class="fas fa-cart-plus"></i> Add to Cart</a> <a href="#" class="btn btn-default pull-right" role="button">

                            <i class="fas fa-info"></i> More Info</a>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
    @endforeach
@endsection 