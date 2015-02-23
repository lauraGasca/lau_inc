@section('menu')
    <header id="header" class="transparent">
        <div class="header-in clearfix">
            <ul class="social-icons" style="display: inline-block; vertical-align: middle;">
                    <li class="twitter"><a href="https://twitter.com/IncubaMas"><i class="icon-twitter"></i>Twitter</a></li>
                    <li class="facebook"><a href="https://www.facebook.com/IncubaMas"><i class="icon-facebook"></i>Facebook</a></li>
                    <br/>
                    <li class="gplus"><a href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i class="icon-gplus"></i>Gplus</a></li>
                    <li class="linkedin"><a href="https://www.linkedin.com/company/incubam%C3%A1s"><i class="icon-linkedin"></i>LinkedIn</a></li>
            </ul><!--/ .social-icons-->
            <h1 id="logo">
                <a href="/"><img alt="Incubamas" src="{{ URL::asset('accio/images/Logo footer.png') }}"  /></a>
            </h1>
            <a id="responsive-nav-button" class="responsive-nav-button" href="#"></a>
            <nav id="navigation" class="navigation">
                <ul>
                    <li class="current-menu-item"><a href="#inicio">Inicio</a></li>
                    <li><a href="#incuba">Incuba</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#emprendedores">Emprendedores</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="#contactanos">Cont&aacute;ctanos</a></li> 
                </ul>
            </nav><!--/ #navigation-->			    
        </div><!--/ .header-in-->
    </header><!--/ #header-->
@stop
                
@section('contenido')
    <section id="inicio" class="page">
        <section class="section padding-off">
            <div id="layerslider-container">
                <div id="layerslider">
                    <div class="ls-layer" style="slidedirection: left; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                        <img alt="" class="ls-bg" src="{{ URL::asset('accio/images/body/Slider mas conocimiento.png') }}">
                        <h1 class="ls-s2 align-center" style="top: 43%; left: 130px; slidedirection : top; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                            Incuba = M&aacute;s
                        </h1>
                        <h1 class="ls-s2 align-center" style="top: 57%; left: 380px; slidedirection : bottom; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                            Conocimiento
                        </h1>
                    </div><!--/ .ls-layer-->
                    <div class="ls-layer" style="slidedirection: right; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                        <img alt="" class="ls-bg" src="{{ URL::asset('accio/images/body/Slider mas crecimiento.png') }}">
                        <h1 class="ls-s2 align-center" style="top: 43%; left: 180px; slidedirection : top; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                            Incuba = M&aacute;s 
                        </h1>
                        <h1 class="ls-s2 align-center" style="top: 57%; left: 260px; slidedirection : bottom; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                            crecimiento
                        </h1>	
                    </div><!--/ .ls-layer-->
                    <div class="ls-layer" style="slidedirection: right; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                        <img alt="" class="ls-bg" src="{{ URL::asset('accio/images/body/mas exito.png') }}">
                        <h1 class="ls-s2 align-center" style="top: 43%; left: 360px; slidedirection : top; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                            Incuba = 
                        </h1>
                        <h1 class="ls-s2 align-center" style="top: 57%; left: 170px; slidedirection : bottom; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                            M&aacute;s &Eacute;xito
                        </h1>
                    </div><!--/ .ls-layer-->
                </div><!--/ #layerslider-->
            </div><!--/ #layerslider-container	-->
            <ul class="keydown">
                <li class="up"></li>
                <li class="left"></li>
                <li class="down"></li>
                <li class="right"></li>
            </ul><!--/ .keydown	-->
        </section><!--/ .section-->
    </section><!--/ .page-->
    <section class="section padding-off">
        <div id="layerslider-container">
            <div id="layerslider">
                <div class="ls-layer" style="slidedirection: left; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                    <img alt="" class="ls-bg" src="{{ URL::asset('accio/images/body/Slider mas conocimiento.jpg') }}">
                    <h1 class="ls-s2 align-center" style="top: 43%; left: 130px; slidedirection : top; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                        Incuba = M&aacute;s
                    </h1>
                    <h1 class="ls-s2 align-center" style="top: 57%; left: 380px; slidedirection : bottom; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                        Conocimiento
                    </h1>
                </div><!--/ .ls-layer-->
                <div class="ls-layer" style="slidedirection: right; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                    <img alt="" class="ls-bg" src="{{ URL::asset('accio/images/body/Slider mas crecimiento.jpg') }}">
                    <h1 class="ls-s2 align-center" style="top: 43%; left: 180px; slidedirection : top; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                        Incuba = M&aacute;s 
                    </h1>
                    <h1 class="ls-s2 align-center" style="top: 57%; left: 260px; slidedirection : bottom; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                        crecimiento
                    </h1>	
                </div><!--/ .ls-layer-->
                <div class="ls-layer" style="slidedirection: right; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                    <img alt="" class="ls-bg" src="{{ URL::asset('accio/images/body/mas exito.jpg') }}">
                    <h1 class="ls-s2 align-center" style="top: 43%; left: 360px; slidedirection : top; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                        Incuba = 
                    </h1>
                    <h1 class="ls-s2 align-center" style="top: 57%; left: 170px; slidedirection : bottom; slideoutdirection : fade; scaleout : 0.75; durationin : 2000; durationout : 1000; easingin : easeInOutQuint; easingout : easeInOutQuint;">
                        M&aacute;s &Eacute;xito 
                    </h1>
                </div><!--/ .ls-layer-->
            </div><!--/ #layerslider-->
        </div><!--/ #layerslider-container-->
        <ul class="keydown">
            <li class="up"></li>
            <li class="left"></li>
            <li class="down"></li>
            <li class="right"></li>
        </ul><!--/ .keydown-->	
    </section><!--/ .section-->
</section><!--/ .page-->
<section class="section border">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <hgroup class="section-title align-center opacity">
                    <h1>Nuestros aliados</h1>	
                </hgroup>			
            </div>
        </div><!--/ .row-->
        <div class="row">
            <div class="col-xs-12">
                <ul class="clients-items">
                    <li class="opacity2x"><a target="_blank" href="http://celaya.gob.mx/en/"><img src="{{ URL::asset('accio/images/body/LOGO CELAYA.png') }}" alt="" /></a></li>
                    <li class="opacity2x"><a target="_blank" href="http://goo.gl/ZDAZ1T"><img src="{{ URL::asset('accio/images/body/INADEM.png') }}" alt="" /></a></li>
                    <li class="opacity2x"><a target="_blank" href="http://redincubadoras.inadem.gob.mx/"><img src="{{ URL::asset('accio/images/body/Logo Federacion.png') }}" alt="" /></a></li>
                    <li class="opacity2x"><a target="_blank" href="http://sde.guanajuato.gob.mx/"><img src="{{ URL::asset('accio/images/body/GTO SEDES logo.png') }}" alt="" /></a></li>
                </ul><!--/ .clients-items-->
            </div>
        </div><!--/ .row-->		
    </div><!--/ .container-->
</section><!--/ .section-->
<section id="incuba" class="page">
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hgroup class="slogan align-center opacity">
                        <h1>TRANSFORMAR TUS IDEAS ES NUESTRA <span>PRIORIDAD</span></h1>
                        <h2>&quot;SUE&Ntilde;A EN GRANDE, DESARROLLA TU IDEA Y CREA TU &Eacute;XITO&quot;</h2>	
                    </hgroup>	
                </div>
            </div><!--/ .row-->
            <div class="row">
                <div class="col-md-7 opacity">
                    <p>
                        <img src="{{ URL::asset('accio/images/body/seccion INCUBA.png') }}" alt="" />
                    </p>
                </div><!--/ .col-md-6-->
                <div class="col-md-5">
                    <p class="opacity">
                        En IncubaM&aacute;s somos un  grupo de personas que aman su trabajo y el mundo emprendedor,
                        fomentamos el desarrollo de nuevas ideas nutri&eacute;ndolas con acceso a los recursos que necesitan
                        para ser empresas excepcionales. 
                    </p>
                    <ul class="list circle-list opacity">
                        <li>Asesoramos m&aacute;s de  80 Pymes al a&ntilde;o</li>
                        <li>Somos una incubadora certificada por el INADEM</li>
                        <li>Nuestros emprendedores son nuestro referente de &eacute;xito</li>
                        <li>Desarrollamos espacios y oportunidades de negocios</li>
                        <li>Apoyamos en  cualquier etapa de emprendimiento o Re emprendimiento. </li>
                    </ul><!--/ .list-->
                </div><!--/ .col-md-5-->
            </div><!--/ .row-->
        </div><!--/ .container-->	
    </section><!--/ .section-->
    <section id="servicios" class="page">
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hgroup class="section-title align-center opacity">
                        <h1>Servicios</h1>
                        <h2>&quot;El &eacute;xito en los negocios requiere entrenamiento y disciplina y trabajo duro... si quieres algo de verdad, no esperes por ello, ens&eacute;&ntilde;ate a ser impaciente&quot;</h2>	
                    </hgroup>					
                </div>
            </div><!--/ .row-->
            <div class="row">
                <div class="col-xs-12">
                    <div class="flexslider opacity">
                        <ul class="slides">
                            <li data-icon="icon-lightbulb" data-title="Asesor&iacute;a">
                                <p>
                                    Apoyamos a emprendedores con un  proyecto de negocios a desarrollar y consolidar su empresa asesor&aacute;ndolos en los estudios de factibilidad t&eacute;cnica
                                    y financiera, capacit&aacute;ndolos para que puedan desarrollar su plan de negocios  con un acompa&ntilde;amiento en la implementaci&oacute;n y puesta en marcha,
                                    as&iacute; como un seguimiento a lo largo de los primeros pasos  de vida de la empresa. Desarrollamos de proyectos empresariales que busquen la mejora de la empresa
                                    y generen un impacto social y econ&oacute;mico.
                                </p>
                            </li>
                            <li data-icon="icon-money" data-title="Vinculaci&oacute;n">
                                <p>
                                    IncubaM&aacute;s es una Incubadora de Negocios reconocida por el <strong>INADEM</strong> y <strong>SEDES</strong>, por lo que tiene acceso a la vinculaci&oacute;n  directa
                                    de nuestros emprendedores a las l&iacute;neas de financiamiento de Capital Semilla, entre otras, adem&aacute;s contamos con experiencia en levantamiento de recursos en otras instituciones.
                                </p>
                                <p>
                                    Nos encontramos en la b&uacute;squeda continua de Recursos Financieros P&uacute;blicos y Privados que la empresa junto con el equipo de IncubaM&aacute;s ha identificado como necesarios
                                    para su desarrollo, crecimiento y consolidaci&oacute;n.
                                </p>					
                            </li>
                            <li data-icon="icon-thumbs-up" data-title="Low Cost">
                                <p>
                                    Conocemos las necesidades de los emprendedores y contamos con un sistema de  precios bajos en diferentes servicios donde  regularmente no existen oportunidades y ofertas para ahorrar.
                                </p>
                                <p>
                                    Desarrollamos esta estrategia para obtener lo mismo pagando menos y  en IncubaM&aacute;s queremos presentamos los servicios de Low Cost que lleva al extremo las estrategias para
                                    no gastar m&aacute;s de lo justo en &aacute;reas como  legal, fiscal, finanzas, dise&ntilde;o Web, Identidad, dise&ntilde;o web, mercadotecnia, entre otras &aacute;reas. 
                                </p>		
                            </li>
                            <li data-icon="icon-cog" data-title="Networking">
                                <p>
                                    La IncubaM&aacute;s organiza sesiones de Networking con la finalidad de que los emprendedores establezcan contacto con clientes interesados en su producto o servicio, as&iacute;
                                    como para que logren intercambios de negocios con otras empresas, lo definimos como  &quot;reuniones sociales para la generaci&oacute;n de nuevos contactos empresariales que
                                    favorezcan la creaci&oacute;n de alianzas estrat&eacute;gicas entre las empresas&quot; el networking es una opci&oacute;n interesante y conveniente, sobre todo para empresas
                                    de reciente creaci&oacute;n que buscan: nuevos clientes, mejores proveedores, relaciones p&uacute;blicas, publicidad y alianzas comerciales.
                                </p>
                                <p>
                                    Cada networking puede tener din&aacute;micas diferenciadas para generar la interacci&oacute;n entre participantes, ya que  algunas pueden ser grupales y otras uno a uno. 
                                </p>							
                            </li>
                            <li data-icon="icon-beaker" data-title="Mentor&iacute;a">
                                <p>
                                    Los servicios de mentor&iacute;a incluyen la medici&oacute;n, el progreso y el trabajo necesario para conseguir una adecuada actitud personal y financiera, adem&aacute;s del apoyo constante,
                                    recuerda que ofrecemos un conjunto de servicios profesionales, &uacute;tiles y de calidad. Conscientes de la dif&iacute;cil situaci&oacute;n que amerita emprender, Muchas veces una
                                    sola sesi&oacute;n de 40 minutos es suficiente para encaminar a un emprendedor a llegar a sus metas personales o comerciales.
                                </p>							
                            </li>
                            <li data-icon="icon-graduation-cap" data-title="Capacitaci&oacute;n">
                                <p>
                                    Realizamos de distintas actividades de capacitaci&oacute;n para nuestros incubados, el principal objetivo es fomentar la actitud emprendedora y potenciar las habilidades empresariales de cada proyecto,
                                    a trav&eacute;s nuestro sistema de capacitaci&oacute;n, desarrollamos esquemas y mecanismos que permiten incrementar las habilidades de nuestros emprendedores en &aacute;reas como  legal,
                                    fiscal, finanzas, mercadotecnia,  ventas, etc.
                                </p>							
                            </li>
                        </ul>
                    </div><!--/ .flexslider-->	
                </div>
                <div class="col-xs-12">
                    <div class="align-center opacity">
                        {{HTML::link('#contactanos','Deseo contactarlos',array('class'=>'button large default'))}}
                    </div>
                </div>
            </div><!--/ .row-->
        </div><!--/ .container-->
    </section><!--/ .section-->
</section><!--/ .page-->
    <section class="section parallax parallax-bg-1 bg-turquoise-color">
        <div class="full-bg-image"></div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="quotes opacity" data-timeout="6000">
                        <li class="align-center">
                            <blockquote class="quote-text">
                                <p class="align-center">Ir juntos es comenzar. Mantenerse juntos es progresar.<br/> Trabajar juntos es triunfar</p>
                            </blockquote>
                            <div class="quote-image"><img alt="Henry Ford" src="{{ URL::asset('accio/images/frases/Henry Ford.png') }}"></div>
                            <div class="quote-author"><span>Henry Ford</span></div>
                        </li>
                        <li class="align-center">
                            <blockquote class="quote-text">
                                <p class="align-center">Para lograr grandes empresas, no debemos &uacute;nicamente actuar sino tambi&eacute;n so&ntilde;ar; <br/>no s&oacute;lo planear, sino tambi&eacute;n creer</p>
                            </blockquote>
                            <div class="quote-image"><img alt="Anatole France" src="{{ URL::asset('accio/images/frases/Anatole France.png') }}"></div>
                            <div class="quote-author"><span>Anatole France</span></div>
                        </li>
                        <li class="align-center">
                            <blockquote class="quote-text">
                                <p class="align-center">Cualquier cosa que la mente pueda concebir y creer, <br/>puede ser conseguida</p>
                            </blockquote>
                            <div class="quote-image"><img alt="Napoleon Hill" src="{{ URL::asset('accio/images/frases/Napoleon Hill.png') }}"></div>
                            <div class="quote-author"><span>Napoleon Hill</span></div>
                        </li>
                    </ul><!--/ .quotes-->
                </div>
            </div><!--/ .row-->
        </div><!--/ .container-->
    </section><!--/ .section-->
</section><!--/ .section-->
<section id="emprendedores" class="page">
    <section class="section padding-bottom-off">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hgroup class="section-title align-center opacity">
                        <h1>Nuestras empresas</h1>
                        <h2>&quot;Si puedes so&ntilde;arlo, puedes hacerlo&quot;</h2>
                    </hgroup>							
                </div>
            </div><!--/ .row-->
            <div class="row">
                <div class="col-xs-12">
                    <ul id="portfolio-filter" class="portfolio-filter opacity">
                        <li class="filter active" data-filter="all" onclick="ocultar()">Todos</li>
                        <li class="filter" data-filter="Comercio" onclick="mostrar('Comercio')" >Comercio</li>
                        <li class="filter" data-filter="Servicio" onclick="mostrar('Servicio')">Servicio</li>
                        <li class="filter" data-filter="Industria" onclick="mostrar('Industria')">Industria</li>
                        <li class="filter" data-filter="Incub&aacute;ndose" onclick="mostrar('Incub&aacute;ndose')">Incub&aacute;ndose</li>
                    </ul><!--/ #portfolio-filter -->		
                </div>
            </div><!--/ .row-->
        </div><!--/ .container-->
        <?php $caso_id=0;?>
        @if(count($casos) > 0)
            <ul id="portfolio-items" class="portfolio-items">
            @foreach($casos as $caso)
                <?php $caso_id++;?>
                <li id="{{$caso_id}}" class="{{$caso->categoria}} mix mix_all opacity2x" style="display:none;">
                    <div class="work-item">
                        <img src="{{ URL::asset('Orb/images/casos_exito/'.$caso->imagen) }}" alt="" />
                        <div class="image-extra">
                            <div class="extra-content">
                                <div class="inner-extra">
                                    <h2 class="extra-title">{{$caso->nombre_proyecto}}</h2>
                                    <h6 class="extra-category">{{$caso->categoria}}</h6>
                                    {{HTML::link('incuba/caso/'.$caso->id,'',array('class'=>'single-image link-icon'))}}
                                </div><!--/ .inner-extra-->	
                            </div><!--/ .extra-content-->
                        </div><!--/ .image-extra-->
                    </div><!--/ .work-item-->
                </li>
            @endforeach
            </ul><!--/ .portfolio-items-->
        @else
            No hay ningun Casos de &Eacute;xito registrado
        @endif
        <br/><br/>
        <div class="col-xs-12">
            <div class="align-center opacity">
                {{HTML::link('incuba/casos/todos','Ver todos los emprendedores',array('class'=>'button large default'))}}
            </div>
        </div>
    </section><!--/ .section-->
</section><!--/ .page-->
<section id="blog" class="page">
    <section class="section bg-gray-color">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hgroup class="section-title align-center opacity">
                        <h1>INCUBA BLOG</h1>
                        <h2>La lectura es placer, conocimiento, emoci&oacute;n y el secreto de la sabiduria</h2>	
                    </hgroup>						
                </div>
            </div><!--/ .row-->
            <?php
            $posicion[0]="slideRight";
            $posicion[1]="slideUp";
            $posicion[2]="slideLeft";
            $i=0;
            ?>
            <div class="row">
                @if(count($blogs) > 0)
                    @foreach($blogs as $blog)
                        <div class="col-sm-6 col-lg-4 {{$posicion[$i]}}">
                            <? $i++;?>
                            <article class="entry">
                                <div class="entry-image">
                                    <div class="work-item">
                                        <img src="{{ URL::asset('Orb/images/entradas/'.$blog->imagen) }}" alt="" />
                                        <div class="image-extra">
                                            <div class="extra-content">
                                                <div class="inner-extra">
                                                    <a class="single-image emo-icon" href="{{URL::asset('incuba/blog/'.$blog->id)}}"></a>
                                                </div><!--/ .inner-extra-->	
                                            </div><!--/ .extra-content-->
                                        </div><!--/ .image-extra-->	
                                    </div><!--/ .work-item-->	
                                </div><!--/ .entry-image-->
                                <div class="entry-meta">
                                    <?php
                                        $date = date_create($blog->fecha_publicacion);
                                        $fecha=date_format($date, 'd-m-Y');
                                    ?>
                                    <span class="date"><a href="#">{{$fecha}}</a></span>
                                    <span class="comments">{{$blog->comentarios}} Comentarios</span>
                                </div><!--/ .entry-meta-->
                                <h2 class="entry-title">
                                    <a href="{{URL::asset('incuba/blog/'.$blog->id)}}">{{$blog->titulo}}</a>
                                </h2><!--/ .entry-title-->
                                <div class="entry-body">
                                    <p>
                                        {{substr (strip_tags($blog->entrada), 0, 220)}}...<strong> {{HTML::link('incuba/blog/'.$blog->id,'Ver más', array('class'=>'azul'))}}</strong>
                                    </p>
                                </div><!--/ .entry-body-->
                            </article><!--/ .entry-->
                        </div>
                    @endforeach
                    </div>
                    <div class="col-xs-12">
                        <div class="align-center opacity">
                            {{HTML::link('incuba/blogs/todos','Ver todas las entradas',array('class'=>'button large default'))}}
                        </div>
                    </div>
                @else
                    No hay ninguna entrada registrado
                    </div>
                @endif
            
        </div><!--/ .container-->	
    </section><!--/ .section-->
</section><!--/ .page-->
<section id="contactanos" class="page">
    <section class="section padding-bottom-off">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hgroup class="section-title align-center opacity">
                        <h1>Cont&aacute;ctanos</h1>
                        <h2>&quot;Un d&iacute;a tu vida pasar&aacute; ante tus ojos, nos aseguraremos  de que merezca la pena mirar&quot;</h2>	
                    </hgroup>		
                </div>
            </div><!--/ .row-->
        </div><!--/ .container-->
    </section><!--/ .section-->
    <section class="section parallax parallax-bg-4">
        <div class="full-bg-image"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 opacity">
                    @if(Session::get('confirm'))
                        <script>
                            alert("¡Gracias por contactarnos, contestaremos tu correo lo m\u00e1s pronto posible!");
                        </script>
                    @endif
                    {{ Form::open(array('url'=>'incuba/contacto', 'method' => 'post') )}}
                        <p class="input-block">
                            {{Form::text('name', null, array('placeholder'=>'Nombre'))}}
                            <span class="message-error">{{$errors->first('name')}}</span>
                        </p>
                        <p class="input-block">
                            {{Form::email('email', null, array('placeholder'=>'Correo'))}}
                            <span class="message-error">{{$errors->first('email')}}</span>
                        </p>
                        <p class="input-block">
                            {{Form::text('city', null, array('placeholder'=>'Ciudad'))}}
                            <span class="message-error">{{$errors->first('city')}}</span>
                        </p>
                        <p class="input-block">
                            {{ Form::textarea('message', null, array('placeholder'=>'Mensaje')) }}
                            <span class="message-error">{{$errors->first('message')}}</span>
                        </p>
                        <p class="input-block">
                            {{Form::captcha(array('theme' => 'clean'))}}
                            <span class="message-error">{{$errors->first('recaptcha_response_field')}}</span>
                        </p>
                        <p class="input-block">
                            <button class="button turquoise submit" type="submit" id="submit"><i class="icon-paper-plane-2"></i></button>
                        </p>
                    {{Form::close()}}	
                </div>
                <div class="col-md-6">
                    <div class="widget widget_text opacity blanco">
                        <p>
                            Para nosotros es muy importante conocer tu proyecto en cualquier etapa que se encuentre,
                            si posees una idea innovadora con alto potencial de crecimiento, te invitamos a ponerte
                            en contacto con nosotros y agenda una cita.
                        </p>
                        <p>
                            Esperamos contar contigo  como emprendedor de IncubaM&aacute;s,
                            apoy&aacute;ndote con todas nuestras capacidades, redes y todo el conocimiento que IncubaM&aacute;s puede ofrecerte
                            en un exclusivo ambiente de confidencialidad y respeto por tus ideas.
                        </p><br/>
                        <p>
                            Es de suma importancia  que  consideres los siguientes aspectos para poder  desarrollar  un v&iacute;nculo con nosotros:
                        </p>
                        <ul class="list circle-list blanco">
                            <li>Aut&eacute;ntico deseo de emprender</li>
                            <li>Dispuestos a invertir tiempo y recursos</li>
                            <li>Idea clara de negocio</li>
                            <li>No es requisito la experiencia en creaci&oacute;n y manejo de empresas</li>
                        </ul><!--/ .list-->
                    </div><!--/ .widget-->
                    <div class="widget widget_contacts opacity">
                        <ul class="contact-details blanco">
                            <li>Direcci&oacute;n: Sinaloa Ote 119 Alameda, Celaya, Guanajuato, M&eacute;xico </li>
                            <li>Tel&eacute;fono: (461) 6121699 </li>
                            <li>Email: hola@incubamas.com</li>
                            <li>Horarios : 9:00 - 13:00 / 15:00 - 18:00</li>
                        </ul><!--/ .contact-details-->
                    </div><!--/ .widget-->
                    <div class="widget widget_social opacity">
                        <ul class="social-icons">
                            <li class="twitter"><a href="https://twitter.com/IncubaMas"><i class="icon-twitter"></i>Twitter</a></li>
                            <li class="facebook"><a href="https://www.facebook.com/IncubaMas"><i class="icon-facebook"></i>Facebook</a></li>
                            <li class="gplus"><a href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i class="icon-gplus"></i>Gplus</a></li>
                            <li class="linkedin"><a href="https://www.linkedin.com/company/incubam%C3%A1s"><i class="icon-linkedin"></i>LinkedIn</a></li>
                        </ul><!--/ .social-icons-->
                    </div><!--/ .widget-->
                </div>
            </div><!--/ .row-->
        </div><!--/ .container-->
    </section><!--/ .section-->
    
    <!-- Google map -->
    <section class="section padding-off">
        <div class="map-wrapper">
            <div class="map-top-overlay"></div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3736.4576186694894!2d-100.81146974418027!3d20.528448995115742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sSinaloa+119%2C+alamenda%2C+Celaya%2C+Gto.!5e0!3m2!1ses-419!2smx!4v1424726331422" width="100%" height="600" frameborder="0" style="border:0"></iframe>
            </div>
        </div>
    </section><!--/ .section-->
    <!-- Fin Google map -->
</section><!--/ .page-->
@stop

@section('scripts')
    @parent
@stop