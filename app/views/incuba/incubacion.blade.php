@section('menu-in') header-in @stop

@section('blog-c') class="current-menu-item" @stop

@section('inicio') href="{{url('/#inicio')}}" @stop

@section('incuba') href="{{url('/#incuba')}}" @stop

@section('servicios') href="{{url('/#servicios')}}" @stop

@section('casos') href="{{url('/#emprendedores')}}" @stop

@section('blog') href="{{url('/#noticias')}}" @stop

@section('contacto') href="{{url('/#contactanos')}}" @stop

@section('contenido')
    <div id="content">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-xs-12">
                        <div class="project-single-entry">
                            <div class="image-slider">
                                <ul data-timeout="5000">
                                    <li><img alt="" src="{{ URL::asset('accio/images/body/taller en linea INADEM web.png') }}" style="width:100%;"/></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        @if(Session::get('confirm'))
                            <p class="success">¡Gracias por contactarnos, contestaremos tu correo lo m&aacute;s pronto posible!<a class="alert-close" href="#"></a></p>
                        @endif
                        @if(count($errors)>0)
                            <p class="error">¡Por favor revise los datos del formulario!<a class="alert-close" href="#"></a></p>
                        @endif
                        <div>
                            <p>Ingresa la siguiente informaci&oacute;n para inscribirte:</p>
                            {{Form::open(['url'=>'incubacion', 'method' => 'post'])}}
                                <div class="col-md-12">
                                    {{Form::text('name', null, ['placeholder'=>'Nombre'])}}
                                    <span class="message-error">{{$errors->first('name')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    {{Form::text('proy', null, ['placeholder'=>'Proyecto a Emprender'])}}
                                    <span class="message-error">{{$errors->first('proy')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    {{Form::select('estado', [null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                                    'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                                    'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                                    'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                    'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                                    'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                                    'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                                    'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán', 'Zacatecas'=>'Zacatecas'])}}
                                    <span class="message-error">{{$errors->first('estado')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    {{ Form::text('email', null, ['placeholder'=>'Correo Electronico']) }}
                                    <span class="message-error">{{$errors->first('email')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    {{ Form::text('telefono', null, ['placeholder'=>'Telefono']) }}
                                    <span class="message-error">{{$errors->first('telefono')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    {{ Form::textarea('dudas', null, ['placeholder'=>'Dudas o comentarios']) }}
                                    <span class="message-error">{{$errors->first('dudas')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    {{Form::captcha(['theme' => 'clean'])}}
                                    <span class="message-error">{{$errors->first('recaptcha_response_field')}}</span>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    <button class="button turquoise submit" type="submit" id="submit">Enviar</button>
                                </div>
                                <button class="btn btn-default"></button>
                                <div class="g-recaptcha" data-sitekey="6Ldd3gsTAAAAAPW7OksSy7M8KUF1NSyrCx77pwhX"></div>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop