@section('titulo')
    Incubamas | Chat
@stop

@section('css')
    @parent
    {{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
    {{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
    {{ HTML::style('Orb/css/vendors/x-editable/select2.css') }}
    {{ HTML::style('Orb/css/vendors/x-editable/bootstrap-editable.css') }}
    <script type="text/javascript">
        $(window).load(function ()
        {
            <?php $texto=""?>

            @if(count($asesores) > 0)

            @foreach($asesores as $asesor)
            <?php $texto.=$asesor->texto;?>
            @endforeach

            $('#asesores').editable({
                        inputclass: 'input-large',
                        select2: {
                            tags: [{{$texto}}],
                            tokenSeparators: [",", " "]
                        }
                    });

            @if(Auth::user()->type_id!=1)

            <?php $texto="{"?>

            @if(count($emprendedores) > 0)

            @foreach($emprendedores as $emprendedor)
            <?php $texto.=$emprendedor->texto;?>
            @endforeach

            <?php $texto.="}"?>

                    @endif

                    var countries = [];

            $.each({{$texto}}, function (k, v) {
                countries.push({id: k, text: v});
            });

            @endif

            $('#emprendedores').editable({
                        source: countries,
                        select2: {
                            width: 200,
                            placeholder: 'Selecciona',
                            allowClear: true
                        }
                    });

            $('#emprendedores').hide();

            @endif

            $(".nano").nanoScroller({scroll: 'bottom'});
        });

        //Metodos para commit
        (function ($)
        {
            //var root = 'http://incubamas.com/';
            var root = 'http://incuba.local/';
            var timestamp = 0;
            var url = '{{url('chat/backend')}}';
            var noerror = true;
            var ajax;

            function handleResponse(response)
            {
                if (response['msg'] != 0)
                {
                    var html = '';
                    if (response['msg'] != 1)
                    {
                        var nombre ='';
                        var foto='';
                        if (response['msg'][0].asesor == null)
                        {
                            if (response['msg'][0].emprendedor == null)
                            {
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

                        if (response['msg'][0].user_id != {{Auth::user()->id}})
                        {
                            html += '<li class="left clearfix">' +
                            '<span class="user-img pull-left">' +
                            '<img src="'+root + foto + '" alt="Foto" class="img-circle" />' +
                            '</span>' +
                            '<div class="chat-body clearfix">' +
                            '<div class="header">' +
                            '<span class="name">' + nombre + '</span>' +
                            '<span class="badge"><i class="fa fa-clock-o"></i>' + response['msg'][0].created_at + '</span>' +
                            '</div>' +
                            '<p>' + response['msg'][0].cuerpo + '</p>';
                            if (response['msg'][0].archivo != null)
                                html += '<span class="borde"><a target="_blank" href="'+root+'Orb/images/adjuntos/' + response['msg'][0].archivo + '">' + response['msg'][0].original + '</a></span>';
                            html += '</div>' +
                            '</li>';
                        } else {
                            html += '<li class="right clearfix">' +
                            '<span class="user-img pull-right">' +
                            '<img src="'+root + foto + '" alt="Foto" class="img-circle" />' +
                            '</span>' +
                            '<div class="chat-body clearfix">' +
                            '<div class="header">' +
                            '<span class="name">' + nombre + '</span>' +
                            '<span class="badge"><i class="fa fa-clock-o"></i>' + response['msg'][0].created_at + '</span>' +
                            '</div>' +
                            '<p>' + response['msg'][0].cuerpo + '</p>';
                            if (response['msg'][0].archivo != null)
                                html += '<span class="borde"><a target="_blank" href="'+root+'Orb/images/adjuntos/' + response['msg'][0].archivo + '">' + response['msg'][0].original + '</a></span>';
                            html += '</div>' +
                            '</li>';
                        }
                        $("#div_chat").append(html);
                    }else{
                        var user = response['chat'][0].user_id;
                        if(response['chat'][0].user_id==null)
                            user = 0;
                        html += '<li>'+
                                    '<a href="'+root+'chat/index/'+response['chat'][0].chat+'/'+user+'/'+response['chat'][0].grupo+'/'+response['chat'][0].nombre+'">'+
                                        '<span class="chat-name">'+response['chat'][0].nombre+'<span>'+
                                        '<span class="user-img"><img src="'+root+response['chat'][0].foto+'" alt="User"/></span><br/>'+
                                        '<span class="label label-success" style="font-size: 0.6em;">';
                        if(response['chat'][0].puesto!="")
                            html +=         response['chat'][0].puesto;
                        else
                            html +=         'Emprendedor';
                        html +=         '</span>';
                        html +=         '<span class="badge" >Nuevos</span>';
                        html +=     '</a>';
                        html += '</li>';
                        $("#ul_chats").append(html);
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

            function doRequest(request) {
                $.ajax(url, {
                    type: 'get',
                    data: {'msg': request}
                });
            }

            $(document).ready(function () {
                connect();
            });

        })(jQuery);
    </script>
@stop

@section('chat')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Chat</li>
@stop

@section('titulo-seccion')
    <h1>Chat
        <small> Listado</small>
    </h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <script>
            alert("¡Por favor, revise los datos del formulario!");
        </script>
    @endif
    <div class="powerwidget blue" id="chat" data-widget-editbutton="false">
        <div class="chat-container">
            <div class="top-buttons clearfix">
                <h2 class="margin-0px pull-left">&nbsp;&nbsp;Chat</h2>
                <span id="titulo_chat" class="badge">{{$active_nombre}}</span>
                <div class="btn-group btn-group-sm pull-right">
                    <a href="#myModal1" role="button" data-target="#myModal1" class="btn btn-default"
                       data-toggle="modal">
                        <i class="fa fa-comment"></i>
                        <span class="hidden-xs">Enviar nuevo mensaje</span>
                    </a>
                </div>
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

                                        <a href="{{url('chat/index/'.$var_chat.'/'.$var_user.'/'.$chat->grupo.'/'.$chat->nombre)}}">
                                            <span class="chat-name">{{$chat->nombre}}<span>
                                                <span class="user-img">
                                                    <img src="{{URL::asset($chat->foto)}}" alt="User"/>
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
                    <div class="chat-content"><!-- this is the wrapper for the content -->
                        <div class="nano"><!-- this is the nanoscroller -->
                            <div class="nano-content" style="left : 20px;">
                                <div class="chat-content-inner">
                                    <div class="clearfix">
                                        <div class="chat-messages chat-messages-with-sidebar" id="div_chat">
                                            <ul>
                                                @if(count($mensajes) > 0)
                                                    @foreach($mensajes as $mensaje)

                                                        @if ($mensaje->asesor==null)
                                                            @if($mensaje->emprendedor==null)
                                                                <?php $nombre = 'Incubito';
                                                                $foto = 'Orb/images/emprendedores/generic-emprendedor.png'; ?>
                                                            @else
                                                                <?php $nombre = $mensaje->emprendedor;
                                                                $foto = 'Orb/images/emprendedores/' . $mensaje->emprendedor_foto; ?>
                                                            @endif
                                                        @else
                                                            <?php $nombre = $mensaje->asesor;
                                                            $foto = 'accio/images/equipo/' . $mensaje->asesor_foto; ?>
                                                        @endif

                                                        @if ($mensaje->user_id != Auth::user()->id)
                                                            <li class="left clearfix">
                                                                <span class="user-img pull-left">
                                                        @else
                                                            <li class="right clearfix">
                                                                <span class="user-img pull-right">
                                                        @endif
                                                                    <img src="{{URL::asset($foto)}}" alt="Foto" class="img-circle"/>
                                                                </span>
                                                                <div class="chat-body clearfix">
                                                                    <div class="header">
                                                                        <span class="name">{{$nombre}}</span>
                                                                        <span class="badge"><i class="fa fa-clock-o"></i>{{$mensaje->envio}}</span>
                                                                    </div>
                                                                    <p>{{$mensaje->cuerpo}}</p>
                                                                    @if($mensaje->archivo!=null)
                                                                        <span class="borde"><a target="_blank" href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->archivo)}}">{{$mensaje->original}}</a></span>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                    @endforeach
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
                <!---->
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
                                    <input type="file" id="imagen" name="imagen" class="filestyle" data-input="false" data-iconName="glyphicon-camera" data-buttonText="">
                                </span>
                                <span style="display: inline-block;">
                                    <input type="file" id="archivo" name="archivo" class="filestyle" data-input="false" data-iconName="glyphicon-paperclip" data-buttonText="">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            @if($active_group==1 && Auth::user()->type_id<>1)
                                <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" disabled onclick="enviarMensaje();"/>
                            @else
                                <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" onclick="enviarMensaje();"/>
                            @endif
                        </div>
                    </div>
                {{Form::close()}}
            </div>
            <iframe width="1" height="1" frameborder="0" name="contenedor_subir_archivo" style="display: none"></iframe>
            <!-- /Chat-form -->
        </div>
        <div id="cargar" style="color: rgb(165, 165, 165); font-weight: bold;"></div>
        <div id="div_mensaje" style="color: rgb(223, 77, 77); font-weight: 900; text-align: center;"></div>
        <!-- End Widget -->
    </div>
    </div>
    <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Mensaje</h4>
                </div>
                <div class="modal-body" id="editarServicio">
                    {{Form::open(array('url'=>'chat/nuevomensaje', 'class'=>'orb-form','method' => 'post', 'id'=>'nuevo_mensaje') )}}
                    <!--, 'target'=>"contenedor_subir_archivo"-->
                    {{Form::hidden('destino','',array('id'=>'destino'))}}
                    {{Form::hidden('tipo_usuario','',array('id'=>'tipo_usuario'))}}
                    <fieldset>
                        <div class="col-md-1 espacio_abajo">
                            {{Form::label('para', 'Para:', array('class' => 'label'))}}
                        </div>
                        <div class="col-md-10 espacio_abajo">
                            <table id="user" class="table table-bordered table-striped">
                                <tbody>
                                @if(Auth::user()->type_id==2)
                                    <tr>
                                        <td width="35%">{{Form::radio('name', 'asesor', true, array('onchange'=>'para()', 'id'=>'radio_asesor'))}} Asesores</td>
                                        <td width="65%"><a href="#" id="asesores" data-type="select2" data-pk="1" data-title="Asesor">Selecciona</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{Form::radio('name', 'emprendedor', false, array('onchange'=>'para()', 'id'=>'radio_emprendedor'))}} Emprendedores</td>
                                        <td><a href="#" id="emprendedores" data-type="select2" data-pk="1" data-value="BS" data-title="Emprendedor"></a></td>
                                    </tr>
                                @elseif(Auth::user()->type_id==1)
                                    <tr>
                                        <td width="35%">{{Form::radio('name', 'asesor', true, array('onchange'=>'para()', 'id'=>'radio_asesor'))}} Grupo</td>
                                        <td width="65%"><a href="#" id="asesores" data-type="select2" data-pk="1" data-title="Asesor">Selecciona</a></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if(Session::get('para'))
                                <span class="message-error">{{Session::get('para')}}</span>
                            @endif
                        </div>
                        @if(Auth::user()->type_id==1)
                            <div class="col-md-1 espacio_abajo">
                                {{Form::label('mensaje', 'Asunto:', array('class' => 'label'))}}
                            </div>
                            <div class="col-md-10 espacio_abajo">
                                <label class="input">
                                    {{Form::text('asunto','',array('class'=>"form-control",'autocomplete'=>"off"))}}
                                </label>
                                <span class="message-error">{{$errors->first('asunto')}}</span>
                            </div>
                        @endif
                        <div class="col-md-1 espacio_abajo">
                            {{Form::label('mensaje', 'Mensaje:', array('class' => 'label'))}}
                        </div>
                        <div class="col-md-10 espacio_abajo">
                            {{Form::text('mensaje','',array('class'=>"form-control", 'autocomplete'=>"off"))}}
                            <span class="message-error">{{$errors->first('mensaje')}}</span>
                        </div>
                        <div class="col-md-11 espacio_abajo" style="text-align: left;">
                            * Los campos son obligatorios
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="servicio_boton" onclick="nuevoMensaje();">Continuar</button>
                    {{Form::close()}}
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script>

        function enviarMensaje()
        {
            $("#cargar").html('Cargando...');
            $("#mensaje_form").submit();
        }

        function resultadoOk()
        {
            $("#text_mensaje").val('');
            $('#archivo').val(null);
            $('#imagen').val(null);
            $("#cargar").html('');
            $(".badge").text('');
            $("#div_mensaje").html('');
            $(".nano").nanoScroller({scroll: 'bottom'});
        }

        function resultadoErroneo(mensaje)
        {
            $("#div_mensaje").html(mensaje);
            $("#cargar").html('');
        }

        function para()
        {
            if ({{Auth::user()->type_id}}!=1)
            {
                if ($("#radio_asesor").is(':checked')) {
                    $('#emprendedores').hide();
                    $('#asesores').show();
                } else {
                    $('#emprendedores').show();
                    $('#asesores').hide();
                }
            }
        }

        function nuevoMensaje()
        {
            if ($("#radio_asesor").is(':checked')) {
                $('#destino').val($('#asesores').text());
                $('#tipo_usuario').val("Asesor");
            } else {
                $('#destino').val($('#emprendedores').text());
                $('#tipo_usuario').val("Emprendedor");
            }
        }

    </script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/bootstrap-filestyle.js') }}"></script>
    <!--X-Editable-->
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/bootstrap-editable.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo-mock.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/select2.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/jquery.mockjax.js') }}"></script>
@stop