@section('titulo')
    IncubaM&aacute;s | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('css')
  @parent
  <link rel="stylesheet" href="{{ URL::asset('Orb/bower_components/bootstrap-calendar/css/calendar.css')}}">
  <script type="text/javascript" src="{{ URL::asset('Orb/bower_components/jquery/jquery.min.js')}}"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="{{ URL::asset('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js')}}"></script>
  <script src="{{ URL::asset('Orb/bower_components/moment/moment.js')}}"></script>
  <script src="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js')}}"></script>
  <script src="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>
  <link rel="stylesheet" href="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
  <script src="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js')}}"></script>
@show

@section('mapa')
  @if(Auth::user()->type_id!=3)
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
    <li class="active">Perfil</li>
  @else
    <li class="active">Perfil de Emprendedor</li>
  @endif
@stop

@section('titulo-seccion')
  @if(Auth::user()->type_id!=3)
    <h1>Emprendedores<small> Perfil</small></h1>
  @endif
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
  @if(count($errors)>0)
    <script>
      alert("¡Por favor, revise los datos del formulario!");
    </script>
  @endif
  <!-- Widget Row Start grid -->
  <div class="row" id="powerwidgets">
  
    <!---------------------------------- Detalles de los pagos realizados ------------------------------------->
    <div class="col-md-3 col-sm-6 bootstrap-grid"> 
      <!-- New widget -->
      <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-green-alt" id="widget1" data-widget-editbutton="false">
          <div class="inner-spacer nopadding">
              <div class="portlet-big-icon">
                <i class="fa fa-money"></i><br/>
                <span style="font-size: 20px;">Estado de Cuenta</span>
              </div>
              <ul class="portlet-bottom-block">
                  <li class="col-md-6 col-sm-6 col-xs-6"><strong>{{$pagos}}</strong><small>Pagos Realizados</small></li>
                  <li class="col-md-6 col-sm-6 col-xs-6"><strong>{{$adeudo}}</strong><small>Adeudo</small></li>
              </ul>
          </div>
      </div>
      <!-- /New widget --> 
    </div>    
    <!----------------------------------- Detalles de los documentos subidos ----------------------------------->   
    <div class="col-md-3 col-sm-6 bootstrap-grid"> 
      <!-- New widget -->
      <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-purple" id="widget2" data-widget-editbutton="false">
        <div class="inner-spacer nopadding">
          <div class="portlet-big-icon">
            <i class="fa fa-archive"></i><br/>
            <span style="font-size: 20px;">Documentos</span>
          </div>
          <ul class="portlet-bottom-block">
            <li class="col-md-4 col-sm-4 col-xs-4"><strong>{{$subidas}}</strong><small>Subidos</small></li>
            <li class="col-md-4 col-sm-4 col-xs-4"><strong><a href="" href="#myModal2" data-target="#myModal2" data-toggle="modal" style="color:#FFF"><span class="glyphicon glyphicon-cloud-upload"></span></strong></a><small>Subir</small></li>
            <li class="col-md-4 col-sm-4 col-xs-4"><strong>{{$num_documentos}}</strong><small>Total</small></li>
          </ul>
        </div>
      </div>
      <!-- /New widget --> 
    </div>
    <div class="col-md-6 col-sm-6 bootstrap-grid"> 
      <!-- New widget -->
      <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-cold-grey" id="widget3" data-widget-editbutton="false">
        <div class="inner-spacer nopadding" style="padding: 15px;">
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
        </div>
      </div>
      <!-- /New widget -->             
    </div>    
  </div>
<!------------------------------------------------- Perfil-------------------------------------------------> 
  <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
    <div class="inner-spacer"> 
      <!--Profile-->
      <div class="user-profile">
        <div class="main-info">
          <div class="user-img"><img src="{{URL::asset('Orb/images/emprendedores/'.$emprendedor[0]->imagen)}}" alt="User Picture" /></div>
          <h1>{{$emprendedor[0]->name}} {{$emprendedor[0]->apellidos}}</h1>
          <!--Followers: 451 | Friends: 45 | Items: 22 --></div>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="item item1 active"> </div>
            <div class="item item2"></div>
            <div class="item item3"></div>
          </div>
        <div class="user-profile-info">
          <div class="tabs-white">
            <ul id="myTab" class="nav nav-tabs nav-justified">
                <li class="active"><a href="#emprendedor" data-toggle="tab">Emprendedor</a></li>
                <li><a href="#empresas" data-toggle="tab">Empresas</a></li>
                @if(Auth::user()->type_id==3)
                  <li><a href="#mensajeria" data-toggle="tab">Mensajeria</a></li>
                @endif
                <li><a href="#calendario" data-toggle="tab">Calendario de Citas</a></li>
            </ul>
<!------------------------------------------------- Emprendedor-------------------------------------------------> 
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane in active" id="emprendedor">
                <div class="profile-header">Acerca de mi</div>
                <p>{{$emprendedor[0]->about}}</p><br/>
                <table class="table">
                  <tr>
                    <td><strong>Nombre:</strong></td>
                    <td>{{$emprendedor[0]->name}} {{$emprendedor[0]->apellidos}}</td>
                    <td colspan="2" style="text-align:center; background-color: #F0F0F0;"><strong>Domicilio</strong></td>
                  </tr>
                  <tr>
                    <td><strong>Genero:</strong></td>
                    @if($emprendedor[0]->genero=="M")
                      <td>Masculino</td>
                    @else
                      <td>Femenino</td>
                    @endif
                    <td><strong>Calle:</strong></td>
                    <td>{{$emprendedor[0]->calle}}</td>
                  </tr>
                  <?php
                    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                    $fecha_nac = date_format(date_create($emprendedor[0]->fecha_nacimiento), 'd-m-Y');
                    $fecha_ing = date_format(date_create($emprendedor[0]->fecha_ingreso), 'd-m-Y');
                    $fecha = time() - strtotime($fecha_nac);
                    $edad = floor((((time() - strtotime($fecha_nac)) / 3600) / 24) / 360);
                    $fecha_nac_letra = strftime("%d de %B de %Y", strtotime($fecha_nac));
                    $fecha_ing_letra = strftime("%d de %B de %Y", strtotime($fecha_ing));
                  ?>
                  <tr>
                    <td><strong>Edad:</strong></td>
                    <td>{{$edad}} años</td>
                    <td><strong>N&uacute;mero exterior:</strong></td>
                    <td>{{$emprendedor[0]->num_ext}}</td>
                  </tr>
                  <tr>
                    <td><strong>Fecha de Nacimiento:</strong></td>
                    <td>{{$fecha_nac_letra}}</td>
                    <td><strong>N&uacute;mero interior:</strong></td>
                    @if($emprendedor[0]->num_int<>"")
                      <td>{{$emprendedor[0]->num_int}}</td>
                    @else
                      <td>S/N</td>
                    @endif
                  </tr>
                  <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{$emprendedor[0]->email}}</td>
                    <td><strong>Colonia o Fraccionamiento:</strong></td>
                    <td>{{$emprendedor[0]->colonia}}</td>
                  </tr>
                  <tr>
                    <td><strong>Tel&eacute;fono Movil:</strong></td>
                    <td>{{$emprendedor[0]->tel_movil}}</td>
                    <td><strong>Municipio:</strong></td>
                    <td>{{$emprendedor[0]->municipio}}</td>
                  </tr>
                  <tr>
                    <td><strong>Tel&eacute;fono Fijo:</strong></td>
                    <td>{{$emprendedor[0]->tel_fijo}}</td>
                    <td><strong>Estado:</strong></td>
                    <td>{{$emprendedor[0]->estado}}</td>
                  </tr>
                  <tr>
                    <td><strong>CURP:</strong></td>
                    <td>{{$emprendedor[0]->curp}}</td>
                    <td><strong>CP:</strong></td>
                    <td>{{$emprendedor[0]->cp}}</td>
                  </tr>
                  <tr>
                    <td><strong>Lugar de Nacimiento:</strong></td>
                    <td>{{$emprendedor[0]->lugar_nacimiento}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Estado Civil:</strong></td>
                    <td>{{$emprendedor[0]->estado_civil}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>M&aacute;ximo Nivel Escolar:</strong></td>
                    <td>{{$emprendedor[0]->escolaridad}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>A&ntilde;os que has trabajado:</strong></td>
                    <td>{{$emprendedor[0]->tiempo_trabajando}}</td>
                    <td colspan="2" style="text-align:center; background-color: #F0F0F0;"><strong>Programa</strong></td>
                  </tr>
                  <tr>
                    <td><strong>Salario Mensual:</strong></td>
                    <td>{{$emprendedor[0]->salario_mensual}}</td>
                    <td><strong>Programa:</strong></td>
                    <td>{{$emprendedor[0]->programa}}</td>                    
                  </tr>
                  <tr>
                    <td><strong>Emprendimientos anteriores:</strong></td>
                    <td>{{$emprendedor[0]->veces_emprendido}}</td>
                    <td><strong>Estatus:</strong></td>
                    <td>{{$emprendedor[0]->estatus}}</td>
                  </tr>
                  <tr>
                    <td><strong>Dependientes:</strong></td>
                    <td>{{$emprendedor[0]->personas_dependen}}</td>
                    <td><strong>Fecha de ingreso:</strong></td>
                    <td>{{$fecha_ing_letra}}</td>
                  </tr>
                </table>
              </div>
<!----------------------------------------------Empresas------------------------------------------------------>
              <div class="tab-pane" id="empresas">
                @if(count($emprendedor[0]->empresas) > 0)
                  @foreach($emprendedor[0]->empresas as $empresa)
                    <div class="profile-header">{{$empresa->nombre_empresa}}</div>
                    <table class="table" style="table-layout:fixed">
                      <tr>
                        <td><strong>Idea del Negocio:</strong></td>
                        <td colspan="3">{{$empresa->idea_negocio}}</td>
                      </tr>
                      <tr>
                        <td><strong>Problema o Necesidad que resuelve:</strong></td>
                        <td colspan="3">{{$empresa->necesidad}}</td>
                      </tr>
                      <tr>
                        <td><strong>Producto o servicio que Ofrece:</strong></td>
                        <td colspan="3">{{$empresa->producto_servicio}}</td>
                      </tr>
                      <tr>
                        <td><strong>Tipo de R&eacute;gimen Fiscal:</strong></td>
                        <td>{{$empresa->regimen_fiscal}}</td>
                        <td></td><td></td>
                      </tr>                      
                      <tr>
                        <td><strong>Rubro y/o Actividad:</strong></td>
                        <td>{{$empresa->giro_actividad}}</td>
                        <td colspan="2" style="text-align:center; background-color: #F0F0F0;"><strong>Datos Fiscales</strong></td>
                      </tr>
                      <tr>
                        <td style="width: 25%;"><strong>Sector Estrat&eacute;gico:</strong></td>
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
                          <td>{{$emprendedor[0]->calle}}</td>
                        @else
                          <td>{{$empresa->calle}}</td>
                        @endif
                      </tr>
                      <tr>
                        <td><strong>P&aacute;gina Web de la Empresa:</strong></td>
                        <td>{{$empresa->pagina_web}}</td>
                        <td><strong>N&uacute;mero exterior:</strong></td>
                        @if($empresa->negocio_casa)
                          <td>{{$emprendedor[0]->num_ext}}</td>
                        @else
                          <td>{{$empresa->num_ext}}</td>
                        @endif
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><strong>N&uacute;mero interior:</strong></td>
                        @if($empresa->negocio_casa)
                          <td>{{$emprendedor[0]->num_int}}</td>
                        @else
                          <td>{{$empresa->num_int}}</td>
                        @endif
                      </tr>
                      <tr>
                        @if($empresa->financiamiento)
                          <td colspan="2" style="text-align:center; background-color: #F0F0F0;"><strong>Solicitud de Financiamiento</strong></td>
                        @else
                          <td></td><td></td>
                        @endif
                        <td><strong>Colonia o Fraccionamiento:</strong></td>
                        @if($empresa->negocio_casa)
                          <td>{{$emprendedor[0]->colonia}}</td>
                        @else
                          <td>{{$empresa->colonia}}</td>
                        @endif
                      </tr>
                      <tr>
                        @if($empresa->financiamiento)
                          <td><strong>Monto Solicitado:</strong></td>
                          <td>{{$empresa->monto_financiamiento}}</td>
                        @else
                          <td></td><td></td>
                        @endif
                        <td><strong>Municipio:</strong></td>
                        @if($empresa->negocio_casa)
                          <td>{{$emprendedor[0]->municipio}}</td>
                        @else
                          <td>{{$empresa->municipio}}</td>
                        @endif
                      </tr>
                      <tr>
                        @if($empresa->financiamiento)
                          <td><strong>Costo Total del Proyecto:</strong></td>
                          <td>{{$empresa->costo_proyecto}}</td>
                        @else
                          <td></td><td></td>
                        @endif
                        <td><strong>Estado:</strong></td>
                        @if($empresa->negocio_casa)
                          <td>{{$emprendedor[0]->estado}}</td>
                        @else
                          <td>{{$empresa->estado}}</td>
                        @endif
                      </tr>
                      <tr>
                        @if($empresa->financiamiento)
                          <td><strong>Aportacion del emprendedor:</strong></td>
                          <td>{{$empresa->aportacion}}</td>
                        @else
                          <td></td><td></td>
                        @endif
                        <td><strong>CP:</strong></td>
                        @if($empresa->negocio_casa)
                          <td>{{$emprendedor[0]->cp}}</td>
                        @else
                          <td>{{$empresa->cp}}</td>
                        @endif
                      </tr>
                    </table>
                  @endforeach
                @else
                  <i>No hay empresas registradas</i>
                @endif
              </div>
<!--------------------------------------Chat------------------------------------------------------------->
              <div class="tab-pane" id="mensajeria">
                <div class="profile-header">Mensajeria</div>
                <div class="container">     
                  
                  
                </div>
              </div>
<!--------------------------------------Calendario de citas-------------------------------------------------->
              <div class="tab-pane" id="calendario">
                <div class="profile-header">Calendario de Citas</div>
                <div class="container">     
                  <div class="row">
                    @if(\Auth::user()->type_id==3)
                      <div class="page-header" style="width: 100%;">
                    @else
                      <div class="page-header" style="width: 88%;">
                    @endif
                      <div class="pull-right form-inline" style="float: left !important; width: 98%;">
                        <div class="btn-group">
                          <button class="btn btn-primary" data-calendar-nav="prev"><<</button>
                          <button class="btn" data-calendar-nav="today">Hoy</button>
                          <button class="btn btn-primary" data-calendar-nav="next">>></button>
                        </div>
                        <div class="btn-group" style="float: right;">
                          <button class="btn btn-warning" data-calendar-view="year">Año</button>
                          <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                          <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                          <button class="btn btn-warning" data-calendar-view="day">Día</button>
                        </div>
                         
                      </div>
                      <br/><br/><br/><br/><br/>
                      <h3 style="display: inline-block;"></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      @if($emprendedor[0]->estatus=="Activo")
                        <a class="btn btn-info" href="#myModal3" data-toggle="modal">Solicitar Cita</a>&nbsp;&nbsp;
                      @endif
                      <a class="btn btn-info" href="#myModal1" data-toggle="modal">Crear Evento</a>
                    </div>
                  </div>
                  <div class="row">
                    <div id="calendar"></div>
                  </div>
                  <!--ventana modal para el calendario-->
                  <div class="modal fade" id="events-modal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body" style="height: 400px">
                          <p>One fine body&hellip;</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                </div>
              </div>
            <div class="social-buttons">
              <ul class="social">
                <li><a target="_blank" href="https://www.facebook.com/IncubaMas"><i class="entypo-facebook-circled"></i></a></li>
                <li><a target="_blank" href="https://www.linkedin.com/company/incubam%C3%A1s"><i class="entypo-linkedin-circled"></i></a></li>
                <li><a target="_blank" href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i class="entypo-gplus-circled"></i></a></li>
                <li><a target="_blank" href="https://twitter.com/IncubaMas"><i class="entypo-twitter-circled"></i></a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>    
  <!---------------------------------------------------/Profile-------------------------------------------------> 
    </div>
    </div>
    <!-- End .powerwidget -->
    <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Crear Evento</h4>
        </div>
	{{ Form::open(array('url'=>'calendario/evento/'.$emprendedor[0]->user_id, 'class'=>'orb-form','method' => 'post') )}}
          {{Form::hidden('destino','emprendedores/perfil/'.$emprendedor[0]->id)}}
	<div class="modal-body">
	  <fieldset>
	    <div class="col-md-6 espacio_abajo">
	      {{Form::label('title', '* Nombre', array('class' => 'label'))}}
	      <label class="input">
		{{Form::text('title','',array('class'=>'form-control', 'id'=>"body"))}}
	      </label>
	      <span class="message-error">{{$errors->first('title')}}</span>
	    </div>
	    <div class="col-md-5 espacio_abajo">
	      {{Form::label('class', '* Color', array('class' => 'label'))}}
	      <label class="select">
		 {{Form::select('class', array("event-info"=>'Azul', "event-success"=>'Verde',
		    "event-inverse"=>'Negro',"event-warning"=>'Amarillo',"event-special"=>'Morado'))}}
	      </label>
	      <span class="message-error">{{$errors->first('class')}}</span>
	    </div>
	    <div class="col-md-6 espacio_abajo">
	      {{Form::label('from', '* De', array('class' => 'label'))}}
	      <label class="input">
		<i class="icon-prepend  fa fa-calendar"></i>
		{{Form::text('from','',array('class'=>'form-control', 'readonly', 'id'=>'from', 'onchange'=>'cambiar();'))}}
	      </label>
	      <span class="message-error">{{$errors->first('from')}}</span>
	    </div>
	    <div class="col-md-5 espacio_abajo">
	      {{Form::label('to', '* A', array('class' => 'label'))}}
	      <label class="input">
		<i class="icon-prepend  fa fa-calendar"></i>
		{{Form::text('to','',array('class'=>'form-control', 'readonly', 'id'=>'to','onchange'=>'cambiar();'))}}
	      </label>
	      <span class="message-error">{{$errors->first('to')}}</span>
	    </div>
	    <div class="col-md-6 espacio_abajo">
	      {{Form::label('event', 'Asunto', array('class' => 'label'))}}
	      <label class="input">
		{{Form::text('event','',array('class'=>'form-control', 'id'=>"body"))}}
	      </label>
	      <span class="message-error">{{$errors->first('event')}}</span>
	    </div>
	    
	    <div class="col-md-11 espacio_abajo" style="text-align: left;">
	      * Los campos son obligatorios, el evento solo aparecera en tu calendario personal
	    </div>
	  </fieldset>
        </div>
        <div class="modal-footer">
	  <span id="eventos">
	    @if($warning<>"")
	      <button onClick="return confirm('Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?');" class="btn btn-primary" id="evento_boton">Crear</button>
	    @else
	      <button class="btn btn-primary" id="evento_boton">Crear</button>
	    @endif
	  </span>
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
	{{Form::close()}}
      </div>
    </div>
  </div>
  <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="titulo_pago">Solicitar Cita</h4>
        </div>
	{{ Form::open(array('url'=>'calendario/crear/'.$emprendedor[0]->user_id, 'class'=>'orb-form','method' => 'post') )}}
          {{Form::hidden('destino','emprendedores/perfil/'.$emprendedor[0]->id)}}
        <div class="modal-body">
            <fieldset>
              <div class="col-md-11 espacio_abajo">
		@if(Auth::user()->type_id == 3)
		  {{Form::label('consultor', '* Consultor', array('class' => 'label'))}}
		@else
		  {{Form::label('consultor', '* Emprendedor', array('class' => 'label'))}}
		@endif
                <label class="select">
                   {{Form::select('consultor', $asesores,  '',array('id' => 'objetivo','onchange'=>'cambiar();'))}}
                </label>
                <span class="message-error">{{$errors->first('consultor')}}</span>
              </div>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('from', '* Fecha', array('class' => 'label'))}}
		<label class="input">
		  {{Form::text('from','',array('class'=>'form-control', 'readonly', 'id'=>'fecha', 'onchange'=>'cambiar();'))}}
                </label>
		<span class="message-error">{{$errors->first('from')}}</span>
              </div>
              <div class="col-md-5 espacio_abajo">
                {{Form::label('horario', '* Hora', array('class' => 'label'))}}
                <label class="select" id='hora'>
                   {{Form::select('horario', $horarios_disponibles, array('id' => 'horario'))}}
                </label>
                <span class="message-error">{{$errors->first('horario')}}</span>
              </div>
	      <div class="col-md-11 espacio_abajo">
                {{Form::label('event', 'Asunto', array('class' => 'label'))}}
                <label class="input">
                  {{Form::text('event','',array('class'=>'form-control', 'id'=>"body"))}}
                </label>
                <span class="message-error">{{$errors->first('event')}}</span>
              </div>
              <div class="col-md-11 espacio_abajo" style="text-align: left;">
                * Los campos son obligatorios
              </div>
            </fieldset>
        </div>
        <div class="modal-footer">
	  <span id="cita">
	    @if($warning_cita<>"")
	      <button onClick="return confirm('Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?');" class="btn btn-primary" id="cita_boton">Crear</button>
	    @else
	      <button onClick="alert('Recibiras un correo cuando tu cita sea confirmada')" class="btn btn-primary" id="cita_boton">Crear</button>
	    @endif
	  </span>
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
	{{Form::close()}}
      </div>
    </div>
  </div>
  <!-- End .powerwidget -->
  
  <div id="myModal2" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Subir Documentos</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(array('url'=>'emprendedores/subirdocumento', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
            {{Form::hidden('emprendedor_id',$emprendedor[0]->id)}}
            <span class="message-error">{{$errors->first('emprendedor')}}</span>
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('empresa', '* Empresa', array('class' => 'label'))}}
                <label class="select">
                  @if(count($empresas_listado)>0)
                    {{Form::select('empresa', $empresas_listado)}} 
                  @else
                    {{Form::select('empresa', array(null=>$emprendedor[0]->name." ".$emprendedor[0]->apellidos))}}
                  @endif
                </label>
                <span class="message-error">{{$errors->first('empresa')}}</span>
              </div>
              <div class="col-md-5 espacio_abajo">
                @if(count($socios_listado)>0)
                  {{Form::checkbox('emprendedor', 'yes', 'yes',array('id'=>'emp_event','onchange'=>'evento(3);'))}} Documento del emprendedor
                @else
                  {{Form::checkbox('emprendedor', 'yes', 'yes', array('disabled'=>''))}} Documento del emprendedor
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
@stop

@section('scripts')
  <!--Fullscreen--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/fullscreen/screenfull.min.js') }}"></script> 
  <!--NanoScroller-->
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/nanoscroller/jquery.nanoscroller.min.js') }}"></script> 
  <!--Sparkline--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/sparkline/jquery.sparkline.min.js') }}"></script> 
  <!--Horizontal Dropdown--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/horisontal/cbpHorizontalSlideOutMenu.js') }}"></script> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/classie/classie.js') }}"></script> 
  <!--PowerWidgets--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/powerwidgets/powerwidgets.min.js') }}"></script>
  <!--Bootstrap--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/bootstrap/bootstrap.min.js') }}"></script> 
  <!--ToDo--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/todos/todos.js') }}"></script>
  <!--Bootstrap Animation--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/animation/animation.js') }}"></script>
  <!--Main App-->
  <script type="text/javascript" src="{{ URL::asset('Orb/js/scripts.js') }}"></script>
  <!--Calendario-->
  <script src="{{ URL::asset('Orb/bower_components/underscore/underscore-min.js') }}"></script>
  <script src="{{ URL::asset('Orb/bower_components/bootstrap-calendar/js/calendar.js') }}"></script>
  <script type="text/javascript">
    function cambiar() {
      consultor = $('#objetivo').val();
      fecha = $('#fecha').val();
      from = $('#from').val();
      to = $('#to').val();
      $.ajax({
        url: '/calendario/horario/{{$emprendedor[0]->user_id}}',
        type: 'POST',
        data: {consultor: consultor, fecha: fecha, from: from, to: to},
        dataType: 'JSON',
        error: function()
        {
          $("#hora").html('Ha ocurrido un error...');
        },
        success: function(respuesta)
        {
          if (respuesta)
          {	    
	    var html = '';
	    for (i = 0; i < respuesta.horarios.length; i++) {
	      html += '<option value="'+respuesta.horarios[i].id+'">'+respuesta.horarios[i].horario+'</option>';
	    }
	    $("#horario").html(html);
	    if (respuesta.warning == "Hay eventos") {
	      $("#cita").html('<button onClick="return confirm(\'Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?\');" class="btn btn-primary" id="cita_boton">Crear</button>');
	    }else{
	      $("#cita").html('<button class="btn btn-primary" id="cita_boton">Crear</button>');
	    }
	    if (respuesta.warning_evento == "Hay eventos") {
	      $("#eventos").html('<button onClick="return confirm(\'Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?\');" class="btn btn-primary" id="evento_boton">Crear</button>');
	    }else{
	      $("#eventos").html('<button class="btn btn-primary" id="evento_boton">Crear</button>');
	    }
          }
          else {
            $("#hora").html('No se que pasa');
          }          
        }
      });
    }
    $(function () {
      $('#fecha').datetimepicker({
	language: 'es',
	minDate:
	@if(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==0)
	  '{{date ( 'm/j/Y' , strtotime ('+3 day', strtotime(date('j-m-Y'))))}}',
	@elseif(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==6)
	  '{{date ( 'm/j/Y' , strtotime ('+4 day', strtotime(date('j-m-Y'))))}}',
	@else
	  '{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
	@endif
	maxDate:
	@if(date("w", strtotime ('+30 day', strtotime(date('j-m-Y'))))==0)
	  '{{date ( 'm/j/Y' , strtotime ('+31 day', strtotime(date('j-m-Y'))))}}',
	@elseif(date("w", strtotime ('+30 day', strtotime(date('j-m-Y'))))==6)
	  '{{date ( 'm/j/Y' , strtotime ('+32 day', strtotime(date('j-m-Y'))))}}',
	@else
	  '{{date ( 'm/j/Y' , strtotime ('+30 day', strtotime(date('j-m-Y'))))}}',
	@endif
	pickTime: false,
	defaultDate:
	@if(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==0)
	  '{{date ( 'm/j/Y' , strtotime ('+3 day', strtotime(date('j-m-Y'))))}}',
	@elseif(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==6)
	  '{{date ( 'm/j/Y' , strtotime ('+4 day', strtotime(date('j-m-Y'))))}}',
	@else
	  '{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
	@endif
	//'{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
	disabledDates: [
	    moment("12/25/2014"),
	    moment("1/1/2015"),
	    moment("2/2/2015"),
	    moment("3/16/2015"),
	    moment("4/3/2015"),
	    moment("5/1/2015"),
	    moment("9/16/2015"),
	    moment("11/16/2015"),
	    moment("12/25/2015"),
	],
	daysOfWeekDisabled:[0,6]  
      });
      $('#from').datetimepicker({
	  language: 'es',
	  defaultDate: new Date(),
	  minDate: '{{date ( 'm/j/Y')}}',
      });
      $('#to').datetimepicker({
	  language: 'es',
	  defaultDate: new Date(),
	  minDate: '{{date ( 'm/j/Y')}}'
      });
      $("#from").on("dp.change",function (e) {
	$('#to').data("DateTimePicker").setMinDate(e.date);
	if ($("#from").val()>$('#to').val()) {
	  $('#to').val($("#from").val())
	  $('#from').data("DateTimePicker").setMaxDate(e.date);
	}
      });
      $("#to").on("dp.change",function (e) {
	 $('#from').data("DateTimePicker").setMaxDate(e.date);
      });
    });
    //$('#datetimepicker3').data("DateTimePicker").getDate()
    (function($){
      //creamos la fecha actual
      var date = new Date();
      var yyyy = date.getFullYear().toString();
      var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
      var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
  
      //establecemos los valores del calendario
      var options = {
        events_source: '{{url('calendario/obtener/'.$emprendedor[0]->user_id)}}',
        view: 'month',
        language: 'es-MX',
        tmpl_path: '{{url('Orb/bower_components/bootstrap-calendar/tmpls')}}/',
        tmpl_cache: false,
        day: yyyy+"-"+mm+"-"+dd,
        time_start: '9:00',
        time_end: '18:00',
        time_split: '30',
        @if(\Auth::user()->type_id==3)
          width: '100%',
        @else
          width: '88%',
        @endif
        onAfterEventsLoad: function(events) 
        {
          if(!events) 
          {
            return;
          }
          var list = $('#eventlist');
          list.html('');
          $.each(events, function(key, val) 
          {
            $(document.createElement('li'))
              .html('<a href="' + val.url + '">' + val.title + '</a>')
              .appendTo(list);
          });
      },
      onAfterViewLoad: function(view) 
      {
        $('.page-header h3').text(this.getTitle());
        $('.btn-group button').removeClass('active');
        $('button[data-calendar-view="' + view + '"]').addClass('active');
      },
      classes: {
        months: {
          general: 'label'
        }
      }
    };
  
      var calendar = $('#calendar').calendar(options);
  
      $('.btn-group button[data-calendar-nav]').each(function() 
        {
          var $this = $(this);
          $this.click(function() 
          {
            calendar.navigate($this.data('calendar-nav'));
          });
        });
  
      $('.btn-group button[data-calendar-view]').each(function() 
      {
        var $this = $(this);
        $this.click(function() 
        {
          calendar.view($this.data('calendar-view'));
        });
      });
  
      $('#first_day').change(function()
      {
        var value = $(this).val();
        value = value.length ? parseInt(value) : null;
        calendar.setOptions({first_day: value});
        calendar.view();
      });
    }(jQuery));
    function evento(i){
      switch (i) {
        case 2:
          var select = document.getElementById("doc_event");
          var otro = document.getElementById("otro");
          if(select.value==20)
            otro.disabled = false;
          else{
            otro.disabled = true;
            otro.value = "";
          }
          break;
        case 3:
          var select = document.getElementById("emp_event"); 
          var socios = document.getElementById("socios_event");
          if(select.checked == 0){
            socios.disabled = false;
          }else{
            socios.disabled = true;
            socios.value = "";
          }
          break;
      }
    }
  </script>
@stop