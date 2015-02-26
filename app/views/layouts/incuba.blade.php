<!DOCTYPE html>
<head>
    <!-- Google Web Fonts================================================== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,300italic,400,700|Julius+Sans+One|Roboto+Condensed:300,400'
          rel='stylesheet' type='text/css'>
    <!-- Basic Page Needs================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>IncubaM&aacute;s | Incubadora de Negocios</title>
    <meta name="description" content="Incubadora de Negocios">
    <meta name="author" content="Incubamas">
    <!-- Favicons================================================== -->
    <link rel="shortcut icon" href="{{ URL::asset('accio/images/favicon.ico') }}">
    <!-- Mobile Specific Metas================================================== -->
    <!-- CSS================================================== -->
    <link rel="stylesheet" href="{{ URL::asset('accio/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/css/grid.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/css/layout.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/css/fontello.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/css/animation.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/css/footer.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/js/layerslider/css/layerslider.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/js/flexslider/flexslider.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/js/fancybox/jquery.fancybox.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/plugins/modal/css/component.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('accio/js/layerslider/skins/accio/skin.css') }}"/>
    <!-- MLML5 Shiv================================================== -->
    {{ HTML::script('accio/js/jquery.modernizr.js') }}
</head>

<body data-spy="scroll" data-target="#navigation" class="home">

@section('menu')
    @show
    <div id="wrapper">
        @section('contenido')
            @show
            <footer id="footer">
                <div class="wrapper bg_black" style="position:relative; z-index:9;">
                    <div class="container_12">
                        <article class="grid_5 txt11" style="padding-top:9px;">
                            &nbsp;&copy;&nbsp; 2015
                            <span class="color_green">Incubamas</span>
                            <a target="_blank" href="{{url('sistema')}}" title="Sistema">
                                {{HTML::image('accio/images/favicon.ico') }}
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