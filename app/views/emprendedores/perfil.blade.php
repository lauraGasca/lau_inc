@section('titulo')
    IncubaM&aacute;s | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('css')
    @parent
    <!---Calendario-->
    {{ HTML::style('Orb/bower_components/bootstrap-calendar/css/calendar.css') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js') }}
    {{ HTML::style('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::script('Orb/bower_components/moment/moment.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js') }}
    <!--Chat-->
    {{ HTML::style('Orb/css/vendors/x-editable/select2.css') }}
    {{ HTML::style('Orb/css/vendors/x-editable/bootstrap-editable.css') }}
    <script type="text/javascript">
        $(window).load(function () {
            $(".nano").nanoScroller({scroll: 'bottom'});
        });

        //Metodos para commit
        (function ($) {
            //var root = 'http://incubamas.com/';
            var root = 'http://incuba.local/';
            var timestamp = 0;
            var url = '{{url('chat/backend')}}';
            var noerror = true;
            var ajax;

            function handleResponse(response) {
                if (response['msg'] != 0) {
                    var html = '';
                    if (response['msg'] != 1) {
                        var nombre = '';
                        var foto = '';
                        if (response['msg'][0].asesor == null) {
                            if (response['msg'][0].emprendedor == null) {
                                nombre = 'Incubito';
                                foto = 'Orb/images/emprendedores/generic-emprendedor.png';
                            } else {
                                nombre = response['msg'][0].emprendedor;
                                foto = 'Orb/images/emprendedores/' + response['msg'][0].emprendedor_foto;
                            }
                        } else {
                            nombre = response['msg'][0].asesor;
                            foto = 'accio/images/equipo/' + response['msg'][0].asesor_foto;
                        }

                        if (response['msg'][0].user_id != {{Auth::user()->id}}) {
                            html += '<li class="left clearfix">' +
                            '<span class="user-img pull-left">' +
                            '<img src="' + root + foto + '" alt="Foto" class="img-circle" />' +
                            '</span>' +
                            '<div class="chat-body clearfix">' +
                            '<div class="header">' +
                            '<span class="name">' + nombre + '</span>' +
                            '<span class="badge"><i class="fa fa-clock-o"></i>' + response['msg'][0].created_at + '</span>' +
                            '</div>' +
                            '<p>' + response['msg'][0].cuerpo + '</p>';
                            if (response['msg'][0].archivo != null)
                                html += '<span class="borde"><a target="_blank" href="' + root + 'Orb/images/adjuntos/' + response['msg'][0].archivo + '">' + response['msg'][0].original + '</a></span>';
                            html += '</div>' +
                            '</li>';
                        } else {
                            html += '<li class="right clearfix">' +
                            '<span class="user-img pull-right">' +
                            '<img src="' + root + foto + '" alt="Foto" class="img-circle" />' +
                            '</span>' +
                            '<div class="chat-body clearfix">' +
                            '<div class="header">' +
                            '<span class="name">' + nombre + '</span>' +
                            '<span class="badge"><i class="fa fa-clock-o"></i>' + response['msg'][0].created_at + '</span>' +
                            '</div>' +
                            '<p>' + response['msg'][0].cuerpo + '</p>';
                            if (response['msg'][0].archivo != null)
                                html += '<span class="borde"><a target="_blank" href="' + root + 'Orb/images/adjuntos/' + response['msg'][0].archivo + '">' + response['msg'][0].original + '</a></span>';
                            html += '</div>' +
                            '</li>';
                        }
                        $("#div_chat").append(html);
                    }
                }
            }

            function connect() {
                ajax = $.ajax(url, {
                    type: 'get',
                    data: {'timestamp': timestamp},
                    success: function (transport) {
                        eval('var response = ' + transport);
                        timestamp = response['timestamp'];
                        handleResponse(response);
                        noerror = true;
                    },
                    complete: function (transport) {
                        (!noerror) && setTimeout(function () {
                            connect()
                        }, 5000) || connect();
                        noerror = false;
                    }
                });
            }

            $(document).ready(function () {
                connect();
            });

        })(jQuery);
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
        <h1>Emprendedores
            <small> Perfil</small>
        </h1>
    @endif
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
    <div class="row" id="powerwidgets">
        <div class="col-md-4 col-sm-6 bootstrap-grid sortable-grid ui-sortable">
            <div role="widget" style="" class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-green-alt powerwidget-sortable" id="widget1" data-widget-editbutton="false">
                <div role="content" class="inner-spacer nopadding">
                    <div class="portlet-big-icon">
                        <i class="fa fa-money"></i><br/>
                        <span style="font-size: 20px;">Estado de Cuenta</span>
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
                        <a href="{{url('plan-negocios/index/'.$emprendedor->id)}}" style="color: #FFF;">
                            <i class="fa fa-child"></i><br/>
                            <span style="font-size: 20px;">Mi Modelo de Negocio</span>
                        </a>
                    </div>
                    <ul class="portlet-bottom-block">
                        <li class="col-md-6 col-sm-6 col-xs-6"><strong>5</strong>
                            <small>Completado</small>
                        </li>
                        <li class="col-md-6 col-sm-6 col-xs-6"><strong>100</strong>
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
                        <i class="fa fa-archive"></i><br/>
                        <span style="font-size: 20px;">Documentos</span>
                    </div>
                    <ul class="portlet-bottom-block">
                        <li class="col-md-4 col-sm-4 col-xs-4"><strong>{{$subidas}}</strong>
                            <small>Subidos</small>
                        </li>
                        <li class="col-md-4 col-sm-4 col-xs-4">
                            <strong>
                                <a href="" href="#myModal2" data-target="#myModal2" data-toggle="modal" style="color:#FFF">
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
    <!------------------------------------------------- Perfil------------------------------------------------->
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="user-profile">
                <div class="main-info">
                    <div class="user-img">
                        {{ HTML::image('Orb/images/emprendedores/'.$emprendedor->usuario->foto, $emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos) }}
                    </div>
                    <h1>{{$emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos}}</h1>
                    Nombre de Usuario | {{$emprendedor->usuario->user}}
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
                            <li @if(!isset($active_chat)) class="active" @endif >
                                <a href="#emprendedor" data-toggle="tab">Emprendedor</a>
                            </li>
                            <li><a href="#empresas" data-toggle="tab">Empresas</a></li>
                            @if(Auth::user()->type_id==3)
                                <li @if(isset($active_chat)) class="active" @endif >
                                    <a href="#mensajeria" data-toggle="tab">Mensajeria</a>
                                </li>
                            @endif
                            <li><a href="#calendario" data-toggle="tab">Calendario de Citas</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <!------------------------------------------------- Emprendedor------------------------------------------------->
                            <div class="tab-pane @if(!isset($active_chat)) in active @endif " id="emprendedor">
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
                                            @if($emprendedor->genero=="M") Masculino
                                            @else
                                                @if($emprendedor->genero=="F") Femenino
                                                @else
                                                @endif
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
                            <!--------------------------------------Chat------------------------------------------------------------->
                            @if (Auth::user()->type_id == 3)
                                <div class="tab-pane
            @if(isset($active_chat))
              in active
            @endif
                                        " id="mensajeria">
                                    <div class="profile-header">Mensajeria</div>
                                    <div class="container">
                                        <!--Empieza el chat-->
                                        <div>
                                            <div class="chat-container">
                                                <div class="top-buttons clearfix">
                                                    <h2 class="margin-0px pull-left">&nbsp;&nbsp;Chat</h2>
                                                    <span id="titulo_chat" class="badge">{{$active_nombre}}</span>
                                                </div>
                                                <nav class="chat-users-menu">
                                                    <!--Adding Some Scroll-->
                                                    <div class="nano">
                                                        <div class="nano-content" id="chats_div">
                                                            <div class="menu-header">
                                                                <a class="btn btn-default chat-toggler">
                                                                    <i class="fa fa-user"></i>
                                                                    <i class="fa fa-arrow-down"></i>
                                                                </a>
                                                            </div>
                                                            <ul id="ul_chats">
                                                                <?php
                                                                $enc_chat = false;
                                                                $i = 0;
                                                                ?>
                                                                @if(count($chats) > 0)
                                                                    @foreach($chats as $chat)
                                                                        <?php
                                                                        $i++;
                                                                        $var_chat = $chat->chat;
                                                                        $var_user = $chat->user_id;
                                                                        ?>
                                                                        @if($chat->chat=="")
                                                                            <?php $var_chat = 0;?>
                                                                        @endif

                                                                        @if($chat->user_id=="")
                                                                            <?php $var_user = 0;?>
                                                                        @endif

                                                                        <li>
                                                                            <a href="{{url('emprendedores/perfil/'.$emprendedor->id.'/'.$var_chat.'/'.$var_user.'/'.$chat->grupo.'/'.$chat->nombre.'#mensajeria')}}">
                                    <span class="chat-name">{{$chat->nombre}}<span>
                                        <span class="user-img"><img src="{{URL::asset($chat->foto)}}" alt="User"/>
                                    </span>
                                    <br/>
                                    <span class="label label-success" style="font-size: 0.6em;">
                                      @if($chat->puesto<>"")
                                            {{$chat->puesto}}
                                        @else
                                            Emprendedor
                                        @endif
                                    </span>
                                            @if($i !=1)
                                                @if($chat->ultimo_mensaje!=null && $chat->ultimo_visto!=null)
                                                    @if($chat->ultimo_mensaje > $chat->ultimo_visto)
                                                        <span class="badge" id="nuevo{{$var_chat}}">Nuevos</span>
                                                                                @endif
                                                                                @endif
                                                                                @endif
                                                                            </a>
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
                                                            <!-- this is the wrapper for the content -->
                                                            <div class="nano"><!-- this is the nanoscroller -->
                                                                <div class="nano-content" style="left : 20px;">
                                                                    <div class="chat-content-inner">
                                                                        <div class="clearfix">
                                                                            <div class="chat-messages chat-messages-with-sidebar"
                                                                                 id="div_chat">
                                                                                <ul>
                                                                                    @if(count($mensajes) > 0)
                                                                                        @foreach($mensajes as $mensaje)
                                                                                            @if ($mensaje->asesor==null)
                                                                                                @if($mensaje->emprendedor==null)
                                                                                                    <?php
                                                                                                    $nombre = 'Incubito';
                                                                                                    $foto = 'Orb/images/emprendedores/generic-emprendedor.png';
                                                                                                    ?>
                                                                                                @else
                                                                                                    <?php
                                                                                                    $nombre = $mensaje->emprendedor;
                                                                                                    $foto = 'Orb/images/emprendedores/' . $mensaje->emprendedor_foto;
                                                                                                    ?>
                                                                                                @endif
                                                                                            @else
                                                                                                <?php
                                                                                                $nombre = $mensaje->asesor;
                                                                                                $foto = 'accio/images/equipo/' . $mensaje->asesor_foto;
                                                                                                ?>
                                                                                            @endif
                                                                                            <li class="
                                          @if ($mensaje->user_id != Auth::user()->id)
                                            left
                                          @else
                                                                                                    right
                                                                                                  @endif
                                                                                                    clearfix">
                                            <span class="user-img
                                          @if ($mensaje->user_id != Auth::user()->id)
                                            pull-left
                                          @else
                                                    pull-right
                                                  @endif
                                                    ">
                                              <img src="{{URL::asset($foto)}}" alt="Foto" class="img-circle"/>
                                            </span>

                                                                                                <div class="chat-body clearfix">
                                                                                                    <div class="header">
                                                                                                        <span class="name">{{$nombre}}</span>
                                                                                                            <span class="badge"><i
                                                                                                                        class="fa fa-clock-o"></i>{{$mensaje->envio}}</span>
                                                                                                    </div>
                                                                                                    <p>{{$mensaje->cuerpo}}</p>
                                                                                                    @if($mensaje->archivo!=null)
                                                                                                        <span class="borde"><a
                                                                                                                    target="_blank"
                                                                                                                    href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->archivo)}}">{{$mensaje->original}}</a></span>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <i>No hay mensajes</i>
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /nano -->
                                                        </div>
                                                        <!-- /chat-content -->
                                                    </div>
                                                    <!-- /chat-pusher -->
                                                </div>
                                            </div>
                                            <!-- /chat-container-->
                                            <div class="inner-spacer" style="padding:0px;">
                                                <!--Chat-form -->
                                                <div class="chat-message-form">
                                                    {{Form::open(array('url'=>'chat/enviarmensaje', 'class'=>'orb-form','method' => 'post', 'id'=>'mensaje_form','enctype'=>'multipart/form-data', 'target'=>"contenedor_subir_archivo"))}}
                                                    {{Form::hidden('user_id',$active_user)}}
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            @if($active_group==1 && Auth::user()->type_id<>1)
                                                                {{Form::text('mensaje','',array('id'=>'text_mensaje', 'placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off", 'disabled'))}}
                                                            @else
                                                                {{Form::text('mensaje','',array('id'=>'text_mensaje', 'placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off"))}}
                                                            @endif
                                                            <div class="col-md-7 col-sm-8 col-xs-8">
                                                                <div class="btn-group">
                              <span style="display: inline-block;">
                                  <input type="file" id="imagen" name="imagen" class="filestyle" data-input="false"
                                         data-iconName="glyphicon-camera" data-buttonText="">
                              </span>
                              <span style="display: inline-block;">
                                  <input type="file" id="archivo" name="archivo" class="filestyle" data-input="false"
                                         data-iconName="glyphicon-paperclip" data-buttonText="">
                              </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                @if($active_group==1 && Auth::user()->type_id<>1)
                                                                    <input type="submit" value="Enviar"
                                                                           id="boton_enviar"
                                                                           class="btn btn-info pull-right" disabled
                                                                           onclick="enviarMensaje();"/>
                                                                @else
                                                                    <input type="submit" value="Enviar"
                                                                           id="boton_enviar"
                                                                           class="btn btn-info pull-right"
                                                                           onclick="enviarMensaje();"/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{Form::close()}}
                                                    </div>
                                                    <iframe width="1" height="1" frameborder="0"
                                                            name="contenedor_subir_archivo"
                                                            style="display: none"></iframe>
                                                    <!-- /Chat-form -->
                                                </div>
                                                <div id="cargar"
                                                     style="color: rgb(165, 165, 165); font-weight: bold;"></div>
                                                <div id="div_mensaje"
                                                     style="color: rgb(223, 77, 77); font-weight: 900; text-align: center;"></div>
                                                <!-- End Widget -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endif
                                        <!--------------------------------------Calendario de citas-------------------------------------------------->
                                <div class="tab-pane" id="calendario">
                                    <div class="profile-header">Calendario de Citas</div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="page-header" style="width:
                                            @if(\Auth::user()->type_id==3)
                                                    100%;
                                            @else
                                                    88%;
                                            @endif
                                                    ">
                                                <div class="pull-right form-inline"
                                                     style="float: left !important; width: 98%;">
                                                    <div class="btn-group">
                                                        <button class="btn btn-primary" data-calendar-nav="prev">
                                                            <<
                                                        </button>
                                                        <button class="btn" data-calendar-nav="today">Hoy</button>
                                                        <button class="btn btn-primary" data-calendar-nav="next">
                                                            >>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group" style="float: right;">
                                                        <button class="btn btn-warning" data-calendar-view="year">
                                                            Año
                                                        </button>
                                                        <button class="btn btn-warning active"
                                                                data-calendar-view="month">Mes
                                                        </button>
                                                        <button class="btn btn-warning" data-calendar-view="week">
                                                            Semana
                                                        </button>
                                                        <button class="btn btn-warning" data-calendar-view="day">
                                                            Día
                                                        </button>
                                                    </div>
                                                </div>
                                                <br/><br/><br/><br/><br/>

                                                <h3 style="display: inline-block;"></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                @if($emprendedor->estatus=="Activo")
                                                    <a class="btn btn-info" href="#myModal3" data-toggle="modal">Solicitar
                                                        Cita</a>&nbsp;&nbsp;
                                                @endif
                                                <a class="btn btn-info" href="#myModal1" data-toggle="modal">Crear
                                                    Evento</a>
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
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Modal title</h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 400px">
                                                        <p>One fine body&hellip;</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="button" class="btn btn-primary">Save changes
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
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
                                <!---------------------------------------------------/Profile------------------------------------------------->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------------------------/Fin------------------------------------------------->
    </div>

    <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Crear Evento</h4>
                </div>
                {{ Form::open(array('url'=>'calendario/evento/'.$emprendedor->user_id, 'class'=>'orb-form','method' => 'post') )}}
                {{Form::hidden('destino','emprendedores/perfil/'.$emprendedor->id)}}
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
                                {{Form::select('class', array("event-info"=>'Azul', "event-success"=>'Verde',"event-inverse"=>'Negro',"event-warning"=>'Amarillo',"event-special"=>'Morado'))}}
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
                  <button onClick="return confirm('Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?');"
                          class="btn btn-primary" id="evento_boton">Crear
                  </button>
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

    <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="titulo_pago">Solicitar Cita</h4>
                </div>
                {{ Form::open(array('url'=>'calendario/crear/'.$emprendedor->user_id, 'class'=>'orb-form','method' => 'post') )}}
                {{Form::hidden('destino','emprendedores/perfil/'.$emprendedor->id)}}
                <div class="modal-body">
                    <fieldset>
                        <div class="col-md-11 espacio_abajo">
                            {{Form::label('consultor', '* Consultor', array('class' => 'label'))}}
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
                  <button onClick="return confirm('Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?');"
                          class="btn btn-primary" id="cita_boton">Crear
                  </button>
              @else
                  <button onClick="alert('Recibiras un correo cuando tu cita sea confirmada')" class="btn btn-primary"
                          id="cita_boton">Crear
                  </button>
              @endif
          </span>
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div id="myModal2" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Subir Documentos</h4>
                </div>
                {{ Form::open(array('url'=>'emprendedores/subirdocumento', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
                {{Form::hidden('emprendedor_id',$emprendedor->id)}}
                <div class="modal-body">
                    <span class="message-error">{{$errors->first('emprendedor')}}</span>
                    <fieldset>
                        <div class="col-md-6 espacio_abajo">
                            {{Form::label('empresa', '* Empresa', array('class' => 'label'))}}
                            <label class="select">
                                @if(count($empresas_listado)>0)
                                    {{Form::select('empresa', $empresas_listado)}}
                                @else
                                    {{Form::select('empresa', array(null=>$emprendedor->name." ".$emprendedor->apellidos))}}
                                @endif
                            </label>
                            <span class="message-error">{{$errors->first('empresa')}}</span>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            @if(count($socios_listado)>0)
                                {{Form::checkbox('emprendedor', 'yes', 'yes',array('id'=>'emp_event','onchange'=>'evento(3);'))}}
                                Documento del emprendedor
                            @else
                                {{Form::checkbox('emprendedor', 'yes', 'yes', array('disabled'=>''))}} Documento del
                                emprendedor
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
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <!--Scripts-->
    @parent
    <script type="text/javascript" src="{{ URL::asset('Orb/js/bootstrap-filestyle.js') }}"></script>
    <!--Calendario-->
    {{ HTML::script('Orb/bower_components/underscore/underscore-min.js') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/calendar.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}
    <!--/Scripts-->
    <script type="text/javascript">
        //Configuracion del Calendario
        (function ($) {
            //creamos la fecha actual
            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            //establecemos los valores del calendario
            var options = {
                events_source: '{{url('calendario/obtener/$emprendedor->user_id')}}',
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
                  width: '88%',
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

        //Configuracion de los input con calendario
        $(function () {
            $('#fecha').datetimepicker({
                language: 'es',
                minDate: @if(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==0)
                        '{{date ( 'm/j/Y' , strtotime ('+3 day', strtotime(date('j-m-Y'))))}}',
                @elseif(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==6)
                '{{date ( 'm/j/Y' , strtotime ('+4 day', strtotime(date('j-m-Y'))))}}',
                @else
                  '{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
                @endif
              maxDate: @if(date("w", strtotime ('+30 day', strtotime(date('j-m-Y'))))==0)
                        '{{date ( 'm/j/Y' , strtotime ('+31 day', strtotime(date('j-m-Y'))))}}',
                @elseif(date("w", strtotime ('+30 day', strtotime(date('j-m-Y'))))==6)
                '{{date ( 'm/j/Y' , strtotime ('+32 day', strtotime(date('j-m-Y'))))}}',
                @else
                  '{{date ( 'm/j/Y' , strtotime ('+30 day', strtotime(date('j-m-Y'))))}}',
                @endif
              pickTime: false,
                defaultDate: @if(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==0)
                        '{{date ( 'm/j/Y' , strtotime ('+3 day', strtotime(date('j-m-Y'))))}}',
                @elseif(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==6)
                '{{date ( 'm/j/Y' , strtotime ('+4 day', strtotime(date('j-m-Y'))))}}',
                @else
                  '{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
                @endif
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
                daysOfWeekDisabled: [0, 6]
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

            $("#from").on("dp.change", function (e) {
                $('#to').data("DateTimePicker").setMinDate(e.date);
                if ($("#from").val() > $('#to').val()) {
                    $('#to').val($("#from").val())
                    $('#from').data("DateTimePicker").setMaxDate(e.date);
                }
            });

            $("#to").on("dp.change", function (e) {
                $('#from').data("DateTimePicker").setMaxDate(e.date);
            });
        });

        //Cambiar el horario segun el asesor
        function cambiar() {
            consultor = $('#objetivo').val();
            fecha = $('#fecha').val();
            from = $('#from').val();
            to = $('#to').val();
            $.ajax({
                url: '/calendario/horario/$emprendedor->user_id}',
                type: 'POST',
                data: {consultor: consultor, fecha: fecha, from: from, to: to},
                dataType: 'JSON',
                error: function () {
                    $("#hora").html('Ha ocurrido un error...');
                },
                success: function (respuesta) {
                    if (respuesta) {
                        var html = '';
                        for (i = 0; i < respuesta.horarios.length; i++) {
                            html += '<option value="' + respuesta.horarios[i].id + '">' + respuesta.horarios[i].horario + '</option>';
                        }
                        $("#horario").html(html);
                        if (respuesta.warning == "Hay eventos") {
                            $("#cita").html('<button onClick="return confirm(\'Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?\');" class="btn btn-primary" id="cita_boton">Crear</button>');
                        } else {
                            $("#cita").html('<button class="btn btn-primary" id="cita_boton">Crear</button>');
                        }
                        if (respuesta.warning_evento == "Hay eventos") {
                            $("#eventos").html('<button onClick="return confirm(\'Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?\');" class="btn btn-primary" id="evento_boton">Crear</button>');
                        } else {
                            $("#eventos").html('<button class="btn btn-primary" id="evento_boton">Crear</button>');
                        }
                    }
                }
            });
        }

        //Configuraciones para subir documentos
        function evento(i) {
            switch (i) {
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

        //Configuraciones del chat
        function enviarMensaje() {
            $("#cargar").html('Cargando...');
        }

        function resultadoOk() {
            $("#text_mensaje").val('');
            $('#archivo').val(null);
            $('#imagen').val(null);
            $("#cargar").html('');
            $(".badge").text('');
            $("#div_mensaje").html('');
            $(".nano").nanoScroller({scroll: 'bottom'});
        }

        function resultadoErroneo(mensaje) {
            $("#div_mensaje").html(mensaje);
            $("#cargar").html('');
        }
    </script>
@stop