@extends('layouts.base')

@section('body')

<html>
<head>
<title>Log In</title>
<!-- Custom Theme files -->
<link href="{{ url('/assets/login.css') }}" rel="stylesheet" type="text/css" media="all"/>
<!-- for-mobile-apps -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="Flat Login Form Widget Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- //for-mobile-apps -->
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Signika:400,600' rel='stylesheet' type='text/css'>
<!--google fonts-->
</head>
<body>
<!--header start here-->
<h1>Please Login In</h1>
<div class="header agile">
	<div class="wrap">
		<div class="login-main wthree">
			<div class="login">
			<h3>Login</h3>
			<form action="{{ route('login.signin') }}" method="post">
				 {{ csrf_field() }}
				<input type="text" placeholder="Email" required="" name="email">

				
				<input type="password" placeholder="Password" name="password">


				<input type="submit" value="Sign In">
			</form>
			<div class="clear"> </div>
				<h4><a href="#"> Forgot Your Password?</a></h4>
				<h5>(Or)</h5>
			
					<h4><a  href="{{ route('login.signup') }}">Sign Up</a></h4>
					
		
			</div>
			
		</div>
	</div>
</div>
<!--header end here-->
<!--copy rights end here-->
<div class="copy-rights w3l">		 	
	<p> ACME Login Form. All Rights Reserved | Design by  <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>		 	
</div>
<!--copyrights start here-->

</body>
</html>

@endsection