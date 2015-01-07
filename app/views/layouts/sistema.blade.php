<!DOCTYPE html>

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      @section('titulo')
        IncubaM&aacute;s | Casos de &Eacute;xito
      @show
    </title>
    @section('css')
      {{ HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
      {{ HTML::style('Orb/css/styles.css') }}
      {{ HTML::script('Orb/js/vendors/modernizr/modernizr.custom.js') }}
      <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('Orb/favicon.ico') }}" />
    @show
  </head>
      
  <body>
    <!--Smooth Scroll-->
    <div class="smooth-overflow">
      <!--Navigation-->
      <nav class="main-header clearfix" role="navigation">
        <a class="navbar-brand" href="#">
          <span class="text-blue">Incuba</span>
        </a>
        <!--Search
        <div class="site-search">
          <form action="#" id="inline-search">
            <i class="fa fa-search"></i>
            <input type="search" placeholder="Search">
          </form>
        </div>-->
        <!--Navigation Itself-->
        <div class="navbar-content"> 
          @if(Auth::user()->type_id!=3&&Auth::user()->type_id!=4)
            <!--Sidebar Toggler--> 
            <a href="#" class="btn btn-default left-toggler">
              <i class="fa fa-bars"></i>
            </a> 
          @endif
          <!--Right Userbar Toggler--> 
          <a href="#" class="btn btn-user right-toggler pull-right">
            <i class="entypo-vcard"></i>
            <span class="logged-as hidden-xs">Accediste como</span>
            <span class="logged-as-name hidden-xs">{{Auth::user()->user}}</span>
          </a> 
          <!--Fullscreen Trigger-->
          <button type="button" class="btn btn-default hidden-xs pull-right" id="toggle-fullscreen">
            <i class=" entypo-popup"></i>
          </button>
        </div>
      </nav>
      <!--/Navigation--> 
      <!--MainWrapper-->
      <div class="main-wrap"> 
        <!--OffCanvas Menu -->
        <aside class="user-menu"> 
          <!-- Tabs -->
          <div class="tabs-offcanvas">
            <div class="tab-content"> 
              <!--User Primary Panel-->
              <div class="tab-pane active" id="userbar-one">
                <div class="main-info">
                  <div class="user-img"><img src="http://placehold.it/150x150" alt="User Picture" /></div>
                  <h1>{{Auth::user()->user}} <small>
                    @if(Auth::user()->type_id==1)
                      Administrador
                    @else
                      @if(Auth::user()->type_id==2)
                        Asesor
                      @else
                        @if(Auth::user()->type_id==3)
                          Emprendedor
                        @else
                          @if(Auth::user()->type_id==4)
                            Practicante
                          @endif
                        @endif  
                      @endif
                    @endif
                  </small></h1>
                </div>
                <div class="list-group">
                  <!--<a href="user/perfil/{{Auth::user()->id}}" class="list-group-item"><i class="fa fa-user"></i>Perfil</a>-->
                  <div class="empthy"></div>
                  <a data-toggle="modal" href="{{url('sistema/logout')}}" class="list-group-item goaway"><i class="fa fa-power-off"></i>Cerrar Sesi&oacute;n</a>
                </div>
              </div>
            </div>
          </div>
          <!-- /tabs --> 
        </aside>
        <!-- /Offcanvas user menu-->
        @if(Auth::user()->type_id==1||Auth::user()->type_id==2)
        <!--Main Menu-->
        <div class="responsive-admin-menu">
          <div class="responsive-menu">Incuba
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
            @if(Auth::user()->type_id<>3)
              <li><a
                    @section('calendario')
                    @show
                  href="{{url('calendario')}}" title="Calendario"><i class="entypo-calendar"></i><span> Calendario</span></a>
              </li>
            @endif
            @if(Auth::user()->id==21)
              <li class=""> <a class="submenu
              @section('calendario-down')
              @show
              " href="#" data-id="maps-sub" title="Calendarios"><i class="fa fa-4x fa-calendar"></i><span> Todos los Calendarios</span></a>
                <!-- Maps Sub-Menu -->
                <ul style="display:
                @section('calendario-none')
                        none
                @show;
                        " id="maps-sub">
                  <li class=""><a href="{{url('calendario/index/1')}}" title="Noé Vidal"><i class="fa fa-4x fa-child"></i><span> Noé Vidal</span></a></li>
                  <li class=""><a href="{{url('calendario/index/16')}}" title="Yosselyn Ruiz"><i class="fa fa-4x fa-female"></i><span> Yosselyn Ruiz</span></a></li>
                  <li class=""><a href="{{url('calendario/index/19')}}" title="Brenda Medina"><i class="fa fa-4x fa-user"></i><span> Brenda Medina</span></a></li>
                  <li class=""><a href="{{url('calendario/index/20')}}" title="Francisco Chávez"><i class="fa fa-4x fa-reddit"></i><span> Francisco Chávez</span></a></li>
                  <li class=""><a href="{{url('calendario/index/22')}}" title="Jazmín Gómez"><i class="fa fa-4x fa-smile-o"></i><span> Jazmín Gómez</span></a></li>
                  <li class=""><a href="{{url('calendario/index/35')}}" title="Laura Gasca"><i class="fa fa-4x fa-paw"></i><span> Laura Gasca</span></a></li>
                </ul>
              </li>
            @endif
          </ul>
          
        </div>
        <!--/MainMenu-->
      @endif
        <!--Content Wrapper-->
        <div class="content-wrapper"
          @if(Auth::user()->type_id==3||Auth::user()->type_id==4)
            style="margin-left: 10px;"
          @endif 
        > 
          <!--Horisontal Dropdown-->
          <nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper"></nav>
          <!--Breadcrumb-->
          <div class="breadcrumb clearfix">
            <ul>
              @section('mapa')
              @show
            </ul>
          </div>
          <!--/Breadcrumb-->
          <div class="page-header">
            @section('titulo-seccion')
            @show
          </div>
          <!-- Widget Row Start grid -->
          <div class="row" id="powerwidgets">
            <div class="col-md-12 bootstrap-grid"> 
              <!-- New widget -->
              @section('contenido')
              @show
              <!-- End Widget --> 
            </div>
            <!-- /Inner Row Col-md-12 --> 
          </div>
          <!-- /Widgets Row End Grid--> 
        </div>
        <!-- / Content Wrapper --> 
      </div>
      <!--/MainWrapper--> 
    </div>
    <!--/Smooth Scroll-->
  
    @section('scripts')
      <!--Scripts--> 
        <!--JQuery-->
        {{ HTML::script('Orb/js/vendors/jquery/jquery.min.js') }}
        {{ HTML::script('Orb/js/vendors/jquery/jquery-ui.min.js') }}
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