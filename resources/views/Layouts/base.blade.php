<!doctype html>
 <html lang="en">
 <head>

 <meta charset="UTF-8">
 <title></title>
 <body>
      <br><br><br><br><br>   
  @include('partials.header')
   {{-- <div class="row">@include('layouts.nav')</div> --}}

 @yield('body')
 @include('Layouts.header')

 </head>
 <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    @stack('scripts')
 <body>

 </body>
 </html>