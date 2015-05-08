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
            $("#cpEmp").mask("99999");
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
                                {{HTML::link('emprendedores/crear-empresa/'.$emprendedor->id,'Añadir Empresa',array('class'=>'btn btn-default', 'style'=>'color:#FFF'))}}
                            </div>
                            @if(count($emprendedor->empresas) > 0)
                                @foreach($emprendedor->empresas as $empresa)
                                    {{Form::model($empresa, ['url'=>'emprendedores/editar-empresa', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                                        {{Form::hidden('id')}}
                                        <fieldset>
                                            <div class="col-md-6 espacio_abajo">
                                                {{Form::label('nombre_empresa', '* Nombre del proyecto', ['class' => 'label'])}}
                                                <label class="input">
                                                    <i class="icon-prepend fa fa-building"></i>{{Form::text('nombre_empresa')}}
                                                    <span class="message-error">{{$errors->first('nombre_empresa')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('regimen_fiscal', 'Tipo de  Régimen fiscal', ['class' => 'label'])}}
                                                <label class="select">
                                                    {{Form::select('regimen_fiscal', [null=>'Selecciona', 'Incorporaci&oacute;n Fiscal'=>'Incorporaci&oacute;n Fiscal', 'Actividad Empresarial y Profesional'=>'Actividad Empresarial y Profesional'])}}
                                                    <span class="message-error">{{$errors->first('regimen_fiscal')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6 espacio_abajo">
                                                {{Form::label('idea_negocio', '* Describe la idea de negocio o las actividades de tu negocio ', ['class' => 'label'])}}
                                                <label class="textarea">
                                                    {{Form::textarea('idea_negocio')}}
                                                    <span class="message-error">{{$errors->first('idea_negocio')}}</span>
                                                </label>
                                                <div class="note">
                                                    <strong>Nota:</strong>Maximo 500 caracteres
                                                </div>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('necesidad', '¿Qu&eacute; problema o necesidad resuelves con esto?', ['class' => 'label'])}}
                                                <label class="textarea">
                                                    {{Form::textarea('necesidad')}}
                                                    <span class="message-error">{{$errors->first('necesidad')}}</span>
                                                </label>
                                                <div class="note">
                                                    <strong>Nota:</strong>Maximo 500 caracteres
                                                </div>
                                            </div>
                                            <div class="col-md-6 espacio_abajo">
                                                {{Form::label('producto_servicio', '* Describe el producto o servicio que ofreces o quieres ofrecer', ['class' => 'label'])}}
                                                <label class="textarea">
                                                    {{Form::textarea('producto_servicio', null, ['style'=>'height: 200px;'])}}
                                                    <span class="message-error">{{$errors->first('producto_servicio')}}</span>
                                                </label>
                                                <div class="note">
                                                    <strong>Nota:</strong>Maximo 500 caracteres
                                                </div>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('director', 'Director General', ['class' => 'label'])}}
                                                <label class="input">
                                                    <i class="icon-prepend fa fa-group"></i>{{Form::text('director')}}
                                                    <span class="message-error">{{$errors->first('director')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('asistente', 'Asistente o Administrador', ['class' => 'label'])}}
                                                <label class="input">
                                                    <i class="icon-prepend fa fa-group"></i>{{Form::text('asistente')}}
                                                    <span class="message-error">{{$errors->first('asistente')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('pagina_web', 'Página Web de la Empresa', ['class' => 'label'])}}
                                                <label class="input">
                                                    <i class="icon-prepend fa fa-globe"></i>{{Form::text('pagina_web')}}
                                                    <span class="message-error">{{$errors->first('pagina_web')}}</span><br/><br/>
                                                </label>
                                            </div>
                                            <div class="col-md-6 espacio_abajo">
                                                {{Form::label('giro_actividad', 'Rubro, Giro y/o Actividad', ['class' => 'label'])}}
                                                <label class="select">
                                                    {{Form::select('giro_actividad', [null=>'Selecciona', 'Servicio y Comercio'=>'Servicio y Comercio','Industria Ligera'=>'Industria Ligera'])}}
                                                    <span class="message-error">{{$errors->first('giro_actividad')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('sector', 'Sector Estrat&eacute;gico', ['class' => 'label'])}}
                                                <label class="select">
                                                    {{Form::select('sector', [null=>'Selecciona', 'Agro industrial'=>'Agro industrial','Automotriz'=>'Automotriz',
                                                    'Productos Químicos'=>'Productos Químicos','Cuero Calzado'=>'Cuero Calzado',
                                                    'Servicios de Investigación'=>'Servicios de Investigación','Turístico'=>'Turístico',
                                                    'Equipo medico'=>'Equipo medico','Farmacéuticos y Cosméticos'=>'Farmacéuticos y Cosméticos',
                                                    'Aeronáutica'=>'Aeronáutica','Construcción'=>'Construcción','Químico'=>'Químico',
                                                    'Agricultura'=>'Agricultura','Comercio'=>'Comercio','Software'=>'Software',
                                                    'Electrónica'=>'Electrónica','Textil y Confección'=>'Textil y Confección',
                                                    'Maquiladoras'=>'Maquiladoras','Otro'=>'Otro'])}}
                                                    <span class="message-error">{{$errors->first('sector')}}</span>
                                                </label>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="col-md-11 espacio_abajo">
                                                <h3>Datos Fiscales</h3><br/>
                                            </div>
                                            <div class="col-md-6 espacio_abajo">
                                                {{Form::label('razon_social', '* Raz&oacute;n Social', ['class' => 'label'])}}
                                                <label class="input">
                                                    <i class="icon-prepend fa fa-building"></i>{{Form::text('razon_social')}}
                                                    <span class="message-error">{{$errors->first('razon_social')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('rfc', 'RCF con homoclave', ['class' => 'label'])}}
                                                <label class="input">
                                                    <i class="icon-prepend fa fa-gavel"></i>{{Form::text('rfc')}}
                                                    <span class="message-error">{{$errors->first('rfc')}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-11 espacio_abajo">
                                                {{Form::label('negocio_casa', '* ¿La dirección de tu negocio es la misma que tú casa?', ['class' => 'label'])}}
                                                <label class="select">
                                                    {{Form::select('negocio_casa', [null=>'Selecciona', 1=>'No', 2=>'Si'], null, ['id'=>'direccion'])}}
                                                    <span class="message-error">{{$errors->first('negocio_casa')}}</span>
                                                </label>
                                            </div>
                                            <div id="divDireccion" @if($empresa->negocio_casa!=1&&!$errors->first('calle')&&!$errors->first('num_ext')&&!$errors->first('num_int')&&!$errors->first('colonia')&&!$errors->first('municipio')&&!$errors->first('cp')&&!$errors->first('estado')) style="visibility: hidden" @endif>
                                                <div class="col-md-4 espacio_abajo">
                                                    {{Form::label('calle', 'Calle', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-book"></i>{{Form::text('calle', null, ['id'=>'calleEmp'])}}
                                                        <span class="message-error">{{$errors->first('calle')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-3 espacio_abajo">
                                                    {{Form::label('num_ext', 'N&uacute;mero Exterior', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_ext', null, ['id'=>'num_extEmp'])}}
                                                        <span class="message-error">{{$errors->first('num_ext')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-3 espacio_abajo">
                                                    {{Form::label('num_int', 'N&uacute;mero Interior', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_int', null, ['id'=>'num_intEmp'])}}
                                                        <span class="message-error">{{$errors->first('num_int')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-4 espacio_abajo">
                                                    {{Form::label('colonia', 'Colonia o Fraccionamiento', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-book"></i>{{Form::text('colonia', null, ['id'=>'coloniaEmp'])}}
                                                        <span class="message-error">{{$errors->first('colonia')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-4 espacio_abajo">
                                                    {{Form::label('municipio', 'Municipio', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-book"></i>{{Form::text('municipio', null, ['id'=>'municipioEmp'])}}
                                                        <span class="message-error">{{$errors->first('municipio')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-2 espacio_abajo">
                                                    {{Form::label('cp', 'C&oacute;digo Postal', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-book"></i>{{Form::text('cp', null, ['id'=>'cpEmp'])}}
                                                        <span class="message-error">{{$errors->first('cp')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5 espacio_abajo">
                                                    {{Form::label('estado', 'Estado', ['class' => 'label'])}}
                                                    <label class="select">
                                                        {{Form::select('estado', [null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                                                        'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                                                        'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                                                        'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                                        'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                                                        'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                                                        'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                                                        'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán',
                                                        'Zacatecas'=>'Zacatecas'], null, ['id'=>'estadoEmp'])}}
                                                        <span class="message-error">{{$errors->first('estado')}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="col-md-6 espacio_abajo">
                                                {{Form::label('financiamiento', '* ¿Desea un  acceder un financiamiento?', ['class' => 'label'])}}
                                                <label class="select">
                                                    {{Form::select('financiamiento', [null=> 'Selecciona', 1=>'No', 2=>'Si'], null, ['id'=>'desea'])}}
                                                    <span class="message-error">{{$errors->first('financiamiento')}}</span>
                                                </label>
                                            </div>
                                            <div id="divFinanciamiento" @if($empresa->financiamiento!=2&&!$errors->first('monto_financiamiento')&&!$errors->first('costo_proyecto')&&!$errors->first('aportacion')) style="visibility: hidden" @endif>
                                                <div class="col-md-5 espacio_abajo">
                                                    {{Form::label('monto_financiamiento', 'Monto a solicitar del financiamiento', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-money"></i>{{Form::text('monto_financiamiento', null, ['id'=>'monto_financiamiento'])}}
                                                        <span class="message-error">{{$errors->first('monto_financiamiento')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 espacio_abajo">
                                                    {{Form::label('costo_proyecto', 'Costo total del proyecto', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-money"></i>{{Form::text('costo_proyecto', null, ['id'=>'costo_proyecto'])}}
                                                        <span class="message-error">{{$errors->first('costo_proyecto')}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5 espacio_abajo">
                                                    {{Form::label('aportacion', 'Aportación de Emprendedor', ['class' => 'label'])}}
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-money"></i>{{Form::text('aportacion', null, ['id'=>'aportacion'])}}
                                                        <span class="message-error">{{$errors->first('aportacion')}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="col-md-5 espacio_abajo">
                                                {{Form::label('logo', 'Logo de la Empresa', ['class' => 'label'])}}
                                                {{Form::file('logo', ['accept'=>"image/*", 'id'=>'logo'.$empresa->id])}}
                                                <span class="message-error">{{$errors->first('logo')}}</span>
                                                <div class="note"><strong>Nota:</strong>La imagen debe medir 300 x 300</div>
                                                <script>
                                                    $("#logo{{$empresa->id}}").fileinput({
                                                        previewFileType: "image",
                                                        initialPreview: [
                                                            "<img src='{{url('Orb/images/empresas/'.$empresa->logo)}}' class='file-preview-image'>"
                                                        ],
                                                        browseClass: "btn btn-success",
                                                        browseLabel: " Selecciona otro Logo ",
                                                        browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                                                        showCaption: false,
                                                        showUpload: false,
                                                        showRemove: false
                                                    });
                                                </script>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="col-md-6 espacio_abajo" >
                                                {{ Form::submit('Guardar', ['class'=>'btn btn-default'])}}
                                                {{HTML::link('emprendedores/delete-empresa/'.$empresa->id,'Eliminar '.$empresa->nombre_empresa,array('class'=>'btn btn-default'))}}
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
        $( "#direccion" ).change(function() {
            if(direccion.selectedIndex == 1)
                $( "#divDireccion" ).css('visibility', 'visible');
            else {
                $("#divDireccion").css('visibility', 'hidden');
                $("#calleEmp").val('');
                $("#num_extEmp").val('');
                $("#num_intEmp").val('');
                $("#coloniaEmp").val('');
                $("#municipioEmp").val('');
                $("#cpEmp").val('');
                $("#estadoEmp").val('');
            }
        });
        $( "#desea" ).change(function() {
            if (desea.selectedIndex == 2)
                $("#divFinanciamiento").css('visibility', 'visible');
            else
            {
                $("#divFinanciamiento").css('visibility', 'hidden');
                $("#monto_financiamiento").val('');
                $("#costo_proyecto").val('');
                $("#aportacion").val('');
            }
        });
    </script>
@stop