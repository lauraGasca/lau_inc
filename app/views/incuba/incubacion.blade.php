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
                        <div class="col-md-8 col-xs-12">
                            <div class="project-single-entry">
                                <div class="image-slider">
                                    <ul data-timeout="5000">
                                        <li><img alt="" src="{{ URL::asset('accio/images/body/taller en linea INADEM web.png') }}" style="width:100%;"/></li>
                                    </ul>
                                </div><!--/ .image-slider-->
                            </div><!--/ .folio-single-entry-->
                        </div>
                        <div class="col-md-4 col-xs-12">
                            @if(Session::get('confirm'))
                               <script>
                                    alert("¡Gracias por contactarnos, contestaremos tu correo lo m\u00e1s pronto posible!");
                                </script>
                            @endif
                            <div>
                                <p>Ingresa la siguiente informaci&oacute;n para inscribirte:</p>
                                {{ Form::open(array('url'=>'incuba/incubacion', 'method' => 'post',  'novalidate') )}}
                                    <div class="col-md-12">
                                        {{Form::text('name', null, array('placeholder'=>'Nombre'))}}
                                        <span class="message-error">{{$errors->first('name')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        {{Form::text('proy', null, array('placeholder'=>'Proyecto a Emprender'))}}
                                        <span class="message-error">{{$errors->first('proy')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        {{Form::select('estado', array(null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                                        'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                                        'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                                        'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                        'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                                        'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                                        'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                                        'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán', 'Zacatecas'=>'Zacatecas'))}}
                                        <span class="message-error">{{$errors->first('estado')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        {{ Form::text('email', null, array('placeholder'=>'Correo Electronico')) }}
                                        <span class="message-error">{{$errors->first('email')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        {{ Form::text('telefono', null, array('placeholder'=>'Telefono')) }}
                                        <span class="message-error">{{$errors->first('telefono')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        {{ Form::textarea('dudas', null, array('placeholder'=>'Dudas o comentarios')) }}
                                        <span class="message-error">{{$errors->first('dudas')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        {{Form::captcha(array('theme' => 'clean'))}}
                                        <span class="message-error">{{$errors->first('recaptcha_response_field')}}</span>
                                    </div>
                                    <br/>
                                    <div class="col-md-12">
                                        <button class="button turquoise submit" type="submit" id="submit">Enviar</button>
                                    </div>
                                    <button class="btn btn-default"></button>
                                {{Form::close()}}	
                            </div>
                        </div>
                    </div><!--/ .row-->
                </div><!--/ .container-->
            </section><!--/ .section-->
        </div><!--/ #content-->
@stop

@section('scripts')
    @parent
    <!--Forms-->
    
    <script src="{{ URL::asset('accio/js/jquery-1.11.js') }}"></script>
    <script src="{{ URL::asset('accio/plugins/bootstrap/bootstrap.min.js') }}"></script>
@stop