@section('titulo')
    Incubamas | Chat
@stop


@section('mensajes')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Chat</li>
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
    <script type="text/javascript">
        $(window).load(function ()
        {
            $(".nano").nanoScroller({scroll: 'bottom'});
        });
    </script>
@stop

@section('titulo-seccion')
    <h1>Mensajes
        <small> Conversaciones</small>
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
    <div class="powerwidget blue" id="chat" data-widget-editbutton="false">
        <div class="chat-container">
            <div class="top-buttons clearfix">
                <h2 class="margin-0px pull-left">&nbsp;&nbsp;Mensajes</h2>
                <span id="titulo_chat" class="badge"></span>
                <div class="btn-group btn-group-sm pull-right">
                    @if(\Auth::user()->type_id==1)
                        {{HTML::link('mensajes/crear-incubito/','Crear una Conversacion', ['class'=>'btn btn-primary', 'style'=>'color:#FFF'])}}
                    @else
                        {{HTML::link('mensajes/crear/','Crear una Conversacion', ['class'=>'btn btn-primary', 'style'=>'color:#FFF'])}}
                    @endif
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
                                                    <a href="{{url('mensajes/index/'.$chat->chat_id)}}">
                                                        <span class="chat-name">{{$chat->chat->nombre}}</span>
                                                        <span class="user-img">
                                                            {{ HTML::image('Orb/images/chats/'.$chat->chat->foto, $chat->chat->nombre)}}
                                                        </span>
                                                        <span class="label label-success" style="font-size: 0.6em;">Grupal</span>
                                                        @if($chat->chat->ultimo_mensaje!=null)
                                                            @if($chat->ultimo_visto==null)
                                                                <span class="badge">Nuevos</span>
                                                            @else
                                                                @if($chat->ultimo_mensaje > $chat->ultimo_visto)
                                                                    <span class="badge">Nuevos</span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </a>
                                                @endif
                                            @else
                                                @if($publico<>$chat->chat_id)
                                                    <?php $publico=$chat->chat_id;?>
                                                    <a href="{{url('mensajes/index/'.$chat->chat_id)}}">
                                                        <span class="chat-name">{{$chat->chat->nombre}}</span>
                                                        <span class="user-img">
                                                            {{ HTML::image('Orb/images/chats/'.$chat->chat->foto, $chat->chat->nombre) }}
                                                        </span>
                                                        <span class="label label-success" style="font-size: 0.6em;">Publico</span>
                                                        @if($chat->chat->ultimo_mensaje!=null)
                                                            @if(Auth::user()->visto_mensajes==null)
                                                                <span class="badge">Nuevos</span>
                                                            @else
                                                                @if($chat->chat->ultimo_mensaje > Auth::user()->visto_mensajes)
                                                                    <span class="badge">Nuevos</span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            <a href="{{url('mensajes/index/'.$chat->chat_id)}}">
                                                <span class="chat-name">{{$chat->usuario->nombre}} {{$chat->usuario->apellidos}}</span>
                                                <span class="user-img">
                                                    {{ HTML::image('Orb/images/emprendedores/'.$chat->usuario->foto, $chat->usuario->nombre.' '.$chat->usuario->apellidos) }}
                                                </span>
                                                <span class="label label-success" style="font-size: 0.6em;">{{$chat->usuario->puesto}}</span>
                                                @if($chat->chat->ultimo_mensaje!=null && $chat->ultimo_visto!=null)
                                                    @if($chat->ultimo_mensaje > $chat->ultimo_visto)
                                                        <span class="badge">Nuevos</span>
                                                    @endif
                                                @endif
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
                                                                @if($mensaje->imagen!=null)
                                                                    <span class="borde"><a target="_blank" href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->imagen)}}">{{ HTML::image('Orb/images/adjuntos/'.$mensaje->imagen, $mensaje->imagen, ['style'=> "height: 100px;"]) }}</a></span>
                                                                @endif
                                                                @if($mensaje->archivo!=null)
                                                                    <span class="borde"><a target="_blank" href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->archivo)}}">{{$mensaje->nombre_archivo}}</a></span>
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
                                                {{Form::file('imagen', ['id'=>'imagen', 'accept'=>"image/*"])}}
                                            @else
                                                {{Form::file('imagen', ['id'=>'imagen', 'accept'=>"image/*", 'disabled'=>"true"])}}
                                            @endif
                                        @else
                                            {{Form::file('imagen', ['id'=>'imagen', 'accept'=>"image/*", 'disabled'=>"true"])}}
                                        @endif
                                        <br/><br/><span class="message-error" style="font-weight: bold">{{$errors->first('imagen')}}</span>
                                        <script>
                                            $("#imagen").fileinput({
                                                previewFileType: "image",
                                                browseClass: "btn btn-success",
                                                browseLabel: "",
                                                browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                                                showCaption: false,
                                                removeClass: "btn btn-danger",
                                                removeLabel: "Borrar",
                                                removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                                                showUpload: false
                                            });
                                        </script>
                                    </span>
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
@stop