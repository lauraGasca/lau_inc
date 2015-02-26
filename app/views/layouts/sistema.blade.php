<!DOCTYPE html>

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="description" content="Sistema Incubadora de Negocios">
        <meta name="author" content="Incubamas">
        <title>
            @section('titulo')
                IncubaM&aacute;s
            @show
        </title>
        @section('css')
            {{ HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
            {{ HTML::style('Orb/css/styles.css') }}
            {{ HTML::script('Orb/bower_components/jquery/jquery.min.js') }}
            {{ HTML::script('Orb/js/vendors/modernizr/modernizr.custom.js') }}
            <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('Orb/favicon.ico') }}"/>
        @show
    </head>

    <body>
    <div class="smooth-overflow">
        <nav class="main-header clearfix" role="navigation">
            <a class="navbar-brand" href="#">
                <span class="text-blue">Incuba</span>
            </a>
            <div class="navbar-content">
                @if(Auth::user()->type_id!=3&&Auth::user()->type_id!=4)
                    <a href="#" class="btn btn-default left-toggler">
                        <i class="fa fa-bars"></i>
                    </a>
                @endif
                <a href="#" class="btn btn-user right-toggler pull-right">
                    <i class="entypo-vcard"></i>
                    <span class="logged-as hidden-xs">Accediste como</span>
                    <span class="logged-as-name hidden-xs">{{Auth::user()->user}}</span>
                </a>
                <button type="button" class="btn btn-default hidden-xs pull-right" id="toggle-fullscreen">
                    <i class=" entypo-popup"></i>
                </button>
            </div>
        </nav>
        <div class="main-wrap">
            <aside class="user-menu">
                <div class="tabs-offcanvas">
                    <div class="tab-content">
                        <div class="tab-pane active" id="userbar-one">
                            <div class="main-info">
                                <div class="user-img">
                                    {{ HTML::image('Orb/images/emprendedores/'.Auth::user()->foto, Auth::user()->nombre.' '.Auth::user()->apellidos) }}
                                </div>
                                <h1>
                                    {{Auth::user()->nombre.' '.Auth::user()->apellidos}}
                                    <br/><br/>
                                    <small>{{Auth::user()->puesto}}</small>
                                </h1>
                            </div><br/>
                            <div class="list-group">
                                <div class="empthy"></div>
                                <a data-toggle="modal" href="{{url('sistema/logout')}}" class="list-group-item goaway">
                                    <i class="fa fa-power-off"></i>
                                    Cerrar Sesi&oacute;n
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            @if(Auth::user()->type_id==1||Auth::user()->type_id==2)
                <div class="responsive-admin-menu">
                    <div class="responsive-menu">
                        Incuba
                        <div class="menuicon"><i class="fa fa-angle-down"></i></div>
                    </div>
                    <ul id="menu">
                        <li><a
                            @section('emprendedores')
                                @show
                                href="{{url('emprendedores')}}" title="Emprendedores"><i class="entypo-user"></i><span>Emprendedores</span></a>
                        </li>
                        <li><a
                            @section('casos')
                                @show
                                href="{{url('casos')}}" title="Casos de &Eacute;xito"><i class="entypo-briefcase"></i><span>Casos de &Eacute;xito</span></a>
                        </li>
                        <li><a
                            @section('blog')
                                @show
                                href="{{url('blog')}}" title="Blog"><i class="entypo-box"></i><span>Blog</span></a>
                        </li>
                        <li><a
                            @section('chat')
                                @show
                                href="{{url('chat')}}" title="Chat"><i class="fa fa-comments"></i><span>Mensajes</span></a>
                        </li>
                        <li><a
                            @section('atendidos')
                                @show
                                href="{{url('atendidos')}}" title="Chat"><i class="fa fa-joomla"></i><span>Personas atendidas</span></a>
                        </li>
                        @if(Auth::user()->type_id<>3)
                            <li><a
                                @section('calendario')
                                    @show
                                    href="{{url('calendario')}}" title="Calendario"><i class="entypo-calendar"></i><span> Calendario</span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
            <div class="content-wrapper" @if(Auth::user()->type_id==3||Auth::user()->type_id==4) style="margin-left: 10px;" @endif >
                <nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper"></nav>
                <div class="breadcrumb clearfix">
                    <ul>
                        @section('mapa')
                        @show
                    </ul>
                </div>
                <div class="page-header">
                    @section('titulo-seccion')
                    @show
                </div>
                <div class="row" id="powerwidgets">
                    <div class="col-md-12 bootstrap-grid">
                        @section('contenido')
                        @show
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <!--Scripts-->
        <!--Fullscreen-->
        {{ HTML::script('Orb/js/vendors/fullscreen/screenfull.min.js') }}
        <!--NanoScroller-->
        {{ HTML::script('Orb/js/vendors/nanoscroller/jquery.nanoscroller.min.js') }}
        <!--Sparkline-->
        {{ HTML::script('Orb/js/vendors/sparkline/jquery.sparkline.min.js') }}
        <!--Horizontal Dropdown-->
        {{ HTML::script('Orb/js/vendors/horisontal/cbpHorizontalSlideOutMenu.js') }}
        {{ HTML::script('Orb/js/vendors/classie/classie.js') }}
        <!--PowerWidgets-->
        {{ HTML::script('Orb/js/vendors/powerwidgets/powerwidgets.min.js') }}
        <!--Bootstrap-->
        {{ HTML::script('Orb/js/vendors/bootstrap/bootstrap.min.js') }}
        <!--ToDo-->
        {{ HTML::script('Orb/js/vendors/todos/todos.js') }}
        <!--Bootstrap Animation-->
        {{ HTML::script('Orb/js/vendors/animation/animation.js') }}
        <!--Main App-->
        {{ HTML::script('Orb/js/scripts.js') }}
        <!--/Scripts-->
    @show

    </body>

</html>