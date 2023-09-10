
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>JAKI PETSHOP</title>
    
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->


     <link rel="stylesheet" href="{{ url('/assets/fontawesome.css') }}"> 
    <link rel="stylesheet" href="{{ url('/assets/templatemo-grad-school.css') }}">
   <link rel="stylesheet" href="{{ url('/assets/owl.css') }}"> 

    <link rel="stylesheet" href="{{ url('/assets/lightbox.css') }}"> 
    

  </head>


   
  <!--header-->
  <header class="main-header clearfix" role="header">
    <div class="logo">
      <a href="#"><em>JAKI</em> Petshop</a>
    </div>
    <a href="#menu" class="menu-link"><i class="fa fa-bars"></i></a>
    <nav id="menu" class="main-nav" role="navigation">
      <ul class="main-menu">
        
         @if(Auth::check())

              @if(Auth::user()->role == 'customer')
        <li><a href="{{ url('/grooms') }}">Shop</a></li>
        <li><a href="{{ Url('/consultation') }} ">Consult</a></li>
         <li><a href="{{ Url('comment') }}">About</a></li>
              @else
              <li class="has-submenu"><a href="#section2">Portal</a>
          <ul class="sub-menu">
            <li><a href=" {{ route('customer') }}">Customers</a></li>
            <li><a href="{{ route('pets.all') }}">Pets</a></li>
            <li><a href="{{ route('employee') }}">Employee</a></li>
            <li><a href="{{ route('service') }}" >Pet Grooming</a></li>
            </ul>
        </li>
              @endif
              @endif     

        
            
            
           
            
         @guest
        
        @else
        <li class="has-submenu"><a href="#section2">Datas</a>
          <ul class="sub-menu">
            <li><a href=" {{url('search/pethistory') }}">Pet History</a></li>
            <li><a href="{{ url('search/customerhistory') }}">Customer History</a></li>   
             <li><a href=" {{url('/diseasechart') }}">Disease Chart</a></li>
            <li><a href="{{ url('groomingchart') }}">Grooming Chart</a></li>    
          </ul>
        </li>
        @endguest

              
       

       



  @if(Auth::check())

              @if(Auth::user()->role == 'customer')

          <li><a href="{{ route('pet') }}">My Pets</a></li>
            <a href="{{ route('item.shoppingCart') }}">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Shopping Cart
                        <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                    </a>
        @else
         <li><a href="{{ Url('transactions') }} ">Transactions</a></li>
        @endif
        @endif
           @if (Auth::check())
        
                 <li class="has-submenu"><a href="#section2">{{ Auth::user()->email}}</a>
                  <ul class="sub-menu">

                    @if(Auth::check())

              @if(Auth::user()->role == 'customer')
                      
                    
                  <li><a href="{{ route('profile', ['id'=>Auth::user()->id])  }}">Edit Profile</a></li>
                  @else
                  @endif
                  @endif
                
                <li><a href="{{ route('login.logout') }}">Logout</a></li>


                </ul>
                </li>
            @else
              <li class="has-submenu"><a href="#section2">User Management</a>
                  <ul class="sub-menu">
              <li><a href="{{ route('login.signup') }}" >Signup</a></li>
              <li><a href="{{ route('employee.register') }}">Employee Signup</a></li>
              <li><a href="{{ route('login.signin') }}">Signin</a></li>


              </ul>
              </li>
            @endif
          



        
      
  </header>

