@section('titulo')
    IncubaM&aacute;s | Emprendedores
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
    <script type="text/javascript">
        $(window).load(function ()
        {
            $(".nano").nanoScroller({scroll: 'bottom'});
        });
    </script>
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
<div class="container">
    {{-- Modal de documentos --}}
    <div class="modal fade" id="ventana" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h3 style="text-align:center;">Documentos Subidos</h3>
                </div>
                <div class="modal-body">
                    @if(count($subidos) > 0)
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr style="text-align:center;">
                                <th>Documento</th>
                                <th>Fecha de Subida</th>
                                <th colspan="4">Pertenece A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subidos as $subida)
                            <tr>
                                @if($subida->documento_id<>20)
                                <td>
                                	{{$subida->documentos->nombre}}
                                </td>
                                @else
                                <td>
                                	{{$subida->nombre}}
                                </td>
                                @endif
                                <td>
                                	{{$subida->subida}}
                                </td>
                                @if($subida->socio_id<>'')
                                <td>
                                	<strong>Socio: </strong>
                                	{{$subida->socio->nombre}} {{$subida->socio->apellidos}}
                                </td>
                                @else
                                @if($subida->empresa_id<>'')
                            	<td>
                            		<strong>Empresa: </strong>
                            		{{$subida->empresa->nombre_empresa}}
                            	</td>
                                @else
                            	<td>
                            		{{$emprendedor->usuario->nombre}} {{$emprendedor->usuario->apellidos}}
                            	</td>
                                @endif
                                @endif
                                <td>
	                                <a target="_blank" href="{{URL::asset('Orb/documentos/'.$subida->documento)}}">
	                                	<span class="glyphicon glyphicon-cloud-download"></span>
	                                </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
	                </table> 
                    @else
                    <h4 style="text-align: center;">
                    	No hay documentos subidos
                    </h4>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de Pagos --}}
    <div class="modal fade" id="ventana2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="text-align:center;">Pagos Realizados</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-condensed table-bordered margin-0px">
                        <thead>
                            <tr>
                                <th colspan="10" style="text-align: center;">Historial de Pagos</th>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th>Folio</th>
                                <th>Concepto</th>
                                <th>Quien recibe</th>
                                <th>Monto</th>
                                <th>Fecha de Emision</th>
                                <th colspan="2">Siguiente Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($pagos2) > 0)
                                @foreach($pagos2 as $pago)
                                    <tr class="active">
                                        @if($emprendedor->usuario->email<>'')
                                            <td>
                                                <a target="_blank" href="{{url('pagos/imprimir-pago/'.$pago->id)}}" ><i class="fa fa-print"></i></a>
                                            </td>
                                            <td>
                                                <a onClick="return confirm('\u00BFSeguro que deseas enviar?');" href="{{url('pagos/enviar-pago/'.$pago->id)}}" ><i class="fa fa-paper-plane"></i></a>
                                            </td>
                                        @else
                                            <td colspan="2" style="text-align: center"><a target="_blank" href="{{url('emprendedores/imprimir-pago/'.$pago->id)}}" ><i class="fa fa-print"></i></a></td>
                                        @endif
                                        <td>{{$pago->id}}</td>
                                        <td>{{$pago->solicitud->nombre}}</td>
                                        <td>{{$pago->recibido->nombre}} {{$pago->recibido->apellidos}}</td>
                                        <td>{{$pago->monto_total}}</td>
                                        @if($pago->siguiente<>'')
                                            <td>{{$pago->emision}}</td>
                                            <td colspan="2">{{$pago->siguiente}}</td>
                                        @else
                                            <td>{{$pago->emision}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10"><i>No hay pagos registrados</i></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>    
        </div>
    </div>
</div>
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            	<i class="fa fa-times-circle"></i>
            </button>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            	<i class="fa fa-times-circle"></i>
            </button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="row" id="powerwidgets">
        <div class="col-md-4 col-sm-6 bootstrap-grid sortable-grid ui-sortable">
            <div role="widget" style="" class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-green-alt powerwidget-sortable" id="widget1" data-widget-editbutton="false">
                <div role="content" class="inner-spacer nopadding">
                    <div class="portlet-big-icon">
                    <a id="id" href="#" data-toggle="modal" data-target="#ventana2" style="color:#FFF">
                        <i class="fa fa-money"></i>
                        <br/>
                        <span style="font-size: 20px;">Estado de Cuenta</span>                
                    </a>
                    </div>
                    <ul class="portlet-bottom-block">
                        <li class="col-md-6 col-sm-6 col-xs-6"><strong>{{$pagos}}</strong>
                            <small>Pagos Realizados</small>
                        </li>
                        <li class="col-md-6 col-sm-6 col-xs-6"><strong>{{$adeudo}}</strong>
                            <small>Adeudo</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 bootstrap-grid sortable-grid ui-sortable">
            <div role="widget" style="" class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-cold-grey powerwidget-sortable" id="widget2" data-widget-editbutton="false">
                <div role="content" class="inner-spacer nopadding">
                    <div class="portlet-big-icon">
                        <a href="{{url('plan-negocios/modelo/'.$emprendedor->id)}}" style="color: #FFF;">
                            <i class="fa fa-child"></i><br/>
                            <span style="font-size: 20px;">Mi Modelo de Negocio</span>
                        </a>
                    </div>
                    <ul class="portlet-bottom-block">
                        <li class="col-md-6 col-sm-6 col-xs-6"><strong>{{$completados}}</strong>
                            <small>Completado</small>
                        </li>
                        <li class="col-md-6 col-sm-6 col-xs-6"><strong>{{$disponibles}}</strong>
                            <small>Disponibles</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 bootstrap-grid sortable-grid ui-sortable">
            <div role="widget" style="" class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-purple powerwidget-sortable" id="widget3" data-widget-editbutton="false">
                <div role="content" class="inner-spacer nopadding">
                    <div class="portlet-big-icon">
                        <a id="id" href="#" data-toggle="modal" data-target="#ventana" style="color:#FFF">
                        <i class="fa fa-archive"></i><br/>
                            <span style="font-size: 20px;">Documentos</span>
                        </a>
                    </div>
                    <ul class="portlet-bottom-block" >
                        <li class="col-md-4 col-sm-4 col-xs-4"><strong>{{$subidas}}</strong>
                            <small>Subidos</small>
                        </li>
                        <li class="col-md-4 col-sm-4 col-xs-4">
                            <strong>
                                <a href="{{url('emprendedores/subir-documento/'.$emprendedor->id.'/1')}}" style="color:#FFF">
                                    <span class="glyphicon glyphicon-cloud-upload"></span>
                                </a>
                            </strong>
                            <small>Subir</small>
                        </li>
                        <li class="col-md-4 col-sm-4 col-xs-4"><strong>{{$num_documentos}}</strong>
                            <small>Total</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------- Perfil -------------------------------------------------->
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="user-profile">
                <div class="main-info">
                    <div class="user-img">
                        {{ HTML::image('Orb/images/emprendedores/'.$emprendedor->usuario->foto, $emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos) }}
                    </div>
                    <h1>{{$emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos}}</h1>
                    @if($emprendedor->usuario->user!='')
                        Nombre de Usuario | {{$emprendedor->usuario->user}}
                    @else
                        Ingreso a trav&eacutes de Facebook
                    @endif
                </div>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item item1 active"></div>
                        <div class="item item2"></div>
                        <div class="item item3"></div>
                    </div>
                </div>
                <div class="user-profile-info">
                    <div class="tabs-white">
                        <ul id="myTab" class="nav nav-tabs nav-justified">
                            <li @if($active_chat==null)class="active"@endif>
                                <a href="#emprendedor" data-toggle="tab">Emprendedor</a>
                            </li>
                            <li><a href="#empresas" data-toggle="tab">Empresas</a></li>
                            @if(Auth::user()->type_id==3)
                                <li @if($active_chat!=null)class="active"@endif><a href="#mensajes" data-toggle="tab">Mensajes</a></li>
                            @endif
                            <li><a href="#calendario" data-toggle="tab">Calendario de Citas</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <!------------------------------------------------- Emprendedor----------------------------------------------- -->
                            <div class="tab-pane @if($active_chat==null) in active @endif>" id="emprendedor">
                                <div class="profile-header">Acerca de mi</div>
                                <p>{{$emprendedor->about}}</p><br/>
                                <table class="table">
                                    <tr>
                                        <td><strong>Nombre:</strong></td>
                                        <td>{{$emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos}}</td>
                                        <td colspan="2" style="text-align:center; background-color: #F0F0F0;">
                                            <strong>Domicilio</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Genero:</strong></td>
                                        <td>
                                            @if($emprendedor->genero=="M") Masculino @else
                                                @if($emprendedor->genero=="F") Femenino @endif
                                            @endif
                                        </td>
                                        <td><strong>Calle:</strong></td>
                                        <td>{{$emprendedor->calle}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Edad:</strong></td>
                                        <td>{{$emprendedor->edad}} años</td>
                                        <td><strong>N&uacute;mero exterior:</strong></td>
                                        <td>{{$emprendedor->num_ext}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fecha de Nacimiento:</strong></td>
                                        <td>{{$emprendedor->cumple}}</td>
                                        <td><strong>N&uacute;mero interior:</strong></td>
                                        <td>
                                            @if($emprendedor->num_int<>"") {{$emprendedor->num_int}}
                                            @else S/N @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{$emprendedor->usuario->email}}</td>
                                        <td><strong>Colonia o Fraccionamiento:</strong></td>
                                        <td>{{$emprendedor->colonia}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tel&eacute;fono Movil:</strong></td>
                                        <td>{{$emprendedor->tel_movil}}</td>
                                        <td><strong>Municipio:</strong></td>
                                        <td>{{$emprendedor->municipio}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tel&eacute;fono Fijo:</strong></td>
                                        <td>{{$emprendedor->tel_fijo}}</td>
                                        <td><strong>Estado:</strong></td>
                                        <td>{{$emprendedor->estado}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>CURP:</strong></td>
                                        <td>{{$emprendedor->curp}}</td>
                                        <td><strong>CP:</strong></td>
                                        <td>{{$emprendedor->cp}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lugar de Nacimiento:</strong></td>
                                        <td>{{$emprendedor->lugar_nacimiento}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estado Civil:</strong></td>
                                        <td>{{$emprendedor->estado_civil}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>M&aacute;ximo Nivel Escolar:</strong></td>
                                        <td>{{$emprendedor->escolaridad}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>A&ntilde;os que has trabajado:</strong></td>
                                        <td>{{$emprendedor->tiempo_trabajando}}</td>
                                        <td colspan="2" style="text-align:center; background-color: #F0F0F0;">
                                            <strong>Programa</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Salario Mensual:</strong></td>
                                        <td>{{$emprendedor->salario_mensual}}</td>
                                        <td><strong>Programa:</strong></td>
                                        <td>{{$emprendedor->programa}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Emprendimientos anteriores:</strong></td>
                                        <td>{{$emprendedor->veces_emprendido}}</td>
                                        <td><strong>Estatus:</strong></td>
                                        <td>{{$emprendedor->estatus}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dependientes:</strong></td>
                                        <td>{{$emprendedor->personas_dependen}}</td>
                                        <td><strong>Fecha de ingreso:</strong></td>
                                        <td>{{$emprendedor->ingresa}}</td>
                                    </tr>
                                </table>
                            </div>
                            <!----------------------------------------------Empresas------------------------------------------------------>
                            <div class="tab-pane" id="empresas">
                                @if(count($emprendedor->empresas) > 0)
                                    @foreach($emprendedor->empresas as $empresa)
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
                                                <td></td>
                                                <td></td>
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
                                        </table>
                                    @endforeach
                                @else
                                    <i>No hay empresas registradas</i>
                                @endif
                            </div>
                            @if(Auth::user()->type_id==3)
                                <!--------------------------------------Calendario de citas-------------------------------------------------->
                                <div class="tab-pane @if($active_chat!=null) in active @endif" id="mensajes">
                                    <div class="chat-container">
                                        <div class="top-buttons clearfix">
                                            <h2 class="margin-0px pull-left">&nbsp;&nbsp;Mensajes</h2>
                                            <span id="titulo_chat" class="badge"></span>
                                            <div class="btn-group btn-group-sm pull-right">
                                                {{HTML::link('mensajes/crear-emprendedor/'.$emprendedor->id,'Crear una Conversacion', ['class'=>'btn btn-primary', 'style'=>'color:#FFF'])}}
                                            </div>
                                        </div>
                                        <nav class="chat-users-menu">
                                            <div class="nano">
                                                <div class="nano-content" id="chats_div">
                                                    <div class="menu-header">
                                                        <a class="btn btn-default chat-toggler">
                                                            <i class="fa fa-user"></i>
                                                            <i class="fa fa-arrow-down"></i>
                                                        </a>
                                                    </div>
                                                    <ul id="ul_chats">
                                                        @if(count($chats)>0)
                                                            <?php $grupal=0; $publico=0;?>
                                                            @foreach($chats as $chat)
                                                                <li>
                                                                    @if($chat->chat->grupo==1||$chat->chat->grupo==3)
                                                                        @if($chat->chat->grupo==3)
                                                                            @if($grupal<>$chat->chat_id)
                                                                                <?php $grupal=$chat->chat_id;?>
                                                                                <a href="{{url('emprendedores/perfil/'.$emprendedor->id.'/'.$chat->chat_id)}}">
                                                                                    <span class="chat-name">{{$chat->chat->nombre}}</span>
                                                                                    <span class="user-img">
                                                                                        {{ HTML::image('Orb/images/chats/'.$chat->chat->foto, $chat->chat->nombre)}}
                                                                                    </span>
                                                                                    <span class="label label-success" style="font-size: 0.6em;">Grupal</span>
                                                                                </a>
                                                                            @endif
                                                                        @else
                                                                            @if($publico<>$chat->chat_id)
                                                                                <?php $publico=$chat->chat_id;?>
                                                                                <a href="{{url('emprendedores/perfil/'.$emprendedor->id.'/'.$chat->chat_id)}}">
                                                                                    <span class="chat-name">{{$chat->chat->nombre}}</span>
                                                                                    <span class="user-img">
                                                                                        {{ HTML::image('Orb/images/chats/'.$chat->chat->foto, $chat->chat->nombre) }}
                                                                                    </span>
                                                                                    <span class="label label-success" style="font-size: 0.6em;">Publico</span>
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        <a href="{{url('emprendedores/perfil/'.$emprendedor->id.'/'.$chat->chat_id)}}">
                                                                            <span class="chat-name">{{$chat->usuario->nombre}} {{$chat->usuario->apellidos}}</span>
                                                                            <span class="user-img">
                                                                                {{ HTML::image('Orb/images/emprendedores/'.$chat->usuario->foto, $chat->usuario->nombre.' '.$chat->usuario->apellidos) }}
                                                                            </span>
                                                                            <span class="label label-success" style="font-size: 0.6em;">{{$chat->usuario->puesto}}</span>
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </nav>
                                        <div class="chat-container" id="super_chat">
                                            <div class="chat-pusher">
                                                <div class="chat-content">
                                                    <div class="nano">
                                                        <div class="nano-content" style="left : 20px;">
                                                            <div class="chat-content-inner">
                                                                <div class="clearfix">
                                                                    <div class="chat-messages chat-messages-with-sidebar" id="div_chat">
                                                                        <ul>
                                                                            @if(count($mensajes) > 0)
                                                                                @foreach($mensajes as $mensaje)
                                                                                    <li class="@if ($mensaje->user_id != Auth::user()->id) left @else right @endif clearfix">
                                                                                        <span class="@if ($mensaje->user_id != Auth::user()->id) user-img pull-left @else user-img pull-right @endif">
                                                                                            {{ HTML::image('Orb/images/emprendedores/'.$mensaje->usuario->foto, $mensaje->usuario->nombre.' '.$mensaje->usuario->apellidos, ['class'=>"img-circle"]) }}
                                                                                        </span>
                                                                                        <div class="chat-body clearfix">
                                                                                            <div class="header">
                                                                                                <span class="name">{{$mensaje->usuario->nombre.' '.$mensaje->usuario->apellidos}}</span>
                                                                                                <span class="badge">{{$mensaje->envio}}</span>
                                                                                            </div>
                                                                                            <p>{{$mensaje->cuerpo}}</p>
                                                                                            @if($mensaje->archivo!=null)
                                                                                                <span class="borde"><a target="_blank" href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->archivo)}}">{{$mensaje->original}}</a></span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                @if(count($active_chat)>0)
                                                                                    <i style="color: rgb(122, 123, 122);">No hay mensajes registrados</i>
                                                                                @else
                                                                                    <i style="color: rgb(122, 123, 122);">Selecciona o crea una conversaci&oacute;n</i>
                                                                                @endif
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inner-spacer" style="padding:0px;">
                                        <div class="chat-message-form">
                                            {{Form::open(['url'=>'mensajes/enviar-mensaje', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                                                @if(count($active_chat)>0)
                                                    {{Form::hidden('chat_id', $active_chat->chat_id)}}
                                                @else
                                                    {{Form::hidden('chat_id')}}
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        @if(count($active_chat)>0)
                                                            @if($active_chat->chat->grupo!=1)
                                                                {{Form::text('cuerpo', null, ['placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off"])}}
                                                            @else
                                                                {{Form::text('cuerpo', null , ['placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off", 'disabled'])}}
                                                            @endif
                                                        @else
                                                            {{Form::text('cuerpo', null , ['placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off", 'disabled'])}}
                                                        @endif
                                                        <div class="col-md-7 col-sm-8 col-xs-8">
                                                            <div class="btn-group">
                                                                <span style="display: inline-block;">
                                                                    @if(count($active_chat)>0)
                                                                        @if($active_chat->chat->grupo!=1)
                                                                            {{Form::file('archivo', ['id'=>'archivo'])}}
                                                                        @else
                                                                            {{Form::file('archivo', ['id'=>'archivo', 'disabled'=>"true"])}}
                                                                        @endif
                                                                    @else
                                                                        {{Form::file('archivo', ['id'=>'archivo', 'disabled'=>"true"])}}
                                                                    @endif
                                                                    <br/><br/><span class="message-error" style="font-weight: bold">{{$errors->first('archivo')}}</span>
                                                                    <script>
                                                                        $("#archivo").fileinput({
                                                                            browseLabel: "",
                                                                            showCaption: false,
                                                                            removeClass: "btn btn-danger",
                                                                            removeLabel: "Borrar",
                                                                            removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                                                                            showUpload: false
                                                                        });
                                                                    </script>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            @if(count($active_chat)>0)
                                                                @if($active_chat->chat->grupo!=1)
                                                                    <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right"/>
                                                                @else
                                                                    <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" disabled/>
                                                                @endif
                                                            @else
                                                                <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" disabled/>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-11">
                                                            <span class="message-error" style="font-weight: bold; color: white">{{$errors->first('cuerpo')}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                           <!--------------------------------------Calendario de citas-------------------------------------------------->
                            <div class="tab-pane" id="calendario">
                                <div class="profile-header">Calendario de Citas</div>
                                <div class="container">
                                    <div class="row">
                                        <div class="page-header" style="width: @if(\Auth::user()->type_id==3) 100%; @else 80%; @endif ">
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
                                            @if(Auth::user()->type_id == 3)
                                                @if($emprendedor->estatus=="Activo")
                                                    <a class="btn btn-info" href="#myModal3" data-toggle="modal">Solicitar Cita</a>&nbsp;&nbsp;
                                                @endif
                                                <a class="btn btn-info" href="#myModal1" data-toggle="modal">Crear Evento</a>&nbsp;&nbsp;
                                                <a class="btn btn-info" href="#admin" data-toggle="modal">Borrar del Calendario</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <!--------------------------------------Redes Sociales-------------------------------------------------->
                            <div class="social-buttons">
                                <ul class="social">
                                    <li><a target="_blank" href="https://www.facebook.com/IncubaMas"><i
                                                    class="entypo-facebook-circled"></i></a></li>
                                    <li><a target="_blank"
                                           href="https://www.linkedin.com/company/incubam%C3%A1s"><i
                                                    class="entypo-linkedin-circled"></i></a></li>
                                    <li><a target="_blank"
                                           href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i
                                                    class="entypo-gplus-circled"></i></a></li>
                                    <li><a target="_blank" href="https://twitter.com/IncubaMas"><i
                                                    class="entypo-twitter-circled"></i></a></li>
                                </ul>
                            </div>
                            <!---------------------------------------------------/Profile----------------------------------------------- -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------Solicitar Cita -------------------------------------------------->
    <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="titulo_pago">Solicitar Cita</h4>
                </div>
                {{Form::open(['url'=>'calendario/cita', 'class'=>'orb-form','method' => 'post'])}}
                <div class="modal-body">
                    <fieldset>
                        <div class="col-md-11 espacio_abajo">
                            {{Form::label('user', '* Asesor', ['class' => 'label'])}}
                            <label class="select">
                                {{Form::select('user', $asesores,  '', ['id' => 'asesores'])}}
                            </label>
                            <span class="message-error">{{$errors->first('user')}}</span>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('start', '* Fecha', ['class' => 'label'])}}
                            <label class="input">
                                {{Form::text('start', '', ['class'=>'form-control', 'readonly', 'id'=>'fecha'])}}
                            </label>
                            <span class="message-error">{{$errors->first('start')}}</span>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('horario_id', '* Hora', ['class' => 'label'])}}
                            <label class="select" id='divHorarioCita'>
                                {{Form::select('horario_id', [null=>'Primero Selecciona al asesor'])}}
                            </label>
                            <span class="message-error">{{$errors->first('horario_id')}}</span>
                        </div>
                        <div class="col-md-11 espacio_abajo">
                            {{Form::label('cuerpo', 'Asunto', ['class' => 'label'])}}
                            <label class="input">
                                {{Form::text('cuerpo', '', ['class'=>'form-control', 'id'=>"body"])}}
                            </label>
                            <span class="message-error">{{$errors->first('cuerpo')}}</span>
                        </div>
                        <div class="col-md-11 espacio_abajo">
                            {{Form::label('empresa', 'Selecciona la opci&oacute;n deseada', ['class' => 'label'])}}
                            {{Form::checkbox('correo', 'yes')}} Enviarme un correo con los datos de la Cita<br/>
                        </div>
                        <div class="col-md-11 espacio_abajo" style="text-align: left;">
                            <br/>* Los campos son obligatorios
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <span id="cita">
                            <button class="btn btn-primary" id="cita_boton">Solicitar</button>
                    </span>
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    <!--------------------------------------Crear Evento -------------------------------------------------->
    <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Crear Evento</h4>
                </div>
                {{Form::open(['url'=>'calendario/evento', 'class'=>'orb-form','method' => 'post'])}}
                <div class="modal-body">
                    <fieldset>
                        <h5>Los eventos solo se a&ntilde;aden a tu calendario personal.</h5><br/>
                        <div class="col-md-6 espacio_abajo">
                            {{Form::label('titulo', '* Nombre del evento', ['class' => 'label'])}}
                            <label class="input">
                                {{Form::text('titulo', '', ['class'=>'form-control', 'id'=>"body"])}}
                                <span class="message-error">{{$errors->first('titulo')}}</span>
                            </label>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('clase', '* Color del evento', ['class' => 'label'])}}
                            <label class="select">
                                {{Form::select('clase', ["event-info"=>'Azul', "event-success"=>'Verde',"event-inverse"=>'Negro',"event-warning"=>'Amarillo',"event-special"=>'Morado'])}}
                                <span class="message-error">{{$errors->first('clase')}}</span>
                            </label>
                        </div>
                        <div class="col-md-6 espacio_abajo">
                            {{Form::label('start', '* Fecha de Inicio', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend  fa fa-calendar"></i>
                                {{Form::text('start', '', ['class'=>'form-control', 'readonly', 'id'=>'from'])}}
                                <span class="message-error">{{$errors->first('start')}}</span>
                            </label>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('end', '* Fecha de fin', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend  fa fa-calendar"></i>
                                {{Form::text('end', '', ['class'=>'form-control', 'readonly', 'id'=>'to'])}}
                                <span class="message-error">{{$errors->first('end')}}</span>
                            </label>
                        </div>
                        <div class="col-md-6 espacio_abajo">
                            {{Form::label('cuerpo', 'Asunto', ['class' => 'label'])}}
                            <label class="input">
                                {{Form::text('cuerpo','', ['class'=>'form-control', 'id'=>"body"])}}
                                <span class="message-error">{{$errors->first('cuerpo')}}</span>
                            </label>
                        </div>
                        <div class="col-md-15 espacio_abajo">
                            {{Form::label('correo', 'Selecciona la opci&oacute;n deseada', ['class' => 'label'])}}
                            {{Form::checkbox('correo', 'yes')}} Enviarme un correo con los datos del Evento<br/>
                        </div>
                        <div class="col-md-11 espacio_abajo" style="text-align: left;">
                            * Los campos son obligatorios
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <span id="eventos">
                        <button class="btn btn-primary" id="evento_boton">Crear</button>
                    </span>
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    <!--------------------------------------Eliminar Eventos -------------------------------------------------->
    <div id="admin" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Citas y Eventos Futuros</h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                        {{Form::open(['url'=>'calendario/delete-evento-emprendedor', 'class'=>'orb-form','method' => 'post'])}}
                        <div class="modal-body">
                            <fieldset>
                                <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="30%" >Evento</th>
                                            <th width="20%" >Fecha</th>
                                            <th width="10%" >Estatus</th>
                                            <th width="10%" >Borrar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($eventos)>0)
                                            @foreach($eventos as $evento)
                                                <tr>
                                                    <td>{{$evento->titulo}}</td>
                                                    <td>{{$evento->fecha}}</td>
                                                    <td> @if($evento->confirmation == 1) Confirmado @else Sin confirmar @endif </td>
                                                    <td>{{ Form::radio('evento_id', $evento->id) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="4" style="font-style: italic; color: gray;">No tienes eventos registrados</td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div id = "divBorrarCita" class="col-md-11 espacio_abajo" style="visibility: hidden">
                                    {{Form::label('empresa', 'Selecciona la opci&oacute;n deseada', ['class' => 'label'])}}
                                    {{Form::checkbox('correo', 'yes')}} Enviarme un correo con los datos del Evento/Cita Cancelada<br/>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                        <span id="botonCita" style="visibility: hidden">
                            <button class="btn btn-primary" id="cita_boton">Borrar</button>
                        </span>
                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        </div>
                        {{Form::close()}}
                    </fieldset>
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
        $("input[name=evento_id]:radio").change(function () {
            $( "#divBorrarCita" ).css('visibility', 'visible');
            $( "#botonCita" ).css('visibility', 'visible');
        });

        var eventos = {
            change: function(){
                emprendedor = $('#asesores').val();
                fecha = $('#fecha').val();
                $.ajax({
                    url: '/calendario/horario-emprendedor',
                    type: 'POST',
                    data: {emprendedor: emprendedor, fecha: fecha},
                    dataType: 'JSON',
                    error: function () {
                        $("#divHorarioCita").html('Ha ocurrido un error...');
                    },
                    success: function (respuesta) {
                        html='';
                        if (respuesta) {
                            html = '<select name="horario_id" id="horario_id">';
                            if(respuesta.result.length>0)
                                for (i = 0; i < respuesta.result.length; i++)
                                    html += '<option value="' + respuesta.result[i].id + '">' + respuesta.result[i].horario + '</option>';
                            else
                                html += '<option value selected="selected">No hay horarios disponibles</option>';
                            html += '</select><span class="message-error">{{$errors->first('horario_id')}}</span>';
                            $("#divHorarioCita").html(html);
                        }
                        else {
                            $("#divHorarioCita").html('No se que pasa');
                        }
                    }
                });
            }
        };
        $('#asesores').on(eventos);
        $('#fecha').on(eventos);


        //Configura el calendario para citas
        $('#fecha').datetimepicker({
            language: 'es',
            disabledDates: [
                moment("12/25/2014"),
                moment("1/1/2015"),
                moment("2/2/2015"),
                moment("3/16/2015"),
                moment("4/3/2015"),
                moment("5/1/2015"),
                moment("9/16/2015"),
                moment("11/16/2015"),
                moment("12/25/2015")
            ],
            daysOfWeekDisabled: [0, 6],
            pickTime: false,
            minDate:'{{$minDate}}',
            maxDate: '{{$maxDate}}',
            defaultDate: '{{$minDate}}'
        });

        //Configuracion del Calendario
        (function ($) {
            //creamos la fecha actual
            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            //establecemos los valores del calendario
            var options = {
                events_source: '{{url('calendario/obtener/'.$emprendedor->user_id)}}',
                view: 'month',
                language: 'es-MX',
                tmpl_path: '{{url('Orb/bower_components/bootstrap-calendar/tmpls')}}/',
                tmpl_cache: false,
                day: yyyy + "-" + mm + "-" + dd,
                time_start: '9:00',
                time_end: '18:00',
                time_split: '30',
                @if(\Auth::user()->type_id==3)
                    width: '100%',
                @else
                    width: '80%',
                @endif
                onAfterEventsLoad: function (events) {
                    if (!events) {
                        return;
                    }
                    var list = $('#eventlist');
                    list.html('');
                    $.each(events, function (key, val) {
                        $(document.createElement('li'))
                                .html('<a href="' + val.url + '">' + val.title + '</a>')
                                .appendTo(list);
                    });
                },
                onAfterViewLoad: function (view) {
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

            $('.btn-group button[data-calendar-nav]').each(function () {
                var $this = $(this);
                $this.click(function () {
                    calendar.navigate($this.data('calendar-nav'));
                });
            });

            $('.btn-group button[data-calendar-view]').each(function () {
                var $this = $(this);
                $this.click(function () {
                    calendar.view($this.data('calendar-view'));
                });
            });

            $('#first_day').change(function () {
                var value = $(this).val();
                value = value.length ? parseInt(value) : null;
                calendar.setOptions({first_day: value});
                calendar.view();
            });

        }(jQuery));
        //Configurar las cajas con calendarios
        $(function () {
            $('#from').datetimepicker({
                language: 'es',
                defaultDate: new Date()
            });
            $('#to').datetimepicker({
                language: 'es',
                defaultDate: new Date()
            });
            $("#from").on("dp.change", function (e) {
                if ($("#from").val() > $('#to').val()) {
                    $('#to').data("DateTimePicker").setDate(e.date);
                }
            });
            $("#to").on("dp.change", function (e) {
                if ($("#from").val() > $('#to').val()) {
                    $('#from').data("DateTimePicker").setDate(e.date);
                }
            });
        });
    </script>
@stop