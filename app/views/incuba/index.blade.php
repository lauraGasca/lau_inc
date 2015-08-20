@section('menu-t') class="transparent" @stop

@section('menu-in') header-in clearfix @stop

@section('inicio-c') class="current-menu-item" @stop

@section('inicio') href="#inicio" @stop

@section('incuba') href="#incuba" @stop

@section('servicios') href="#servicios" @stop

@section('casos') href="#emprendedores" @stop

@section('blog') href="#blog" @stop

@section('contacto') href="#contactanos" @stop

@section('contenido')
    <section id="inicio" class="page">
        <section class="section padding-off">
            <div id="layerslider-container">
                <div id="layerslider">
                    @foreach($sliders as $slider)
                        <div class="ls-layer" style="slidedirection: left; durationin: 1500; durationout: 1500; easingin: easeInOutQuint; timeshift: -500;">
                            {{ HTML::image('Orb/images/sliders/'.$slider->imagen, null, ['class'=>"ls-bg"]) }}
                        </div>
                    @endforeach
                </div>
            </div>
            <ul class="keydown">
                <li class="up"></li>
                <li class="left"></li>
                <li class="down"></li>
                <li class="right"></li>
            </ul>
        </section>
    </section>
    <section class="section border">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hgroup class="section-title align-center opacity">
                        <h1>Nuestros aliados</h1>
                    </hgroup>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <ul class="clients-items">
                        <li class="opacity2x"><a target="_blank" href="http://celaya.gob.mx/en/">{{HTML::image('accio/images/body/LOGO CELAYA.png','Celaya') }}</a></li>
                        <li class="opacity2x"><a target="_blank" href="http://goo.gl/ZDAZ1T">{{HTML::image('accio/images/body/INADEM.png','INADEM') }}</a></li>
                        <li class="opacity2x"><a target="_blank" href="http://redincubadoras.inadem.gob.mx/">{{HTML::image('accio/images/body/Logo Federacion.png','INADEM') }}</a></li>
                        <li class="opacity2x"><a target="_blank" href="http://sde.guanajuato.gob.mx/">{{HTML::image('accio/images/body/GTO SEDES logo.png','SEDES') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
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
                </div>
                <div class="row">
                    <div class="col-md-7 opacity">
                        <p>{{HTML::image('accio/images/body/seccion INCUBA.png','Incubamas') }}</p>
                    </div>
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
                        </ul>
                    </div>
                </div>
            </div>
        </section>
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
                </div>
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
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="align-center opacity">
                            {{HTML::link('#contactanos','Deseo contactarlos',array('class'=>'button large default'))}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
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
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </section>
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
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul id="portfolio-filter" class="portfolio-filter opacity">
                            <li class="filter active" data-filter="all" onclick="ocultar()">Todos</li>
                            <li class="filter" data-filter="Comercio" onclick="mostrar('Comercio')" >Comercio</li>
                            <li class="filter" data-filter="Servicio" onclick="mostrar('Servicio')">Servicio</li>
                            <li class="filter" data-filter="Industria" onclick="mostrar('Industria')">Industria</li>
                            <li class="filter" data-filter="Incub&aacute;ndose" onclick="mostrar('Incub&aacute;ndose')">Incub&aacute;ndose</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php $caso_id=0;?>
            @if(count($casos) > 0)
                <ul id="portfolio-items" class="portfolio-items">
                @foreach($casos as $caso)
                    <?php $caso_id++;?>
                    <li id="{{$caso_id}}" class="{{$caso->categoria}} mix mix_all opacity2x" style="display:none;">
                        <div class="work-item">
                            {{HTML::image('Orb/images/casos_exito/'.$caso->imagen) }}
                            <div class="image-extra">
                                <div class="extra-content">
                                    <div class="inner-extra">
                                        <h2 class="extra-title">{{$caso->nombre_proyecto}}</h2>
                                        <h6 class="extra-category">{{$caso->categoria}}</h6>
                                        {{HTML::link('nuestros-emprendedores/'.$caso->slug.'/'.$caso->id, null, ['class'=>'single-image link-icon'])}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            @else
                No hay ningun Casos de &Eacute;xito registrado
            @endif
            <br/><br/>
            <div class="col-xs-12">
                <div class="align-center opacity">
                    {{HTML::link('nuestros-emprendedores','Ver todos los emprendedores',array('class'=>'button large default'))}}
                </div>
            </div>
        </section>
    </section>
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
                </div>
                <?php
                    $posicion[0]="slideRight";
                    $posicion[1]="slideUp";
                    $posicion[2]="slideLeft";
                    $i=0;
                ?>
                @if(count($blogs) > 0)
                    <div class="row">
                        @foreach($blogs as $blog)
                            <div class="col-sm-6 col-lg-4 {{$posicion[$i]}}">
                                <? $i++;?>
                                <article class="entry">
                                    <div class="entry-image">
                                        <div class="work-item">
                                            {{HTML::image('Orb/images/entradas/'.$blog->imagen) }}
                                            <div class="image-extra">
                                                <div class="extra-content">
                                                    <div class="inner-extra">
                                                        {{ HTML::link('blogs/'.$blog->slug.'/'.$blog->id, null, ['class'=>"single-image emo-icon"]) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="entry-meta">
                                        <span class="date"><a style="color: #5b5e60;">{{$blog->publicacion}}</a></span>
                                        <span class="comments">{{$blog->comentarios}} Comentarios</span>
                                    </div>
                                    <h2 class="entry-title">
                                        {{ HTML::link('blogs/'.$blog->slug.'/'.$blog->id, $blog->titulo)}}
                                    </h2>
                                    <div class="entry-body">
                                        <p>
                                            {{substr (strip_tags($blog->entrada), 0, 220)}}...<strong> {{HTML::link('blogs/'.$blog->slug.'/'.$blog->id,'Ver más', ['class'=>'azul'])}}</strong>
                                        </p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12">
                        <div class="align-center opacity">
                            {{HTML::link('blogs','Ver todas las entradas',array('class'=>'button large default'))}}
                        </div>
                    </div>
                @else
                    <div class="row">
                        No hay ninguna entrada registrado
                    </div>
                @endif
            </div>
        </section>
    </section>
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
                </div>
            </div>
        </section>
        <section class="section parallax parallax-bg-4">
            <div class="full-bg-image"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 opacity">
                        @if(Session::get('confirm')||count($errors)>0)
                            <script>
                                location.href = "#contactanos"
                            </script>
                        @endif
                        @if(Session::get('confirm'))
                            <p class="success">¡Gracias por contactarnos, contestaremos tu correo lo m&aacute;s pronto posible!<a class="alert-close" href="#"></a></p><br/>
                        @endif
                        @if(count($errors)>0)
                            <p class="error">¡Por favor, revise los datos del formulario!<a class="alert-close" href="#"></a></p><br/>
                        @endif
                        {{ Form::open(array('url'=>'contacto', 'method' => 'post') )}}
                            <p class="input-block">
                                {{Form::text('name', null, ['placeholder'=>'Nombre'])}}
                                <span class="message-error">{{$errors->first('name')}}</span>
                            </p>
                            <p class="input-block">
                                {{Form::email('email', null, ['placeholder'=>'Correo'])}}
                                <span class="message-error">{{$errors->first('email')}}</span>
                            </p>
                            <p class="input-block">
                                {{Form::text('city', null, ['placeholder'=>'Ciudad'])}}
                                <span class="message-error">{{$errors->first('city')}}</span>
                            </p>
                            <p class="input-block">
                                {{ Form::textarea('message', null, ['placeholder'=>'Mensaje']) }}
                                <span class="message-error">{{$errors->first('message')}}</span>
                            </p>
                            <p class="input-block">
                                {{Form::captcha(['theme' => 'clean'])}}
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
                            </ul>
                        </div>
                        <div class="widget widget_contacts opacity">
                            <ul class="contact-details blanco">
                                <li>Direcci&oacute;n: Sinaloa Ote 119 Alameda, Celaya, Guanajuato, M&eacute;xico </li>
                                <li>Tel&eacute;fono: (461) 6121699 </li>
                                <li>Email: hola@incubamas.com</li>
                                <li>Horarios : 9:00 - 16:00</li>
                            </ul>
                        </div>
                        <div class="widget widget_social opacity">
                            <ul class="social-icons">
                                <li class="twitter">
                                    <a target="_blank" href="https://twitter.com/IncubaMas"><i class="icon-twitter"></i>Twitter</a>
                                </li>
                                <li class="facebook">
                                    <a target="_blank" href="https://www.facebook.com/IncubaMas"><i class="icon-facebook"></i>Facebook</a>
                                </li>
                                <li class="gplus">
                                    <a target="_blank" href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i class="icon-gplus"></i>Gplus</a>
                                </li>
                                <li class="linkedin">
                                    <a target="_blank" href="https://www.linkedin.com/company/incubam%C3%A1s"><i class="icon-linkedin"></i>LinkedIn</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section padding-off">
            <div class="map-wrapper">
                <div class="map-top-overlay"></div>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3736.4576186694894!2d-100.81146974418027!3d20.528448995115742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sSinaloa+119%2C+alamenda%2C+Celaya%2C+Gto.!5e0!3m2!1ses-419!2smx!4v1424726331422" width="100%" height="600" frameborder="0" style="border:0"></iframe>
                </div>
            </div>
        </section>
    </section>
@stop