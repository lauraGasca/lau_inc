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
    <br/>
    <section id="emprendedores" class="page">
        <section class="section padding-bottom-off">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <hgroup class="section-title align-center opacity">
                            <h1>Nuestras empresas
                            @if($filtro<>"todos")
                                - {{$parametro}}
                            @endif
                            </h1>
                            <h2>&quot;Si puedes so&ntilde;arlo, puedes hacerlo&quot;</h2>
                        </hgroup>							
                    </div>
                </div><!--/ .row-->
                @if($filtro=="todos")
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
                @endif
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
            @if($filtro<>"todos")
                <br/><br/>
                <div class="col-xs-12">
                    <div class="align-center opacity">
                        {{HTML::link('incuba/casos/todos','Ver todos los emprendedores',array('class'=>'button large default'))}}
                    </div>
                </div>
            @endif
        </section><!--/ .section-->
    </section><!--/ .page-->
    <br/><br/>
</div>
@stop