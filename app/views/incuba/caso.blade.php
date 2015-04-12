@section('menu-in') header-in @stop

@section('casos-c') class="current-menu-item" @stop

@section('inicio') href="{{url('/#inicio')}}" @stop

@section('incuba') href="{{url('/#incuba')}}" @stop

@section('servicios') href="{{url('/#servicios')}}" @stop

@section('casos') href="{{url('/#emprendedores')}}" @stop

@section('blog') href="{{url('/#blog')}}" @stop

@section('contacto') href="{{url('/#contactanos')}}" @stop

@section('contenido')
    <div id="content">
        <section class="section">
            <div class="container">
                <div class="row">
                    <h1 class="project-title" style="color: #02384b; font-weight: 400; font-size: 50px; text-transform: uppercase;" >{{$caso->nombre_proyecto}}</h1>
                    @if(Session::get('confirm'))
                        <p class="success">¡Gracias por contactarnos, contestaremos tu correo lo m&aacute;s pronto posible!<a class="alert-close" href="#"></a></p>
                    @endif
                    @if(count($errors)>0)
                        <p class="error">¡Por favor revise los datos del formulario!<a class="alert-close" href="#"></a></p>
                    @endif
                    <div class="col-md-6 col-xs-12">
                        <div class="project-single-entry">
                            <div class="image-slider">
                                <ul data-timeout="5000" >
                                    <li>{{ HTML::image('Orb/images/casos_exito/'.$caso->imagen)}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <br/><h2 class="content-title" style="color: #02384b;">Acerca del Proyecto</h2>
                        <p style="color: #5b5e60;">{{$caso->about_proyect}}</p>
                        <ul class="project-meta">
                            <li>
                                <span class="project-meta-title">Categoria</span>
                                <div class="project-meta-date">
                                    {{HTML::link('nuestros-emprendedores/categoria/'.$caso->categoria.'/1',$caso->categoria)}}
                                </div>
                            </li>
                            <li>
                                <span class="project-meta-title">Servicios</span>
                                <div class="project-meta-date">
                                    @if(count($caso->servicios) > 0)
                                        @foreach($caso->servicios as $servicio)
                                            {{HTML::link('nuestros-emprendedores/servicio/'.$servicio->nombre.'/'.$servicio->id,$servicio->nombre)}},
                                        @endforeach
                                    @endif
                                </div>
                            </li><br/>
                            <li>
                                <div class="acc-box">
                                    <span class="acc-trigger @if(count($errors)>0) active @endif" data-mode=""><a href="#">Contactar a este emprendedor</a></span>
                                    <div class="acc-container" @if(count($errors)>0) style="display: block;" @endif>
                                        {{Form::open(['url'=>'emprendedor', 'method' => 'post'] )}}
                                            {{Form::hidden('emprendedor', $caso->nombre_proyecto)}}
                                            <div class="col-md-12">
                                                {{Form::text('name', null, ['placeholder'=>'Nombre'])}}
                                                <span class="message-error">{{$errors->first('name')}}</span>
                                            </div><br/>
                                            <div class="col-md-12">
                                                {{Form::email('email', null, ['placeholder'=>'Correo'])}}
                                                <span class="message-error">{{$errors->first('email')}}</span>
                                            </div><br/>
                                            <div class="col-md-12">
                                                {{ Form::text('telefono', null, ['placeholder'=>'Telefono']) }}
                                                <span class="message-error">{{$errors->first('telefono')}}</span>
                                            </div><br/>
                                            <div class="col-md-12">
                                                {{Form::textarea('asunto', null, ['placeholder'=>'Asunto'])}}
                                                <span class="message-error">{{$errors->first('asunto')}}</span>
                                            </div><br/>
                                            <div class="col-md-12">
                                                {{Form::captcha(array('theme' => 'clean'))}}
                                                <span class="message-error">{{$errors->first('recaptcha_response_field')}}</span>
                                            </div><br/>
                                            <div class="col-md-12">
                                                <button class="button turquoise submit" type="submit" id="submit">Enviar</button>
                                            </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="content-title">Proyectos relacionados</h2>
                        @if(count($casos) > 0)
                            <div class="project-similar">
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
                                                            {{HTML::link('nuestros-emprendedores/'.$caso->slug.'/'.$caso->id,'',array('class'=>'single-image link-icon'))}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="project-similar"></div>
                            No hay proyectos relacionados
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop