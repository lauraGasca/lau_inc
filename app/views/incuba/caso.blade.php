@section('menu')
    <header id="header">
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
                    <li>{{HTML::link('incuba#inicio','Inicio')}}</li>
                    <li>{{HTML::link('incuba#incuba','Incuba')}}</li>
                    <li>{{HTML::link('incuba#servicios','Servicios')}}</li>
                    <li class="current-menu-item">{{HTML::link('incuba#emprendedores','Emprendedores')}}</li>
                    <li>{{HTML::link('incuba#blog','Blog')}}</li>
                    <li>{{HTML::link('incuba#nosotros','Nosotros')}}</li>
                    <li>{{HTML::link('incuba#contactanos','Cont&aacute;ctanos')}}</li>
                </ul>
            </nav><!--/ #navigation-->			    
        </div><!--/ .header-in-->
    </header><!--/ #header-->
@stop

@section('contenido')
        <div id="content">
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="project-page-header">
                                <h1 class="project-title">{{$caso->nombre_proyecto}}</h1>
                                <!--<ul class="project-nav clearfix">
                                    <li><a class="prev" href="project-single-2.html">Prev</a></li>
                                    <li><a class="all-projects" href="index.html#folio">All Projects</a></li>
                                    <li><a class="next" href="project-single-4.html">Next</a></li>
                                </ul>/ .project-nav-->
                            </div><!--/ .folio-page-header-->
                        </div>
                    </div><!--/ .row-->
                    <?php $nombre_proyecto = $caso->nombre_proyecto;?>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="project-single-entry">
                                <div class="image-slider">
                                    <ul data-timeout="5000">
                                        <li><img src="{{ URL::asset('Orb/images/casos_exito/'.$caso->imagen) }}" alt="" /></li>
                                    </ul>
                                </div><!--/ .image-slider-->
                            </div><!--/ .folio-single-entry-->
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if(Session::get('confirm'))
                               <script>
                                    alert("¡Gracias por contactarnos, contestaremos tu correo lo m\u00e1s pronto posible!");
                                </script>
                            @endif
                            @if(count($errors)>0)
                               <script>
                                    alert("¡Por favor, revise los datos del formulario!");
                                </script>
                            @endif
                            <h2 class="content-title">Acerca del Proyecto</h2>
                            <p>
                                {{$caso->about_proyect}}
                            </p><br/>
                            <ul class="project-meta">
                                <li>
                                    <span class="project-meta-title">Categoria</span>
                                    <div class="project-meta-date">
                                        {{HTML::link('incuba/casos/categoria/'.$caso->categoria,$caso->categoria)}}
                                    </div>
                                </li>
                                <li>
                                    <span class="project-meta-title">Servicios:</span>
                                    <div class="project-meta-date">
                                        @if(count($tags) > 0)
                                            @foreach($tags as $tag)
                                                {{HTML::link('incuba/casos/servicio/'.$tag->nombre,$tag->nombre)}},
                                            @endforeach
                                        @endif
                                    </div>
                                </li><br/>
                                <li>
                                    <button class="btn btn-primary button large default" data-modal="modal-19">Deseo contactar a este emprendedor</button>
                                </li>
                            </ul><!--/ .project-meta-->
                        </div>
                    </div><!--/ .row-->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="divider"></div>
                        </div>	
                    </div><!--/ .row-->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="content-title">Proyectos relacionados</h2>
                            <div class="project-similar">
                                @if(count($casos) > 0)
                                    <ul id="portfolio-items" class="portfolio-items">
                                    @foreach($casos as $caso)
                                        <li class="{{$caso->categoria}} mix mix_all opacity2x">
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
                                </div><!--/ .project-similar-->
                                @else
                                    </div><!--/ .project-similar-->
                                        No hay proyectos relacionados
                                @endif
                        </div>
                    </div><!--/ .row-->
                </div><!--/ .container-->
            </section><!--/ .section-->
        </div><!--/ #content-->
    </section><!--/ .section-->
    <div id="main-content">
        <div class="md-modal md-effect-1" id="modal-19">
            <div class="md-content md-content-white">
                <h3 style="text-transform:uppercase;  color:#FFF;">Contactar a {{$nombre_proyecto}}</h3>
                <div>
                    <p>Ingresa la siguiente informaci&oacute;n:</p>
                    {{ Form::open(array('url'=>'incuba/emprendedor', 'method' => 'post') )}}
                        {{Form::hidden('emprendedor', $nombre_proyecto)}}
                        <div class="col-md-6">
                            {{Form::text('name', null, array('placeholder'=>'Nombre'))}}
                            <span class="message-error">{{$errors->first('name')}}</span>
                        </div>
                        <div class="col-md-6">
                            {{Form::email('email', null, array('placeholder'=>'Correo'))}}
                            <span class="message-error">{{$errors->first('email')}}</span>
                        </div>
                        <br/><br/><br/>
                        <div class="col-md-6">
                            {{ Form::text('telefono', null, array('placeholder'=>'Telefono')) }}
                            <span class="message-error">{{$errors->first('telefono')}}</span>
                            <br/><br/>
                            {{Form::captcha(array('theme' => 'clean'))}}
                            <span class="message-error">{{$errors->first('recaptcha_response_field')}}</span>
                        </div>
                        <div class="col-md-6">
                            {{Form::textarea('asunto', null, array('placeholder'=>'Asunto'))}}
                            <span class="message-error">{{$errors->first('asunto')}}</span>
                        </div>
                        <div class="col-md-6">
                            <button class="button turquoise submit" type="submit" id="submit">Enviar</button>
                        </div>
                        <button class="btn btn-default"></button>
                    {{Form::close()}}	
                </div>
            </div>
        </div>
        <div class="md-overlay"></div>
    </div> 
@stop

@section('scripts')
    @parent
    <!--Forms-->
    
    <script src="{{ URL::asset('accio/js/jquery-1.11.js') }}"></script>
    <script src="{{ URL::asset('accio/plugins/bootstrap/bootstrap.min.js') }}"></script>
@stop