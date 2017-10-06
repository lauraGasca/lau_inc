<!DOCTYPE html>
    <head>
        <!-- Google Web Fonts================================================== -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:100,300,300italic,400,700|Julius+Sans+One|Roboto+Condensed:300,400" rel="stylesheet" type="text/css">
        <!-- Basic Page Needs================================================== -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>IncubaM&aacute;s | Incubadora de Negocios</title>
        <meta name="description" content="Incubadora de Negocios">
        <meta name="author" content="Incubamas">
        <!-- Favicons================================================== -->
        <link rel="shortcut icon" href="{{{asset('accio/images/favicon.ico')}}}">
        <!-- CSS================================================== -->
        {{ HTML::style('accio/css/style.css') }}
        {{ HTML::style('accio/css/grid.css') }}
        {{ HTML::style('accio/css/layout.css') }}
        {{ HTML::style('accio/css/fontello.css') }}
        {{ HTML::style('accio/css/animation.css') }}
        {{ HTML::style('accio/css/footer.css') }}
        {{ HTML::style('accio/js/layerslider/css/layerslider.css') }}
        {{ HTML::style('accio/js/flexslider/flexslider.css') }}
        {{ HTML::style('accio/js/fancybox/jquery.fancybox.css') }}
        {{ HTML::style('accio/plugins/modal/css/component.css') }}
        {{ HTML::style('accio/js/layerslider/skins/accio/skin.css') }}
        <!-- MLML5 Shiv================================================== -->
        {{ HTML::script('accio/js/jquery.modernizr.js') }}
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body data-spy="scroll" data-target="#navigation" class="home">
        <header id="header" @yield('menu-t')>
            <div class="@yield('menu-in')">
                <ul class="social-icons" style="display: inline-block; vertical-align: middle;">
                    <li class="twitter">
                        <a href="https://twitter.com/IncubaMas"><i class="icon-twitter"></i>Twitter</a>
                    </li>
                    <li class="facebook">
                        <a href="https://www.facebook.com/IncubaMas"><i class="icon-facebook"></i>Facebook</a>
                    </li><br/>
                    <li class="gplus">
                        <a href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i class="icon-gplus"></i>Gplus</a>
                    </li>
                    <li class="linkedin">
                        <a href="https://www.linkedin.com/company/incubam%C3%A1s"><i class="icon-linkedin"></i>LinkedIn</a>
                    </li>
                </ul>
                <h1 id="logo">
                    <a href="{{url('/')}}">{{HTML::image('accio/images/Logo footer.png','Incubamas') }}</a>
                </h1>
                <a id="responsive-nav-button" class="responsive-nav-button" href="#"></a>
                <nav id="navigation" class="navigation">
                    <ul>
                        <li @yield('inicio-c')><a @yield('inicio')>Inicio</a></li>
                        <li><a @yield('incuba')>Incuba</a></li>
                        <li @yield('blog-c')><a @yield('blog')>Noticias</a></li>
                        <li><a @yield('servicios')>Servicios</a></li>
                        <li @yield('casos-c')><a @yield('casos')>Emprendedores</a></li>
                        <li><a @yield('convocatorias')>Convocatorias</a></li>
                        <li><a @yield('contacto')>Cont&aacute;ctanos</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div id="wrapper">
            @yield('contenido')
            <footer id="footer">
                <div class="wrapper bg_black" style="position:relative; z-index:9;">
                    <div class="container_12">
                        <article class="grid_5 txt11" style="padding-top:9px;">
                            &nbsp;&copy;&nbsp;<span class="color_green"> Incubamas</span>
                            <a target="_blank" href="{{url('sistema')}}" title="Sistema">
                                {{HTML::image('accio/images/favicon.ico') }}
                            </a>
                            All Rights Reserved.
                        </article>
                        <article class="grid_5last-col">
                            <div class="social">
                                <a target="_blank" href="https://twitter.com/IncubaMas" title="Twitter">
                                    {{ HTML::image('accio/images/footer/twitter.png') }}
                                </a>
                                <a target="_blank" href="https://es-es.facebook.com/IncubaMas" title="Facebook">
                                    {{ HTML::image('accio/images/footer/facebook.png') }}
                                </a>
                                <a target="_blank" href="http://beta.incubamas.com/panel.php" title="Sistema">
                                    {{ HTML::image('accio/images/footer/incubamas.png') }}
                                </a>
                            </div>
                        </article>
                    </div>
                </div>
            </footer>
        </div>
        {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') }}
        {{ HTML::script('accio/js/respond.min.js') }}
        {{ HTML::script('accio/js/jquery.queryloader2.js') }}
        {{ HTML::script('accio/js/waypoints.min.js') }}
        {{ HTML::script('accio/js/jquery.easing.1.3.min.js') }}
        {{ HTML::script('accio/js/jquery.cycle.all.min.js') }}
        {{ HTML::script('accio/js/layerslider/js/layerslider.transitions.js') }}
        {{ HTML::script('accio/js/layerslider/js/layerslider.kreaturamedia.jquery.js') }}
        {{ HTML::script('accio/js/jquery.mixitup.js') }}
        {{ HTML::script('accio/js/jquery.mb.YTPlayer.js') }}
        {{ HTML::script('accio/js/jquery.smoothscroll.js') }}
        {{ HTML::script('accio/js/flexslider/jquery.flexslider.js') }}
        {{ HTML::script('accio/js/fancybox/jquery.fancybox.pack.js') }}
        {{ HTML::script('http://maps.google.com/maps/api/js?sensor=false') }}
        {{ HTML::script('accio/js/jquery.gmap.min.js') }}
        {{ HTML::script('accio/twitter/jquery.tweet.js') }}
        {{ HTML::script('accio/js/jquery.touchswipe.min.js') }}
        {{ HTML::script('accio/js/config.js') }}
        {{ HTML::script('accio/js/custom.js') }}
        {{ HTML::script('accio/plugins/modal/js/classie.js') }}
        {{ HTML::script('accio/plugins/modal/js/modalEffects.js') }}
    </body>
</html>