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
        $(function() {
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
    <li class="active">Crear</li>
@stop

@section('titulo-seccion')
    <h1>Emprendedores<small>Crear</small></h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::open(['url'=>'emprendedores/crear', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                <fieldset>
                    <div class="col-md-4 espacio_abajo">
                        {{Form::label('nombre', '* Nombre', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>{{Form::text('nombre')}}
                            <span class="message-error">{{$errors->first('nombre')}}</span>
                        </label>
                    </div>
                    <div class="col-md-4 espacio_abajo">
                        {{Form::label('apellidos', '* Apellidos', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>{{Form::text('apellidos')}}
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
                            <i class="icon-prepend fa fa-envelope"></i>{{Form::email('email')}}
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
                            <i class="icon-prepend  fa fa-calendar"></i>{{Form::text('fecha_nacimiento', null, ['id'=>'fecha_nac', 'readonly'])}}
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
                    <div class="col-md-5 espacio_abajo" id="emprendido" @if(!$errors->first('veces_emprendido')) style="visibility: hidden" @endif >
                        {{Form::label('veces_emprendido', '* ¿Cuántas veces has emprendido un negocio?', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('veces_emprendido', [null=>'Selecciona','0'=>'0','1'=>'1','2...'=>'2...', '...4'=>'...4','5'=>'5','Más de 10'=>'Más de 10'], null, ['id'=> 'veces_emp'])}}
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
                            <i class="icon-prepend fa fa-calendar"></i>{{Form::text('fecha_ingreso',null, ['id'=>'fecha_ing', 'readonly'])}}
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
                        {{Form::label('empresa', 'Selecciona si quieres a&ntilde;dir una empresa ahora', ['class' => 'label'])}}
                        {{Form::checkbox('empresa', 'yes')}} A&ntilde;adir Empresa
                    </div>
                </fieldset>
                <footer>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Crear', ['class'=>'btn btn-default']) }}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </footer>
            {{Form::close()}}
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
        $( "#select" ).change(function() {
            if(select.selectedIndex == 2) {
                $("#emprendido").css('visibility', 'visible');
            }else {
                $("#emprendido").css('visibility', 'hidden');
                $("#veces_emp").val('');
            }
        });
        $(function ()
        {
            $('#fecha_nac').datetimepicker(
            {
                pickTime: false,
                language: 'es',
                minDate:'1/1/1940',
                defaultDate:'1/1/1980',
                maxDate: '1/1/2000'
            });
            $('#fecha_ing').datetimepicker(
            {
                pickTime: false,
                language: 'es',
                minDate:'1/1/2000',
                defaultDate: new Date(),
                maxDate: new Date()
            });
        });
        $("#foto").fileinput({
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: " Foto ",
            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
            showCaption: false,
            removeClass: "btn btn-danger",
            removeLabel: "Borrar",
            removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
            showUpload: false
        });
    </script>
@stop