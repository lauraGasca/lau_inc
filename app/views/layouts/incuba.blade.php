<!DOCTYPE html>
<!--[if lte IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if lte IE 10]><html class="ie10 no-js" lang="en"><![endif]-->
<!--[if !IE]>--><html class="not-ie no-js" lang="en"><!--<![endif]-->

	<head>
		<!-- Google Web Fonts
  ================================================== -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,300italic,400,700|Julius+Sans+One|Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
	
	<!-- Basic Page Needs================================================== -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>IncubaM&aacute;s | Incubadora de Negocios</title>	
		<meta name="description" content="">
		<meta name="author" content="">
		<!-- Favicons================================================== -->
		<link rel="shortcut icon" href="{{ URL::asset('accio/images/favicon.ico') }}">
		<!-- Mobile Specific Metas================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!-- CSS================================================== -->
		<link rel="stylesheet" href="{{ URL::asset('accio/css/style.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/css/grid.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/css/layout.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/css/fontello.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/css/animation.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/css/footer.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/js/layerslider/css/layerslider.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/js/flexslider/flexslider.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/js/fancybox/jquery.fancybox.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/plugins/modal/css/component.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('accio/js/layerslider/skins/accio/skin.css') }}" />
		<!-- MLML5 Shiv
		================================================== -->
		<script src="{{ URL::asset('accio/js/jquery.modernizr.js') }}"></script>
	</head>

	<body data-spy="scroll" data-target="#navigation" class="home">		
			
		<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->
		@section('menu')
		@show
		<!-- - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - -->
		
		
		<!-- - - - - - - - - - - - - - Wrapper - - - - - - - - - - - - - - - - -->
		<div id="wrapper">
						
			@section('contenido')
			@show
			
			<!-- - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->
			<footer id="footer">
							
				<div class="wrapper bg_black" style="position:relative; z-index:9;">
					<div class="container_12">
						<article class="grid_5 txt11" style="padding-top:9px;">
							&nbsp;&copy;&nbsp;  2014
							<span class="color_green">Incubamas</span>
							<a target="_blank" href="{{url('sistema')}}" title="Sistema">
								<img src="{{ URL::asset('accio/images/favicon.ico')}}" alt="">
							</a>
							All Rights Reserved.
						</article>
						<article class="grid_5last-col">
							<div class="social">
								<a target="_blank" href="https://twitter.com/IncubaMas" title="Twitter">
									<img src="{{ URL::asset('accio/images/footer/twitter.png')}}" alt="">
								</a>
								<a target="_blank" href="https://es-es.facebook.com/IncubaMas" title="Facebook">
									<img src="{{ URL::asset('accio/images/footer/facebook.png')}}" alt="">
								</a>
								<a target="_blank" href="http://beta.incubamas.com/panel.php" title="Sistema">
									<img src="{{ URL::asset('accio/images/footer/incubamas.png')}}" alt="">
								</a>
							</div>
						</article>
					</div>
				</div>
			</footer><!--/ #footer-->
			<!-- - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - -->
			
		</div><!--/ #wrapper-->
		
		<!-- - - - - - - - - - - - - end Wrapper - - - - - - - - - - - - - - - -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="{{ URL::asset('accio/js/respond.min.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.queryloader2.js') }}"></script>
		<script src="{{ URL::asset('accio/js/waypoints.min.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.easing.1.3.min.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.cycle.all.min.js') }}"></script>
		<script src="{{ URL::asset('accio/js/layerslider/js/layerslider.transitions.js') }}"></script>
		<script src="{{ URL::asset('accio/js/layerslider/js/layerslider.kreaturamedia.jquery.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.mixitup.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.mb.YTPlayer.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.smoothscroll.js') }}"></script>
		<script src="{{ URL::asset('accio/js/flexslider/jquery.flexslider.js') }}"></script>
		<script src="{{ URL::asset('accio/js/fancybox/jquery.fancybox.pack.js') }}"></script>
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script src="{{ URL::asset('accio/js/jquery.gmap.min.js') }}"></script>
		<script src="{{ URL::asset('accio/twitter/jquery.tweet.js') }}"></script>
		<script src="{{ URL::asset('accio/js/jquery.touchswipe.min.js') }}"></script>
		<script src="{{ URL::asset('accio/js/config.js') }}"></script>
		<script src="{{ URL::asset('accio/js/custom.js') }}"></script><!--arranca todos los efectos-->	
		<script src="{{ URL::asset('accio/plugins/modal/js/classie.js') }}"></script>
		<script src="{{ URL::asset('accio/plugins/modal/js/modalEffects.js') }}"></script>
	</body>
</html>