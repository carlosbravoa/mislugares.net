<html>
	<head>
		
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
<link rel="apple-touch-icon" href="touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
<link rel="apple-touch-startup-image" href="/openapp.png">
<title>Mis Lugares</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    	<![endif]-->
    	
        <style type="text/css">>
    	/* Sticky footer styles
-------------------------------------------------- */
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  /*position: absolute;*/
  padding-top:10px;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  background-color: #f5f5f5;
}
.listacheck {margin-left:20px; margin-bottom:30px;}
    	</style>
    	
    	@section('encabezado')
    	
    	@show
	</head>
	<body>
	@section('dp_body')
	
	@show
        
		<div class="navbar navbar-inverse" role="navigation">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="navbar-brand" href="/inicio">Mis Lugares</a>
		        </div>
		        <div class="collapse navbar-collapse">
		          <ul class="nav navbar-nav">
		            <li class="{{Request::path() == 'lugares' ? 'active' : '';}}"><a href="/lugares">Ver</a></li>
		            <li class="{{Request::path() == 'agregar' ? 'active' : '';}}"><a href="/agregar">Agregar</a></li>
		            <li class="{{Request::path() == 'categorias' ? 'active' : '';}}"><a href="/categorias">Categorías</a></li>
		            <li class="{{Request::path() == 'contactos' ? 'active' : '';}}"><a href="/contactos">Contactos</a></li>
		           
                            @if (Auth::guest())
                            <li class="{{Request::path() == 'login' ? 'active' : '';}}"><a  id="loginlink" href="/login">Identificarse</a></li>
                            @else
                            <li class="{{Request::path() == 'logout' ? 'active' : '';}}"><a  id="loginlink" href="/logout">Cerrar sesión</a></li>
                            @endif
		          </ul>
		        </div><!--/.nav-collapse -->
		      </div>
		   <div class="container">   
		   
		   <div id="mensaje_estado">
		      @if (Session::has('mensaje_success'))
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        {{ Session::get('mensaje_success') }}</div>
@endif

@if (Session::has('mensaje_error'))
<div class="alert alert-danger alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        {{ Session::get('mensaje_error') }}</div>
@endif

@if (Session::has('mensaje_info'))
<div class="alert alert-info alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        {{ Session::get('mensaje_info') }}</div>
@endif

		</div>      
		<div class="principal">
			@yield('content')
		</div>
	</div>	
		<div class="footer">
		    <div class="container">
				<p class="text-muted">&copy; Carlos Bravo 2014</p>
			</div>
		</div>
		
		
	
		<!-- bootstrap y jquery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    	@section('final')
    	
    	@show
    	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55312127-1', 'auto');
  ga('send', 'pageview');

</script>

	</body>
</html>	
