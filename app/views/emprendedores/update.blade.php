@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/bower_components/bootstrap-calendar/css/calendar.css') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js') }}
    {{ HTML::style('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::script('Orb/bower_components/moment/moment.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js') }}
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
    {{ HTML::script('Orb/js/jquery.maskedinput.js')}}
    <script type="text/javascript">
        $(function () {
            $("#tel_movil").mask("(999) 999-9999");
            $("#tel_fijo").mask("(999) 999-9999");
            $("#curp").mask("aaaa999999aaaaaa**");
            $("#cp").mask("99999");
        });
    </script>
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Emprendedores
        <small>Editar</small>
    </h1>
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="user-profile-info">
                <div class="tabs-white">
                    <ul id="myTab" class="nav nav-tabs nav-justified">
                        <li @if(count($errors)<=0||Session::get('form')==1)class="active" @endif><a href="#emprendedor" data-toggle="tab">Emprendedor</a></li>
                        <li @if(count($errors)>0&&Session::get('form')==2)class="active" @endif><a href="#empresas" data-toggle="tab">Empresas</a></li>
                        <li><a href="#socios" data-toggle="tab">Socios</a></li>
                        <li><a href="#documentos" data-toggle="tab">Documentos</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <!----------------------------------------Emprendedor---------------------------------------->
                        <div class="tab-pane in active" id="emprendedor">
                            <div class="profile-header">Editar Emprendedor</div>
                            {{Form::model($emprendedor, ['url'=>'emprendedores/editar', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                                {{Form::hidden('id')}}
                                <fieldset>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('nombre', '* Nombre', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-user"></i>{{Form::text('nombre', $emprendedor->usuario->nombre)}}
                                            <span class="message-error">{{$errors->first('nombre')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('apellidos', '* Apellidos', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-user"></i>{{Form::text('apellidos', $emprendedor->usuario->apellidos)}}
                                            <span class="message-error">{{$errors->first('apellidos')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-2 espacio_abajo">
                                        {{Form::label('genero', 'Genero', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('genero', [null=>'Selecciona','M'=>'Masculino', 'F'=>'Femenino'])}}
                                            <span class="message-error">{{$errors->first('genero')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('about', 'Acerca de mi', ['class' => 'label'])}}
                                        <label class="textarea">
                                            {{Form::textarea('about',null, ['style'=>'height: 170px;'])}}
                                            <span class="message-error">{{$errors->first('about')}}</span>
                                        </label>
                                        <div class="note"><strong>Nota:</strong>Maximo 500 caracteres</div>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('email', 'Correo electr&oacute;nico', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-envelope"></i>{{Form::email('email', $emprendedor->usuario->email)}}
                                            <span class="message-error">{{$errors->first('email')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('tel_fijo', 'Tel&eacute;fono Fijo', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-phone"></i>{{Form::text('tel_fijo',null, ['id'=>'tel_fijo'])}}
                                            <span class="message-error">{{$errors->first('tel_fijo')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('tel_movil', 'Tel&eacute;fono Movil', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-mobile"></i>{{Form::text('tel_movil',null, ['id'=>'tel_movil'])}}
                                            <span class="message-error">{{$errors->first('tel_movil')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('lugar_nacimiento', 'Lugar de Nacimiento', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-building"></i>{{Form::text('lugar_nacimiento')}}
                                            <span class="message-error">{{$errors->first('lugar_nacimiento')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('curp', '* CURP', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-database"></i>{{Form::text('curp',null,['id'=>'curp'])}}
                                            <span class="message-error">{{$errors->first('curp')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('fecha_nacimiento', '* Fecha de Nacimiento', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend  fa fa-calendar"></i>{{Form::text('fecha_nacimiento', $emprendedor->nac, ['id'=>'fecha_nac', 'readonly'])}}
                                            <span class="message-error">{{$errors->first('fecha_nacimiento')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('escolaridad', 'M&aacute;ximo Nivel Escolar ', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('escolaridad', [null=>'Selecciona', 'Ninguno'=>'Ninguno', 'Primaria'=>'Primaria',
                                            'Secundaria'=>'Secundaria','Preparatoria / Bachillerato'=>'Preparatoria / Bachillerato',
                                            'Carrera Técnica'=>'Carrera Técnica','Licenciatura'=>'Licenciatura','Maestría'=>'Maestría',
                                            'Doctorado'=>'Doctorado'])}}
                                            <span class="message-error">{{$errors->first('escolaridad')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('estado_civil', 'Estado Civil', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('estado_civil', [null=>'Selecciona','Soltero'=>'Soltero', 'Casado'=>'Casado',
                                            'Divorciado'=>'Divorciado','Viudo'=>'Viudo', 'Unión Libre'=>'Unión Libre','Separado'=>'Separado'])}}
                                            <span class="message-error">{{$errors->first('estado_civil')}}</span>
                                        </label>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('calle', '* Calle', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('calle')}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('calle')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('num_ext', '* N&uacute;mero Exterior', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_ext')}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('num_ext')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('num_int', 'N&uacute;mero Interior', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_int')}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('num_int')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('colonia', '* Colonia o Fraccionamiento', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('colonia')}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('colonia')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('municipio', '* Municipio', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('municipio')}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('municipio')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-2 espacio_abajo">
                                        {{Form::label('cp', '* C&oacute;digo Postal', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('cp',null,['id'=>'cp'])}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('cp')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('estado', '* Estado', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('estado', [null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes',
                                            'Baja California'=>'Baja California','Baja California Sur'=>'Baja California Sur',
                                            'Campeche'=>'Campeche','Coahuila'=>'Coahuila','Colima'=>'Colima', 'Chiapas'=>'Chiapas',
                                            'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal','Durango'=>'Durango',
                                            'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                            'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos',
                                            'Nayarit'=>'Nayarit','Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla',
                                            'Querétaro'=>'Querétaro','Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí',
                                            'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora','Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas',
                                            'Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán', 'Zacatecas'=>'Zacatecas'])}}
                                            @if(Session::get('form')==1)
                                                <span class="message-error">{{$errors->first('estado')}}</span>
                                            @endif
                                        </label>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('tiempo_trabajando', 'A&ntilde;os que has Trabajado', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('tiempo_trabajando', [null=>'Selecciona','Menor a 1 año'=>'Menor a 1 año',
                                            '1 – 3 años'=>'1 – 3 años','3 – 5 años'=>'3 – 5 años','5 – 10 años'=>'5 – 10 años',
                                            '10 – 20 años'=>'10 – 20 años','Más de 20 años'=>'Más de 20 años'])}}
                                            <span class="message-error">{{$errors->first('tiempo_trabajando')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('salario_mensual', 'Salario Mensual', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('salario_mensual', [null=>'Selecciona','Menor a $1.841'=>'Menor a $1.841',
                                            '$1.842 - $6.799'=>'$1.842 - $6.799','$6.800 - $11.599'=>'$6.800 - $11.599',
                                            '$11.600 - $34.999'=>'$11.600 - $34.999', '$35.000 - $84.999'=>'$35.000 - $84.999',
                                            'Mayor a  $85.000'=>'Mayor a  $85.000'])}}
                                            <span class="message-error">{{$errors->first('salario_mensual')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('personas_dependen', 'Personas que dependen de ti', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('personas_dependen', [null=>'Selecciona','0'=>'0','1'=>'1','2...'=>'2...',
                                            '...4'=>'...4','5'=>'5','Más de 10'=>'Más de 10'])}}
                                            <span class="message-error">{{$errors->first('personas_dependen')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('emprendido_ant', '* ¿Has emprendido alguna vez?', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('emprendido_ant', [null => 'Selecciona', 1=>'No', 2=>'Si'], null, ['id'=>'emprendido_ant'])}}
                                            <span class="message-error">{{$errors->first('emprendido_ant')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo" id="emprendido" @if($emprendedor->emprendido_ant!=2&&!$errors->first('veces_emprendido')) style="visibility: hidden" @endif >
                                        {{Form::label('veces_emprendido', '* ¿Cuántas veces has emprendido un negocio?', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('veces_emprendido', [null=>'Selecciona','0'=>'0','1'=>'1','2...'=>'2...',
                                            '...4'=>'...4','5'=>'5','Más de 10'=>'Más de 10'], null, ['id'=>'veces_emp'])}}
                                            <span class="message-error">{{$errors->first('veces_emprendido')}}</span>
                                        </label>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('programa', '* Programa', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('programa', [null=>'Selecciona','Emprendedor'=>'Emprendedor', 'Empresarial'=>'Empresarial', 'Programa Especial'=>'Programa Especial'])}}
                                            <span class="message-error">{{$errors->first('programa')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('estatus', '* Estatus', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('estatus', [null=>'Selecciona','Activo'=>'Activo', 'Suspendido'=>'Suspendido', 'Cancelado'=>'Cancelado'])}}
                                            <span class="message-error">{{$errors->first('estatus')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('fecha_ingreso', '* Fecha de Ingreso', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-calendar"></i>{{Form::text('fecha_ingreso',$emprendedor->ing, ['id'=>'fecha_ing', 'readonly'])}}
                                            <span class="message-error">{{$errors->first('fecha_ingreso')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('foto', 'Foto del Emprendedor', ['class' => 'label'])}}
                                        {{Form::file('foto', ['accept'=>"image/*"])}}
                                        <span class="message-error">{{$errors->first('foto')}}</span>
                                        <div class="note"><strong>Nota:</strong>La imagen debe medir 300 x 300</div>
                                    </div>
                                    <div class="col-md-5 espacio_abajo">
                                        {{Form::label('empresa', 'Elimina la foto actual del emprendedor', ['class' => 'label'])}}
                                        {{Form::checkbox('empresa', 'yes')}} Eliminar imagen
                                    </div>
                                </fieldset>
                                <footer>
                                    <div class="col-md-6 espacio_abajo">
                                        {{ Form::submit('Guardar', array('class'=>'btn btn-info')) }}
                                    </div>
                                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                                        * Los campos son obligatorios
                                    </div>
                                </footer>
                            {{Form::close()}}
                        </div>
                        <!----------------------------------------Empresas---------------------------------------->
                        <div class="tab-pane" id="empresas">
                            <div class="profile-header">
                                Editar Empresas&nbsp;&nbsp;
                                {{HTML::link('empresas/crear/'.$emprendedor->id,'Añadir Empresa',array('class'=>'btn btn-primary', 'style'=>'color:#FFF'))}}
                            </div>
                            <!----------------------------------------------Empresas------------------------------------------------------>
                            <div class="tab-pane" id="empresas">
                                @if(count($emprendedor->empresas) > 0)
                                    @foreach($emprendedor->empresas as $empresa)
                                        <br/>
                                        <div class="panel-heading" style="background-color: #82b964; color: #fff;">
                                            <div class="panel-title pull-left">{{$empresa->nombre_empresa}}</div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <table class="table" style="table-layout:fixed">
                                            <tr>
                                                <td><strong>Idea del Negocio:</strong></td>
                                                <td colspan="2">{{$empresa->idea_negocio}}</td>
                                                <td rowspan="4">
                                                    {{ HTML::image('Orb/images/empresas/'.$empresa->logo, $empresa->nombre_empresa, ['class' => 'file-preview-image']) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Problema o Necesidad que resuelve:</strong></td>
                                                <td colspan="2">{{$empresa->necesidad}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Producto o servicio que Ofrece:</strong></td>
                                                <td colspan="2">{{$empresa->producto_servicio}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tipo de R&eacute;gimen Fiscal:</strong></td>
                                                <td colspan="2">{{$empresa->regimen_fiscal}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Rubro y/o Actividad:</strong></td>
                                                <td>{{$empresa->giro_actividad}}</td>
                                                <td colspan="2"
                                                    style="text-align:center; background-color: #F0F0F0;"><strong>Datos
                                                        Fiscales</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%;"><strong>Sector Estrat&eacute;gico:</strong>
                                                </td>
                                                <td style="width: 25%;">{{$empresa->sector}}</td>
                                                <td style="width: 25%;"><strong>Raz&oacute;n Social:</strong></td>
                                                <td style="width: 25%;">{{$empresa->razon_social}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Director General:</strong></td>
                                                <td>{{$empresa->director}}</td>
                                                <td><strong>RFC con Homoclave:</strong></td>
                                                <td>{{$empresa->rfc}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Asistente o Administrador:</strong></td>
                                                <td>{{$empresa->asistente}}</td>
                                                <td><strong>Calle:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->calle}}</td>
                                                @else
                                                    <td>{{$empresa->calle}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><strong>P&aacute;gina Web de la Empresa:</strong></td>
                                                <td>{{$empresa->pagina_web}}</td>
                                                <td><strong>N&uacute;mero exterior:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->num_ext}}</td>
                                                @else
                                                    <td>{{$empresa->num_ext}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><strong>N&uacute;mero interior:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->num_int}}</td>
                                                @else
                                                    <td>{{$empresa->num_int}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if($empresa->financiamiento)
                                                    <td colspan="2"
                                                        style="text-align:center; background-color: #F0F0F0;">
                                                        <strong>Solicitud de Financiamiento</strong></td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                <td><strong>Colonia o Fraccionamiento:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->colonia}}</td>
                                                @else
                                                    <td>{{$empresa->colonia}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if($empresa->financiamiento)
                                                    <td><strong>Monto Solicitado:</strong></td>
                                                    <td>{{$empresa->monto_financiamiento}}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                <td><strong>Municipio:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->municipio}}</td>
                                                @else
                                                    <td>{{$empresa->municipio}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if($empresa->financiamiento)
                                                    <td><strong>Costo Total del Proyecto:</strong></td>
                                                    <td>{{$empresa->costo_proyecto}}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                <td><strong>Estado:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->estado}}</td>
                                                @else
                                                    <td>{{$empresa->estado}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                @if($empresa->financiamiento)
                                                    <td><strong>Aportacion del emprendedor:</strong></td>
                                                    <td>{{$empresa->aportacion}}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                <td><strong>CP:</strong></td>
                                                @if($empresa->negocio_casa)
                                                    <td>{{$emprendedor->cp}}</td>
                                                @else
                                                    <td>{{$empresa->cp}}</td>
                                                @endif
                                            </tr>
                                            <tr><td colspan="4"><br/></td></tr>
                                            <tr>
                                                <td colspan="4">
                                                    {{HTML::link('empresas/editar/'.$empresa->id,'Editar Empresa',array('class'=>'btn btn-warning'))}}
                                                    &nbsp; &nbsp; &nbsp;
                                                    {{HTML::link('empresas/delete/'.$empresa->id,'Eliminar Empresa',array('class'=>'btn btn-danger', 'onClick'=>"return confirm('\u00BFSeguro que deseas eliminar?');"))}}
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @else
                                    <i>No hay empresas registradas</i>
                                @endif
                            </div>
                        </div>
                        <!----------------------------------------Socios---------------------------------------->
                        <div class="tab-pane" id="socios">
                            <div class="profile-header">
                                Socios&nbsp;&nbsp;
                                @if(count($emprendedor->empresas) > 0)
                                    {{HTML::link('emprendedores/crear-socio/'.$emprendedor->id,'Agregar Socios',array('class'=>'btn btn-primary', 'style'=>'color:#FFF'))}}
                                @else
                                    <span style="font-style: italic; color: rgb(205, 205, 205); font-size: 15px;">Para agregar socios, añade primero la empresa</span>
                                @endif
                            </div>
                            <fieldset><br/>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Empresa</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($socios) > 0)
                                            @foreach($socios as $socio)
                                                <tr>
                                                    <td>{{$socio->nombre}} {{$socio->apellidos}}</td>
                                                    <td>{{$socio->email}}</td>
                                                    <td>{{$socio->telefono}}</td>
                                                    <td>{{$socio->empresa->nombre_empresa}}</td>
                                                    <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/delete-socio/'.$socio->id)}}"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" style="font-style: italic; color: rgb(155, 155, 155);">No hay socios</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                        <!----------------------------------------Documentos---------------------------------------->
                        <div class="tab-pane" id="documentos">
                            <div class="profile-header">
                                Editar Documentos
                                {{HTML::link('emprendedores/subir-documento/'.$emprendedor->id,'Subir Documentos',array('class'=>'btn btn-primary', 'style'=>'color:#FFF'))}}
                            </div>
                            <fieldset><br/>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Fecha de Subida</th>
                                        <th colspan="2">Pertenece A</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($subidas) > 0)
                                        @foreach($subidas as $subida)
                                            <tr>
                                                @if($subida->documento_id<>20)
                                                    <td>{{$subida->documentos->nombre}}</td>
                                                @else
                                                    <td>{{$subida->nombre}}</td>
                                                @endif
                                                <td>{{$subida->subida}}</td>

                                                @if($subida->socio_id<>'')
                                                    <td><strong>Socio: </strong>{{$subida->socio->nombre}} {{$subida->socio->apellidos}}</td>
                                                @else
                                                    @if($subida->empresa_id<>'')
                                                        <td><strong>Empresa: </strong>{{$subida->empresa->nombre_empresa}}</td>
                                                    @else
                                                        <td>{{$emprendedor->usuario->nombre}} {{$emprendedor->usuario->apellidos}}</td>
                                                    @endif
                                                @endif
                                                <td><a target="_blank" href="{{URL::asset('Orb/documentos/'.$subida->documento)}}"><span class="glyphicon glyphicon-cloud-download"></span></a></td>
                                                <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/delete-documento/'.$subida->id)}}"><i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('Orb/bower_components/underscore/underscore-min.js') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/calendar.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}
    <script type="text/javascript">
        $( "#emprendido_ant" ).change(function() {
            if(emprendido_ant.selectedIndex == 2) {
                $("#emprendido").css('visibility', 'visible');
            }else {
                $("#emprendido").css('visibility', 'hidden');
                $("#veces_emp").val('');
            }
        });
        $(function () {
            $('#fecha_nac').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate: '1/1/1940',
                defaultDate: '1/1/1980',
                maxDate: '1/1/2000'
            });
            $('#fecha_ing').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate: '1/1/2000',
                defaultDate: new Date(),
                maxDate: new Date()
            });
        });
        $("#foto").fileinput({
            previewFileType: "image",
            initialPreview: [
                "<img src='{{url('Orb/images/emprendedores/'.$emprendedor->usuario->foto)}}' class='file-preview-image'>"
            ],
            browseClass: "btn btn-success",
            browseLabel: " Seleccionar otra foto",
            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
            showCaption: false,
            showRemove: false,
            showUpload: false
        });
    </script>
@stop