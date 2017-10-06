@section('menu-in') header-in @stop

@section('casos-c') class="current-menu-item" @stop

@section('inicio') href="{{url('/#inicio')}}" @stop

@section('incuba') href="{{url('/#incuba')}}" @stop

@section('servicios') href="{{url('/#servicios')}}" @stop

@section('casos') href="{{url('/#emprendedores')}}" @stop

@section('blog') href="{{url('/#noticias')}}" @stop

@section('contacto') href="{{url('/#contactanos')}}" @stop
                
@section('contenido')
    <div id="content">
        <br/>
        <section id="emprendedores" class="page">
            <section class="section padding-bottom-off">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <hgroup class="section-title align-center opacity">
                                <h1>Nuestras empresas @if($tipo<>"todos") - {{$slug}} @endif </h1>
                                <h2>&quot;Si puedes so&ntilde;arlo, puedes hacerlo&quot;</h2>
                            </hgroup>
                        </div>
                    </div>
                    @if($tipo=="todos")
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
                    @endif
                </div>
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
                                                {{HTML::link('nuestros-emprendedores/'.$caso->slug.'/'.$caso->id,'',array('class'=>'single-image link-icon'))}}
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
                @if($tipo<>"todos")
                    <br/><br/>
                    <div class="col-xs-12">
                        <div class="align-center opacity">
                            {{HTML::link('nuestros-emprendedores','Ver todos los emprendedores',array('class'=>'button large default'))}}
                        </div>
                    </div>
                @endif
            </section>
        </section>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    </div>
@stop