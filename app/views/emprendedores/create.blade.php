@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
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
   @if(Session::get('confirm'))
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb clearfix">
          {{Session::get('confirm')}}
        </div>
      </div>
    </div>
  @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
    <div class="inner-spacer">
      {{ Form::open(array('url'=>'emprendedores/crear', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
        <fieldset>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('nombre', '* Nombre', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-user"></i>
              {{Form::text('nombre')}}
            </label>
            <span class="message-error">{{$errors->first('nombre')}}</span>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('apellido', '* Apellidos', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-user"></i>
              {{Form::text('apellido')}}
            </label>
            <span class="message-error">{{$errors->first('apellido')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('genero', 'Genero', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('genero', array(null=>'Selecciona','M'=>'Masculino', 'F'=>'Femenino'))}}
            </label>
            <span class="message-error">{{$errors->first('genero')}}</span>
          </div>
          <div class="col-md-6 espacio_abajo">
            {{Form::label('about', 'Acerca de mi', array('class' => 'label'))}}
            <label class="textarea">
              {{Form::textarea('about','',array('style'=>'height: 170px;'))}}
            </label>
            <span class="message-error">{{$errors->first('about')}}</span>
            <div class="note">
              <strong>
                  Nota:
              </strong>
              Maximo 500 caracteres
            </div>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('email', 'Correo electr&oacute;nico', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-envelope"></i>
              {{Form::email('email')}}
            </label>
            <span class="message-error">{{$errors->first('email')}}</span>
          </div>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('tel_fijo', 'Tel&eacute;fono Fijo', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-phone"></i>
              {{Form::text('tel_fijo','',array('id'=>'phone'))}}
            </label>
            <span class="message-error">{{$errors->first('tel_fijo')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('tel_movil', 'Tel&eacute;fono Movil', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-mobile"></i>
              {{Form::text('tel_movil','',array('id'=>'phone'))}}
            </label>
            <span class="message-error">{{$errors->first('tel_movil')}}</span>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('curp', '* CURP', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-database"></i>
              {{Form::text('curp')}}
            </label>
            <span class="message-error">{{$errors->first('curp')}}</span>
          </div>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('lugar_nac', 'Lugar de Nacimiento', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-building"></i>
              {{Form::text('lugar_nac')}}
            </label>
            <span class="message-error">{{$errors->first('lugar_nac')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('fecha_nac', '* Fecha de Nacimiento', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend  fa fa-calendar"></i>
              {{Form::text('date','',array('id'=>'date'))}}
            </label>
            <span class="message-error">{{$errors->first('date')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('escolaridad', 'M&aacute;ximo Nivel Escolar ', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('escolaridad', array(null=>'Selecciona', 'Ninguno'=>'Ninguno', 'Primaria'=>'Primaria',
              'Secundaria'=>'Secundaria','Preparatoria / Bachillerato'=>'Preparatoria / Bachillerato',
              'Carrera Técnica'=>'Carrera Técnica','Licenciatura'=>'Licenciatura','Maestría'=>'Maestría',
              'Doctorado'=>'Doctorado'))}}
            </label>
            <span class="message-error">{{$errors->first('escolaridad')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('estado_civil', 'Estado Civil', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('estado_civil', array(null=>'Selecciona','Soltero'=>'Soltero', 'Casado'=>'Casado','Divorciado'=>'Divorciado',
              'Viudo'=>'Viudo', 'Unión Libre'=>'Unión Libre','Separado'=>'Separado'))}}
            </label>
            <span class="message-error">{{$errors->first('estado_civil')}}</span>
          </div>
        </fieldset>
        <fieldset>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('calle', '* Calle', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-book"></i>
              {{Form::text('calle')}}
            </label>
            <span class="message-error">{{$errors->first('calle')}}</span>
          </div>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('num_ext', '* N&uacute;mero Exterior', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-slack"></i>
              {{Form::text('num_ext')}}
            </label>
            <span class="message-error">{{$errors->first('num_ext')}}</span>
          </div>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('num_int', 'N&uacute;mero Interior', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-slack"></i>
              {{Form::text('num_int')}}
            </label>
            <span class="message-error">{{$errors->first('num_int')}}</span>
          </div>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('colonia', '* Colonia o Fraccionamiento', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-book"></i>
              {{Form::text('colonia')}}
            </label>
            <span class="message-error">{{$errors->first('colonia')}}</span>
          </div>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('municipio', '* Municipio', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-book"></i>
              {{Form::text('municipio')}}
            </label>
            <span class="message-error">{{$errors->first('municipio')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('cp', '* C&oacute;digo Postal', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-book"></i>
              {{Form::text('cp')}}
            </label>
            <span class="message-error">{{$errors->first('cp')}}</span>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('estado', '* Estado', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('estado', array(null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán', 'Zacatecas'=>'Zacatecas'))}}
            </label>
            <span class="message-error">{{$errors->first('estado')}}</span>
          </div>
        </fieldset>
        <fieldset>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('trabajando', 'A&ntilde;os que has Trabajado', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('trabajando', array(null=>'Selecciona','Menor a 1 año'=>'Menor a 1 año','1 – 3 años'=>'1 – 3 años',
              '3 – 5 años'=>'3 – 5 años','5 – 10 años'=>'5 – 10 años','10 – 20 años'=>'10 – 20 años',
              'Más de 20 años'=>'Más de 20 años'))}}
            </label>
            <span class="message-error">{{$errors->first('trabajando')}}</span>
          </div>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('salario', 'Salario Mensual', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('salario', array(null=>'Selecciona','Menor a $1.841'=>'Menor a $1.841','$1.842 - $6.799'=>'$1.842 - $6.799',
                '$6.800 - $11.599'=>'$6.800 - $11.599', '$11.600 - $34.999'=>'$11.600 - $34.999', '$35.000 - $84.999'=>'$35.000 - $84.999',
                'Mayor a  $85.000'=>'Mayor a  $85.000'))}}
            </label>
            <span class="message-error">{{$errors->first('salario')}}</span>
          </div>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('personas', 'Personas que dependen de ti', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('personas', array(null=>'Selecciona','0'=>'0','1'=>'1','2...'=>'2...','...4'=>'...4','5'=>'5',
              'Más de 10'=>'Más de 10'))}}
            </label>
            <span class="message-error">{{$errors->first('personas')}}</span>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('emprendido', '* ¿Has emprendido alguna vez?', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('emprendido', array(null => 'Selecciona', false=>'No',true=>'Si'),
              null, array('id'=>'select', 'onchange'=>'codigo();'))}}
            </label>
            <span class="message-error">{{$errors->first('emprendido')}}</span>
          </div>
          <div class="col-md-6 espacio_abajo">
            {{Form::label('veces', 'Si la respuesta es sí  ¿Cuántas veces has emprendido un negocio?', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('veces', array(null=>'Selecciona','0'=>'0','1'=>'1','2...'=>'2...','...4'=>'...4','5'=>'5',
              'Más de 10'=>'Más de 10'), null, array('id'=>'veces','disabled'=>''))}}
            </label>
            <span class="message-error">{{$errors->first('veces')}}</span>
          </div>
        </fieldset>
        <fieldset>
          <div class="col-md-4 espacio_abajo">
            {{Form::label('programa', '* Programa', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('programa', array(null=>'Selecciona','Emprendedor'=>'Emprendedor', 'Empresarial'=>'Empresarial', 'Programa Especial'=>'Programa Especial'))}}
            </label>
            <span class="message-error">{{$errors->first('programa')}}</span>
          </div>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('estatus', '* Estatus', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('estatus', array(null=>'Selecciona','Activo'=>'Activo', 'Suspendido'=>'Suspendido', 'Cancelado'=>'Cancelado'))}}
            </label>
            <span class="message-error">{{$errors->first('estatus')}}</span>
          </div>
          <div class="col-md-3 espacio_abajo">
            {{Form::label('fecha_ing', '* Fecha de Ingreso', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-calendar"></i>
              {{Form::text('start','',array('id'=>'start'))}}
            </label>
            <span class="message-error">{{$errors->first('start')}}</span>
          </div>
          <div class="col-md-6 espacio_abajo">
            {{Form::label('imagen', 'Foto', array('class' => 'label'))}}
            {{Form::file('imagen')}}
            <span class="message-error">{{$errors->first('imagen')}}</span>
            <div class="note">
              <strong>
                  Nota:
              </strong>
              La imagen debe medir 300 x 300
            </div>
          </div>
          <div class="col-md-6 espacio_abajo">
            {{Form::checkbox('empresa', 'yes')}} A&ntilde;adir una Empresa
          </div>
        </fieldset>
        <footer>
          <div class="col-md-6 espacio_abajo" >
            {{ Form::submit('Crear', array('class'=>'btn btn-default')) }}
          </div>
          <div class="col-md-5 espacio_abajo" style="text-align: right;">
            * Los campos son obligatorios
          </div>
        </footer>
      {{Form::close()}}
    </div>
  </div>
  <!-- End .powerwidget -->
  <script>
    function codigo(){
      var select = document.getElementById("select"); 
      var veces = document.getElementById("veces");
      if(select.selectedIndex == 2){
        veces.disabled = false;
      }
      if(select.selectedIndex == 0 || select.selectedIndex == 1){
        veces.disabled = true;
        veces.value = ""
      }
    } 
  </script>
@stop

@section('scripts')
    @parent
    <!--Forms-->
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.form.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.validate.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.maskedinput.min.js') }}"></script> 
@stop