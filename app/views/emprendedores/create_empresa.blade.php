@section('titulo')
    Incubamas | Empresa
@stop

@section('emprendedores')
    class="active"
@stop

@section('mapa')
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
  <li class="active">Crear Empresa</li>
@stop

@section('titulo-seccion')
    <h1>Emprendedores<small>Crear Empresa</small></h1>
@stop

@section('contenido')    
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
    <div class="inner-spacer">
    {{ Form::open(array('url'=>'emprendedores/crearempresa', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
      {{Form::hidden('emprendedor_id', $emprendedor_id)}}
      <fieldset>
        <span class="message-error">{{$errors->first('emprendedor_id')}}</span>
        <div class="col-md-6 espacio_abajo">
          {{Form::label('nombre_empresa', '* Nombre del proyecto', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-building"></i>
            {{Form::text('nombre_empresa')}}
          </label>
          <span class="message-error">{{$errors->first('nombre_empresa')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('regimen', 'Tipo de  Régimen fiscal', array('class' => 'label'))}}
          <label class="select">
            {{Form::select('regimen', array(null=>'Selecciona', 'Incorporaci&oacute;n Fiscal'=>'Incorporaci&oacute;n Fiscal', 'Actividad Empresarial y Profesional'=>'Actividad Empresarial y Profesional'))}}
          </label>
          <span class="message-error">{{$errors->first('regimen')}}</span>
        </div>
         <div class="col-md-6 espacio_abajo">
          {{Form::label('idea', '* Describe la idea de negocio o las actividades de tu empresa/negocio ', array('class' => 'label'))}}
          <label class="textarea">
            {{Form::textarea('idea')}}
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
            {{Form::textarea('necesidad')}}
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
            {{Form::textarea('producto_serv','',array('style'=>'height: 200px;'))}}
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
          {{Form::label('director', 'Director General', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-group"></i>
            {{Form::text('director')}}
          </label>
          <span class="message-error">{{$errors->first('director')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('asistente', 'Asistente o Administrador', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-group"></i>
            {{Form::text('asistente')}}
          </label>
          <span class="message-error">{{$errors->first('asistente')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('pagina', 'Página Web de la Empresa', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-globe"></i>
            {{Form::text('pagina')}}
          </label>
          <span class="message-error">{{$errors->first('pagina')}}</span><br/><br/>
        </div>
        <div class="col-md-6 espacio_abajo">
          {{Form::label('rubro', 'Rubro Giro y/o Actividad', array('class' => 'label'))}}
          <label class="select">
            {{Form::select('rubro', array(null=>'Selecciona', 'Servicio y Comercio'=>'Servicio y Comercio',
          'Industria Ligera'=>'Industria Ligera'))}}
          </label>
          <span class="message-error">{{$errors->first('rubro')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('sector', 'Sector Estrat&eacute;gico', array('class' => 'label'))}}
          <label class="select">
            {{Form::select('sector', array(null=>'Selecciona', 'Agro industrial'=>'Agro industrial','Automotriz'=>'Automotriz',
          'Productos Químicos'=>'Productos Químicos','Cuero Calzado'=>'Cuero Calzado',
          'Servicios de Investigación'=>'Servicios de Investigación','Turístico'=>'Turístico',
          'Equipo medico'=>'Equipo medico','Farmacéuticos y Cosméticos'=>'Farmacéuticos y Cosméticos',
          'Aeronáutica'=>'Aeronáutica','Construcción'=>'Construcción','Químico'=>'Químico',
          'Agricultura'=>'Agricultura','Comercio'=>'Comercio','Software'=>'Software',
          'Electrónica'=>'Electrónica','Textil y Confección'=>'Textil y Confección',
          'Maquiladoras'=>'Maquiladoras','Otro'=>'Otro'))}}
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
            {{Form::text('razon_social')}}
          </label>
          <span class="message-error">{{$errors->first('razon_social')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('rfc', 'RCF con homoclave', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-gavel"></i>
            {{Form::text('rfc')}}
          </label>
          <span class="message-error">{{$errors->first('rfc')}}</span>
        </div>
        <div class="col-md-11 espacio_abajo">
          {{Form::label('negocio_casa', '* ¿La dirección de tu negocio es la misma que tú casa?', array('class' => 'label'))}}
          <label class="select">
            {{Form::select('negocio_casa', array(null=>'Selecciona', false=>'No',true=>'Si'), null, array('id'=>'select', 'onchange'=>'codigo();'))}}
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
          {{Form::label('calle', 'Calle', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-book"></i>
            {{Form::text('calle','',array('id'=>'calle','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('calle')}}</span>
        </div>
        <div class="col-md-3 espacio_abajo">
          {{Form::label('num_ext', 'N&uacute;mero Exterior', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-slack"></i>
            {{Form::text('num_ext','',array('id'=>'num_ext','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('num_ext')}}</span>
        </div>
        <div class="col-md-3 espacio_abajo">
          {{Form::label('num_int', 'N&uacute;mero Interior', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-slack"></i>
            {{Form::text('num_int','',array('id'=>'num_int','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('num_int')}}</span>
        </div>
        <div class="col-md-4 espacio_abajo">
          {{Form::label('colonia', 'Colonia o Fraccionamiento', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-book"></i>
            {{Form::text('colonia','',array('id'=>'colonia','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('colonia')}}</span>
        </div>
        <div class="col-md-4 espacio_abajo">
          {{Form::label('municipio', 'Municipio', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-book"></i>
            {{Form::text('municipio','',array('id'=>'municipio','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('municipio')}}</span>
        </div>
        <div class="col-md-2 espacio_abajo">
          {{Form::label('cp', 'C&oacute;digo Postal', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-book"></i>
            {{Form::text('cp','',array('id'=>'cp','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('cp')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('estado', 'Estado', array('class' => 'label'))}}
          <label class="select">
            {{Form::select('estado', array(null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
              'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
              'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
              'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
              'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
              'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
              'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
              'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán',
              'Zacatecas'=>'Zacatecas',null,array('id'=>'estado','disabled'=>'')))}}
          </label>
          <span class="message-error">{{$errors->first('estado')}}</span>
        </div>
      </fieldset>
      <fieldset>
        <div class="col-md-6 espacio_abajo">
          {{Form::label('financiamiento', '* ¿Desea un  acceder un financiamiento?', array('class' => 'label'))}}
          <label class="select">
            {{Form::select('financiamiento', array(null=> 'Selecciona',false=>'No',true=>'Si'),null, array('id'=>'select2', 'onchange'=>'codigo2();'))}}
          </label>
          <span class="message-error">{{$errors->first('financiamiento')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('monto', 'Monto a solicitar del financiamiento', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-money"></i>
            {{Form::text('monto','',array('id'=>'monto','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('monto')}}</span>
        </div>
        <div class="col-md-6 espacio_abajo">
          {{Form::label('costo_proyecto', 'Costo total del proyecto', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-money"></i>
            {{Form::text('costo_proyecto','',array('id'=>'costo','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('costo_proyecto')}}</span>
        </div>
        <div class="col-md-5 espacio_abajo">
          {{Form::label('aportacion', 'Aportación de Emprendedor', array('class' => 'label'))}}
          <label class="input">
            <i class="icon-prepend fa fa-money"></i>
            {{Form::text('aportacion','',array('id'=>'aportacion','disabled'=>''))}}
          </label>
          <span class="message-error">{{$errors->first('aportacion')}}</span>
        </div>
      </fieldset>
      <fieldset>
        <div class="col-md-6 espacio_abajo">
          {{Form::label('imagen', 'Logo', array('class' => 'label'))}}
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
          {{Form::checkbox('empresa', 'yes')}} A&ntilde;adir Otra Empresa
        </div>
      </fieldset>
       <fieldset>
          <div class="col-md-6 espacio_abajo" >
            {{ Form::submit('Crear', array('class'=>'btn btn-default')) }}
          </div>
          <div class="col-md-5 espacio_abajo" style="text-align: right;">
            * Los campos son obligatorios
          </div>
       </fieldset>
    {{Form::close()}}
    </div>
  </div>
  <!-- End .powerwidget -->
  <script>
    function codigo(){
      var select = document.getElementById("select"); 
      var calle = document.getElementById("calle");
      var num_int = document.getElementById("num_int");
      var num_ext = document.getElementById("num_ext");
      var colonia = document.getElementById("colonia");
      var cp = document.getElementById("cp");
      var estado = document.getElementById("estado");
      var municipio = document.getElementById("municipio");
      if(select.selectedIndex == 0||select.selectedIndex == 2){
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
      if(select.selectedIndex == 1){
        calle.disabled = false;
        num_int.disabled = false;
        num_ext.disabled = false;
        colonia.disabled = false;
        cp.disabled = false;
        estado.disabled = false;
        municipio.disabled = false;
      }
    }
    function codigo2(){
      var select = document.getElementById("select2"); 
      var monto = document.getElementById("monto");
      var costo = document.getElementById("costo");
      var aportacion = document.getElementById("aportacion");
      if(select.selectedIndex == 1||select.selectedIndex == 0){
        monto.disabled = true;
        costo.disabled = true;
        aportacion.disabled = true;
        costo.value = "";
        monto.value = ""
        aportacion.value = ""
      }
      if(select.selectedIndex == 2){
        monto.disabled = false;
        costo.disabled = false;
        aportacion.disabled = false;
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