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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i
                        class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i
                        class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="user-profile-info">
                <div class="tabs-white">
                    <ul id="myTab" class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#emprendedor" data-toggle="tab">Emprendedor</a></li>
                        <li><a href="#empresas" data-toggle="tab">Empresas</a></li>
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
                                            <span class="message-error">{{$errors->first('calle')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('num_ext', '* N&uacute;mero Exterior', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_ext')}}
                                            <span class="message-error">{{$errors->first('num_ext')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-3 espacio_abajo">
                                        {{Form::label('num_int', 'N&uacute;mero Interior', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_int')}}
                                            <span class="message-error">{{$errors->first('num_int')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('colonia', '* Colonia o Fraccionamiento', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('colonia')}}
                                            <span class="message-error">{{$errors->first('colonia')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 espacio_abajo">
                                        {{Form::label('municipio', '* Municipio', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('municipio')}}
                                            <span class="message-error">{{$errors->first('municipio')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-2 espacio_abajo">
                                        {{Form::label('cp', '* C&oacute;digo Postal', ['class' => 'label'])}}
                                        <label class="input">
                                            <i class="icon-prepend fa fa-book"></i>{{Form::text('cp',null,['id'=>'cp'])}}
                                            <span class="message-error">{{$errors->first('cp')}}</span>
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
                                            <span class="message-error">{{$errors->first('estado')}}</span>
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
                                            {{Form::select('emprendido_ant', [null => 'Selecciona', 1=>'No', 2=>'Si'], null, ['id'=>'select'])}}
                                            <span class="message-error">{{$errors->first('emprendido_ant')}}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-5 espacio_abajo" id="emprendido" @if($emprendedor->emprendido_ant!=2&&!$errors->first('veces_emprendido')) style="visibility: hidden" @endif >
                                        {{Form::label('veces_emprendido', '* ¿Cuántas veces has emprendido un negocio?', ['class' => 'label'])}}
                                        <label class="select">
                                            {{Form::select('veces_emprendido', [null=>'Selecciona','0'=>'0','1'=>'1','2...'=>'2...',
                                            '...4'=>'...4','5'=>'5','Más de 10'=>'Más de 10'], null)}}
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
                                        {{ Form::submit('Guardar', array('class'=>'btn btn-default')) }}
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
                                {{HTML::link('emprendedores/crearempresa/'.$emprendedor->id,'Añadir Empresa',array('class'=>'btn btn-default', 'style'=>'color:#FFF'))}}
                            </div>
                            @if(count($empresas) > 0)
                                @foreach($empresas as $empresa)
                                    {{ Form::open(array('url'=>'emprendedores/editarempresa', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
                                    {{Form::hidden('emprendedor_id', $emprendedor->id)}}
                                    {{Form::hidden('empresa_id', $empresa->id)}}
                                    <fieldset>
                                        <div class="col-md-6 espacio_abajo">
                                            <a onClick="return confirm('\u00BFSeguro que deseas eliminar?');"
                                               href="{{url('emprendedores/deleteempresa/'.$empresa->id)}}"><i
                                                        class="fa fa-trash-o"></i> Eliminar {{$empresa->nombre_empresa}}
                                            </a>
                                        </div>
                                        <span class="message-error">{{$errors->first('emprendedor_id')}}</span>

                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('nombre_empresa', '* Nombre del proyecto', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-building"></i>
                                                {{Form::text('nombre_empresa', $empresa->nombre_empresa)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('nombre_empresa')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('regimen', 'Tipo de  Régimen fiscal', array('class' => 'label'))}}
                                            <label class="select">
                                                {{Form::select('regimen', array(null=>'Selecciona', 'Incorporaci&oacute;n Fiscal'=>'Incorporaci&oacute;n Fiscal', 'Actividad Empresarial y Profesional'=>'Actividad Empresarial y Profesional'), $empresa->regimen_fiscal)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('regimen')}}</span>
                                        </div>
                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('idea', '* Describe la idea de negocio o las actividades de tu empresa/negocio ', array('class' => 'label'))}}
                                            <label class="textarea">
                                                {{Form::textarea('idea', $empresa->idea_negocio)}}
                                            </label>

                                            <div class="note">
                                                <strong>
                                                    Nota:
                                                </strong>
                                                Maximo 500 caracteres
                                            </div>
                                            <span class="message-error">{{$errors->first('idea')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('necesidad', '¿Qu&eacute; problema o necesidad resuelves con esto?', array('class' => 'label'))}}
                                            <label class="textarea">
                                                {{Form::textarea('necesidad', $empresa->necesidad)}}
                                            </label>

                                            <div class="note">
                                                <strong>
                                                    Nota:
                                                </strong>
                                                Maximo 500 caracteres
                                            </div>
                                            <span class="message-error">{{$errors->first('necesidad')}}</span>
                                        </div>
                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('producto_serv', '* Describe el producto o servicio que ofreces o quieres ofrecer', array('class' => 'label'))}}
                                            <label class="textarea">
                                                {{Form::textarea('producto_serv', $empresa->producto_servicio, array('style'=>'height: 200px;'))}}
                                            </label>

                                            <div class="note">
                                                <strong>
                                                    Nota:
                                                </strong>
                                                Maximo 500 caracteres
                                            </div>
                                            <span class="message-error">{{$errors->first('producto_serv')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            <br/>{{Form::label('director', 'Director General', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-group"></i>
                                                {{Form::text('director', $empresa->director)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('director')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('asistente', 'Asistente o Administrador', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-group"></i>
                                                {{Form::text('asistente', $empresa->asistente)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('asistente')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('pagina', 'Página Web de la Empresa', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-globe"></i>
                                                {{Form::text('pagina', $empresa->pagina_web)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('pagina')}}</span><br/><br/>
                                        </div>
                                        <div class="col-md-4 espacio_abajo">
                                            {{Form::label('rubro', 'Rubro Giro y/o Actividad', array('class' => 'label'))}}
                                            <label class="select">
                                                {{Form::select('rubro', array(null=>'Selecciona', 'Servicio y Comercio'=>'Servicio y Comercio',
                                                'Industria Ligera'=>'Industria Ligera'), $empresa->giro_actividad)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('rubro')}}</span>
                                        </div>
                                        <div class="col-md-4 espacio_abajo">
                                            {{Form::label('sector', 'Sector Estrat&eacute;gico', array('class' => 'label'))}}
                                            <label class="select">
                                                {{Form::select('sector', array(null=>'Selecciona', 'Agro industrial'=>'Agro industrial','Automotriz'=>'Automotriz',
                                                'Productos Químicos'=>'Productos Químicos','Cuero Calzado'=>'Cuero Calzado',
                                                'Servicios de Investigación'=>'Servicios de Investigación','Turístico'=>'Turístico',
                                                'Equipo medico'=>'Equipo medico','Farmacéuticos y Cosméticos'=>'Farmacéuticos y Cosméticos',
                                                'Aeronáutica'=>'Aeronáutica','Construcción'=>'Construcción','Químico'=>'Químico',
                                                'Agricultura'=>'Agricultura','Comercio'=>'Comercio','Software'=>'Software',
                                                'Electrónica'=>'Electrónica','Textil y Confección'=>'Textil y Confección',
                                                'Maquiladoras'=>'Maquiladoras','Otro'=>'Otro'), $empresa->sector)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('sector')}}</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="col-md-11 espacio_abajo">
                                            <h3>Datos Fiscales</h3><br/>
                                        </div>
                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('razon_social', '* Raz&oacute;n Social', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-building"></i>
                                                {{Form::text('razon_social', $empresa->razon_social)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('razon_social')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('rfc', 'RCF con homoclave', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-gavel"></i>
                                                {{Form::text('rfc', $empresa->rfc)}}
                                            </label>
                                            <span class="message-error">{{$errors->first('rfc')}}</span>
                                        </div>
                                        <div class="col-md-11 espacio_abajo">
                                            {{Form::label('negocio_casa', '¿La dirección de tu negocio es la misma que tú casa?', array('class' => 'label'))}}
                                            <label class="select">
                                                {{Form::select('negocio_casa', array(false=>'No',true=>'Si'), $empresa->negocio_casa, array('id'=>'select', 'onchange'=>'evento(1);'))}}
                                            </label>

                                            <div class="note">
                                                <strong>
                                                    Nota:
                                                </strong>
                                                En caso de que si, omitir la direcci&oacute;n
                                            </div>
                                            <span class="message-error">{{$errors->first('negocio_casa')}}</span>
                                        </div>
                                        <div class="col-md-4 espacio_abajo">
                                            {{Form::label('calle_e', 'Calle', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-book"></i>
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::text('calle_e', $empresa->calle, array('id'=>'calle_e', 'class'=>'empresa'))}}
                                                @else
                                                    {{Form::text('calle_e', $emprendedor->calle ,array('id'=>'calle_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('calle_e')}}</span>
                                        </div>
                                        <div class="col-md-3 espacio_abajo">
                                            {{Form::label('num_ext', 'N&uacute;mero Exterior', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-slack"></i>
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::text('num_ext_e', $empresa->num_ext, array('id'=>'num_ext_e', 'class'=>'empresa'))}}
                                                @else
                                                    {{Form::text('num_ext_e', $emprendedor->num_ext ,array('id'=>'num_ext_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('num_ext_e')}}</span>
                                        </div>
                                        <div class="col-md-3 espacio_abajo">
                                            {{Form::label('num_int', 'N&uacute;mero Interior', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-slack"></i>
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::text('num_int_e', $empresa->num_int, array('id'=>'num_int_e','class'=>'empresa'))}}
                                                @else
                                                    {{Form::text('num_int_e', $emprendedor->num_int ,array('id'=>'num_int_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('num_int_e')}}</span>
                                        </div>
                                        <div class="col-md-4 espacio_abajo">
                                            {{Form::label('colonia', 'Colonia o Fraccionamiento', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-book"></i>
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::text('colonia_e', $empresa->colonia , array('id'=>'colonia_e','class'=>'empresa'))}}
                                                @else
                                                    {{Form::text('colonia_e', $emprendedor->colonia ,array('id'=>'colonia_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('colonia_e')}}</span>
                                        </div>
                                        <div class="col-md-4 espacio_abajo">
                                            {{Form::label('municipio', 'Municipio', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-book"></i>
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::text('municipio_e', $empresa->municipio, array('id'=>'municipio_e'))}}
                                                @else
                                                    {{Form::text('municipio_e', $emprendedor->municipio ,array('id'=>'municipio_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('municipio_e')}}</span>
                                        </div>
                                        <div class="col-md-2 espacio_abajo">
                                            {{Form::label('cp', 'C&oacute;digo Postal', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-book"></i>
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::text('cp_e', $empresa->cp, array('id'=>'cp_e'))}}
                                                @else
                                                    {{Form::text('cp_e', $emprendedor->cp ,array('id'=>'cp_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('cp_e')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('estado', 'Estado', array('class' => 'label'))}}
                                            <label class="select">
                                                @if($empresa->negocio_casa==0)
                                                    {{Form::select('estado_e', array(null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                                                    'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                                                    'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                                                    'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                                    'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                                                    'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                                                    'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                                                    'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán',
                                                    'Zacatecas'=>'Zacatecas'), $empresa->estado, array('id'=>'estado_e'))}}
                                                @else
                                                    {{Form::select('estado_e', array(null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                                                    'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                                                    'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                                                    'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                                    'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                                                    'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                                                    'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                                                    'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán',
                                                    'Zacatecas'=>'Zacatecas'), $emprendedor->estado, array('id'=>'estado_e','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('estado_e')}}</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('financiamiento', '* ¿Desea acceder a un financiamiento?', array('class' => 'label'))}}
                                            <label class="select">
                                                {{Form::select('financiamiento', array(false=>'No',true=>'Si'), $empresa->financiamiento, array('id'=>'select2', 'onchange'=>'codigo3();'))}}
                                            </label>
                                            <span class="message-error">{{$errors->first('financiamiento')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('monto', 'Monto a solicitar del financiamiento', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-money"></i>
                                                @if($empresa->financiamiento==1)
                                                    {{Form::text('monto', $empresa->monto_financiamiento,array('id'=>'monto'))}}
                                                @else
                                                    {{Form::text('monto','',array('id'=>'monto','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('monto')}}</span>
                                        </div>
                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('costo_proyecto', 'Costo total del proyecto', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-money"></i>
                                                @if($empresa->financiamiento==1)
                                                    {{Form::text('costo_proyecto', $empresa->costo_proyecto,array('id'=>'costo'))}}
                                                @else
                                                    {{Form::text('costo_proyecto', '',array('id'=>'costo','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('costo_proyecto')}}</span>
                                        </div>
                                        <div class="col-md-5 espacio_abajo">
                                            {{Form::label('aportacion', 'Aportación de Emprendedor', array('class' => 'label'))}}
                                            <label class="input">
                                                <i class="icon-prepend fa fa-money"></i>
                                                @if($empresa->financiamiento==1)
                                                    {{Form::text('aportacion', $empresa->aportacion,array('id'=>'aportacion'))}}
                                                @else
                                                    {{Form::text('aportacion', '',array('id'=>'aportacion','disabled'=>''))}}
                                                @endif
                                            </label>
                                            <span class="message-error">{{$errors->first('aportacion')}}</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="col-md-6 espacio_abajo">
                                            {{Form::label('imagen', 'Logo', array('class' => 'label'))}}
                                            <img class="img-rounded img-responsive"
                                                 src="{{URL::asset('Orb/images/empresas/'.$empresa->logo)}}"
                                                 alt="Empresa" style="width: 300px;">
                                            <br/>{{Form::file('imagen')}}
                                            <span class="message-error">{{$errors->first('imagen')}}</span>

                                            <div class="note">
                                                <strong>
                                                    Nota:
                                                </strong>
                                                La imagen debe medir 300 x 300
                                            </div>
                                            {{Form::checkbox('empresa', 'yes')}} Eliminar imagen
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="col-md-6 espacio_abajo">
                                            {{ Form::submit('Guardar', array('class'=>'btn btn-default')) }}
                                        </div>
                                        <div class="col-md-5 espacio_abajo" style="text-align: right;">
                                            * Los campos son obligatorios
                                        </div>
                                    </fieldset>
                                    {{Form::close()}}
                                    <div class="profile-header"></div>
                                @endforeach
                            @else
                                <i>No hay empresas registradas</i>
                            @endif
                        </div>
                        <!----------------------------------------Socios---------------------------------------->
                        <div class="tab-pane" id="socios">
                            <div class="profile-header">
                                Socios
                                <a href="#myModal3" role="button" class="btn btn-default" data-toggle="modal">Agregar
                                    Socios</a>
                            </div>
                            <fieldset>
                                <br/>
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
                                                <td>{{$socio->nombre_empresa}}</td>
                                                <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');"
                                                       href="{{url('emprendedores/deletesocio/'.$socio->id)}}"><i
                                                                class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                        <!----------------------------------------Documentos---------------------------------------->
                        <div class="tab-pane" id="documentos">
                            <div class="profile-header">
                                Editar Documentos
                                <a href="#myModal1" role="button" data-target="#myModal1" class="btn btn-default"
                                   data-toggle="modal">Subir Documentos</a>
                            </div>
                            <fieldset>
                                <br/>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Documentos</th>
                                        <th>Fecha de Subida</th>
                                        <th>Nombre</th>
                                        <th>Empresa</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($subidas) > 0)
                                        @foreach($subidas as $subida)
                                            <tr>
                                                @if($subida->nombre=='Otro...')
                                                    <td>{{$subida->nombre_sub}}</td>
                                                @else
                                                    <td>{{$subida->nombre}}</td>
                                                @endif
                                                <?php
                                                $date = date_create($subida->created_at);
                                                $fecha = date_format($date, 'd-m-Y');
                                                ?>
                                                <td>{{$fecha}}</td>
                                                @if($subida->socio_id<>'')
                                                    <td>{{$subida->nombre_socio}}</td>
                                                @else
                                                    <td>{{$subida->name}} {{$subida->apellidos}}</td>
                                                @endif
                                                <td>{{$subida->nombre_empresa}}</td>
                                                <td><a target="_blank"
                                                       href="{{URL::asset('Orb/documentos/'.$subida->documento)}}"><span
                                                                class="glyphicon glyphicon-cloud-download"></span></a>
                                                </td>
                                                <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');"
                                                       href="{{url('emprendedores/deletedocumento/'.$subida->id."/".$emprendedor->id)}}"><i
                                                                class="fa fa-trash-o"></i></a></td>
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
            <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="false">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Subir Documentos</h4>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(array('url'=>'emprendedores/subirdocumento', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
                            {{Form::hidden('emprendedor_id',$emprendedor->id)}}
                            <span class="message-error">{{$errors->first('emprendedor')}}</span>
                            <fieldset>
                                <div class="col-md-6 espacio_abajo">
                                    {{Form::label('empresa', '* Empresa', array('class' => 'label'))}}
                                    <label class="select">
                                        {{Form::select('empresa', $empresas_listado)}}
                                    </label>
                                    <span class="message-error">{{$errors->first('empresa')}}</span>
                                </div>
                                <div class="col-md-5 espacio_abajo">
                                    @if(count($socios_listado)>0)
                                        {{Form::checkbox('emprendedor', 'yes', 'yes',array('id'=>'emp_event','onchange'=>'evento(3);'))}}
                                        Documento del emprendedor
                                    @else
                                        {{Form::checkbox('emprendedor', 'yes', 'yes', array('disabled'=>''))}} Documento
                                        del emprendedor
                                    @endif
                                    <label class="select">
                                        {{Form::select('socios', $socios_listado,null, array('id'=>'socios_event','disabled'=>''))}}
                                    </label>
                                    <span class="message-error">{{$errors->first('socios')}}</span>
                                </div>
                                <div class="col-md-6 espacio_abajo">
                                    {{Form::label('documento', '* Documento', array('class' => 'label'))}}
                                    <label class="select">
                                        {{Form::select('documento', $documentos, null, array('id'=>'doc_event', 'onchange'=>'evento(2);'))}}
                                    </label>
                                    <span class="message-error">{{$errors->first('documento')}}</span>
                                </div>
                                <div class="col-md-5 espacio_abajo">
                                    {{Form::label('nombre', 'Otro...', array('class' => 'label'))}}
                                    <label class="input">
                                        <i class="icon-prepend fa fa-archive"></i>
                                        {{Form::text('nombre','',array('id'=>'otro','disabled'=>''))}}
                                    </label>
                                    <span class="message-error">{{$errors->first('nombre')}}</span>
                                </div>
                                <div class="col-md-6 espacio_abajo">
                                    {{Form::label('imagen', '* Documento', array('class' => 'label'))}}
                                    {{Form::file('imagen')}}
                                    <span class="message-error">{{$errors->first('imagen')}}</span>
                                </div>

                                <div class="col-md-11 espacio_abajo" style="text-align: left;">
                                    * Los campos son obligatorios
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Subir</button>
                            {{Form::close()}}
                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Agregar Socio</h4>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(array('url'=>'emprendedores/crearsocio', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
                            {{Form::hidden('emprendedor_id',$emprendedor->id)}}
                            <fieldset>
                                <div class="col-md-11 espacio_abajo">
                                    {{Form::label('empresa_id', '* Empresas', array('class' => 'label'))}}
                                    <label class="select">
                                        {{Form::select('empresa_id', $empresas_listado)}}
                                    </label>
                                    <span class="message-error">{{$errors->first('empresa_id')}}</span>
                                </div>
                                <div class="col-md-6 espacio_abajo">
                                    {{Form::label('nombre', '* Nombre', array('class' => 'label'))}}
                                    <label class="input">
                                        <i class="icon-prepend fa fa-user"></i>
                                        {{Form::text('nombre')}}
                                    </label>
                                    <span class="message-error">{{$errors->first('nombre')}}</span>
                                </div>
                                <div class="col-md-5 espacio_abajo">
                                    {{Form::label('apellidos', '* Apellidos', array('class' => 'label'))}}
                                    <label class="input">
                                        <i class="icon-prepend fa fa-user"></i>
                                        {{Form::text('apellidos')}}
                                    </label>
                                    <span class="message-error">{{$errors->first('apellidos')}}</span>
                                </div>
                                <div class="col-md-6 espacio_abajo">
                                    {{Form::label('email', '* Email', array('class' => 'label'))}}
                                    <label class="input">
                                        <i class="icon-prepend fa fa-envelope"></i>
                                        {{Form::text('email')}}
                                    </label>
                                    <span class="message-error">{{$errors->first('email')}}</span>
                                </div>
                                <div class="col-md-5 espacio_abajo">
                                    {{Form::label('telefono', '* Telefono', array('class' => 'label'))}}
                                    <label class="input">
                                        <i class="icon-prepend fa fa-phone"></i>
                                        {{Form::text('telefono')}}
                                    </label>
                                    <span class="message-error">{{$errors->first('telefono')}}</span>
                                </div>
                                <div class="col-md-11 espacio_abajo" style="text-align: left;">
                                    * Los campos son obligatorios
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Crear</button>
                            {{Form::close()}}
                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>
            function evento(i) {
                switch (i) {
                    case 1:
                        var select = document.getElementById("select");
                        var calle = document.getElementById("calle_e");
                        var num_int = document.getElementById("num_int_e");
                        var num_ext = document.getElementById("num_ext_e");
                        var colonia = document.getElementById("colonia_e");
                        var cp = document.getElementById("cp_e");
                        var estado = document.getElementById("estado_e");
                        var municipio = document.getElementById("municipio_e");
                        if (select.selectedIndex == 1) {
                            calle.disabled = true;
                            num_int.disabled = true;
                            num_ext.disabled = true;
                            colonia.disabled = true;
                            cp.disabled = true;
                            estado.disabled = true;
                            municipio.disabled = true;
                            calle.value = "";
                            num_int.value = ""
                            num_ext.value = ""
                            colonia.value = ""
                            cp.value = ""
                            estado.value = ""
                            municipio.value = ""
                        }
                        if (select.selectedIndex == 0) {
                            calle.disabled = false;
                            num_int.disabled = false;
                            num_ext.disabled = false;
                            colonia.disabled = false;
                            cp.disabled = false;
                            estado.disabled = false;
                            municipio.disabled = false;
                        }
                        break;
                    case 2:
                        var select = document.getElementById("doc_event");
                        var otro = document.getElementById("otro");
                        if (select.value == 20)
                            otro.disabled = false;
                        else {
                            otro.disabled = true;
                            otro.value = "";
                        }
                        break;
                    case 3:
                        var select = document.getElementById("emp_event");
                        var socios = document.getElementById("socios_event");
                        if (select.checked == 0) {
                            socios.disabled = false;
                        } else {
                            socios.disabled = true;
                            socios.value = "";
                        }
                        break;
                }
            }
            function codigo2() {
                var select = document.getElementById("select_emp");
                var veces = document.getElementById("veces");
                if (select.selectedIndex == 1) {
                    veces.disabled = false;
                }
                if (select.selectedIndex == 0) {
                    veces.disabled = true;
                    veces.value = ""
                }
            }
            function codigo3() {
                var select = document.getElementById("select2");
                var monto = document.getElementById("monto");
                var costo = document.getElementById("costo");
                var aportacion = document.getElementById("aportacion");
                if (select.selectedIndex == 0) {
                    monto.disabled = true;
                    costo.disabled = true;
                    aportacion.disabled = true;
                    costo.value = "";
                    monto.value = ""
                    aportacion.value = ""
                }
                if (select.selectedIndex == 1) {
                    monto.disabled = false;
                    costo.disabled = false;
                    aportacion.disabled = false;
                }
            }
        </script>
        <!-- End .powerwidget -->
        @stop

@section('scripts')
    @parent
    {{ HTML::script('Orb/bower_components/underscore/underscore-min.js') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/calendar.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}
    <script type="text/javascript">
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