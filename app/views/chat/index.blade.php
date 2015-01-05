@section('titulo')
    IncubaM&aacute;s | Chat
@stop

@section('css')
  @parent
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/select2.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/bootstrap-editable.css') }}" rel="stylesheet" type="text/css">
  <script type="text/javascript">
    $(window).load(function(){
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
        $.each({{$texto}}, function(k, v) {
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
      $(".nano").nanoScroller({ scroll: 'bottom' });
    });
    (function($){
      function handleResponse(response){
        var html = '';
        var nombre;
        var foto;
        if (response.msg[0].asesor==null){
          if(response.msg[0].emprendedor==null){
            nombre = 'Incubito';
            foto = 'Orb/images/emprendedores/generic-emprendedor.png';
          }else{
            nombre = response.msg[0].emprendedor;
            foto = 'Orb/images/emprendedores/'+response.msg[0].emprendedor_foto;
          }
        }else{
          nombre = response.msg[0].asesor;
          foto = 'accio/images/equipo/'+response.msg[0].asesor_foto;
        }
        if (response.msg[0].user_id != {{Auth::user()->id}}){ 
          html += '<li class="left clearfix">'+
            '<span class="user-img pull-left">'+
              '<img src="http://incubamas.com/'+foto+'" alt="Foto" class="img-circle" />'+
            '</span>'+
            '<div class="chat-body clearfix">'+
              '<div class="header">'+
                '<span class="name">'+nombre+'</span>'+
                '<span class="badge"><i class="fa fa-clock-o"></i>'+response.msg[0].created_at+'</span>'+
              '</div>'+
              '<p>'+response.msg[0].cuerpo+'</p>';
              if(response.msg[0].archivo!=null)
                html += '<span class="borde"><a target="_blank" href="http://incubamas.com/Orb/images/adjuntos/'+response.msg[0].archivo+'">'+response.msg[0].original+'</a></span>';
            html += '</div>'+
          '</li>';
        } else{
          html += '<li class="right clearfix">'+
            '<span class="user-img pull-right">'+
              '<img src="http://incubamas.com/'+foto+'" alt="Foto" class="img-circle" />'+
            '</span>'+
            '<div class="chat-body clearfix">'+
              '<div class="header">'+
                '<span class="name">'+nombre+'</span>'+
                '<span class="badge"><i class="fa fa-clock-o"></i>'+response.msg[0].created_at+'</span>'+
              '</div>'+
              '<p>'+response.msg[0].cuerpo+'</p>';
              if(response.msg[0].archivo!=null)
                html += '<span class="borde"><a target="_blank" href="http://incubamas.com/Orb/images/adjuntos/'+response.msg[0].archivo+'">'+response.msg[0].original+'</a></span>';
            html += '</div>'+
          '</li>';
        }
        $('#div_chat').append(html);
        $(".nano").nanoScroller({ scroll: 'bottom' });
      }
      
      var timestamp = 0;
      var url = '{{url('chat/backend/1')}}';
      var noerror = true;
      var ajax;
      
      function connect() {
        ajax = $.ajax(url, {
          type: 'get',
          data: { 'timestamp' : timestamp },
          success: function(transport) {
          eval('var response = '+transport);
          timestamp = response['timestamp'];
          handleResponse(response);
          noerror = true;
          },
          complete: function(transport) {
            (!noerror) && setTimeout(function(){ connect() }, 5000) || connect();
            noerror = false;
          }
        });
      }
      
      function doRequest(request) {
        $.ajax(url, {
          type: 'get',
          data: { 'msg' : request }
        });
      }
      
      $(document).ready(function(){
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
  <h1>Chat <small> Listado</small></h1>
@stop

@section('contenido')
    <div class="powerwidget blue" id="chat" data-widget-editbutton="false">
      <div class="chat-container">
        <div class="top-buttons clearfix">
          <h2 class="margin-0px pull-left">&nbsp;&nbsp;Chat</h2>
          <span id="titulo_chat" class="badge">{{$active_nombre}}</span>
          @if(Auth::user()->type_id<>3)
            <div class="btn-group btn-group-sm pull-right">
              <a href="#myModal1" role="button" data-target="#myModal1" class="btn btn-default" data-toggle="modal">
                <i class="fa fa-comment"></i>
                <span class="hidden-xs">Enviar nuevo mensaje</span>
              </a>
            </div>
          @endif
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
                <?php $enc_chat = false;
                      $i=0;?>
                @if(count($chats) > 0)
                  @foreach($chats as $chat)
                    <?php $i++;?>
                    @if($chat->chat<>"")
                      <?php $var_chat = $chat->chat;?>
                    @else
                      <?php $var_chat = 0;?>
                    @endif
                    @if($chat->user_id<>"")
                      <?php $var_user = $chat->user_id;?>
                    @else
                      <?php $var_user = 0;?>
                    @endif
                    <li>
                      <a id="chat{{$i}}" href="#" onclick="cargarChat({{$var_chat}},{{$var_user}},{{$chat->grupo}},{{"'chat".$i."'"}}, {{"'".$chat->nombre."'"}})">
                        <span class="chat-name">{{$chat->nombre}}<span>
                        <span class="user-img">
                            <img src="{{URL::asset($chat->foto)}}" alt="User"/>
                        </span><br/>
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
                <div class="nano-content" style="left : 20px;" >
                  <div class="chat-content-inner"><!-- extra div for emulating position:fixed of the menu --> 
                    <!-- Top Navigation -->
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
                                        $foto = 'Orb/images/emprendedores/'.$mensaje->emprendedor_foto; ?>
                                @endif
                              @else
                                <?php $nombre = $mensaje->asesor;
                                      $foto = 'accio/images/equipo/'.$mensaje->asesor_foto; ?>
                              @endif
                              @if ($mensaje->user_id != Auth::user()->id) 
                                <li class="left clearfix">
                                  <span class="user-img pull-left">
                                    <img src="{{URL::asset($foto)}}" alt="Foto" class="img-circle" />
                                  </span>
                                  <div class="chat-body clearfix">
                                    <div class="header">
                                      <span class="name">{{$nombre}}</span>
                                      <span class="badge"><i class="fa fa-clock-o"></i>{{$mensaje->envio}}</span>
                                    </div>
                                    <p>{{$mensaje->cuerpo}}</p>
                                    @if($mensaje->archivo!=null)
                                      <span class="borde"><a target="_blank" href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->archivo)}}">{{$mensaje->original}}</a></span> <!--Buttons-->
                                    @endif
                                  </div>
                                </li>
                              @else
                                <li class="right clearfix">
                                  <span class="user-img pull-right">
                                    <img src="{{URL::asset($foto)}}" alt="Foto" class="img-circle" />
                                  </span>
                                  <div class="chat-body clearfix">
                                    <div class="header">
                                      <span class="name">{{$nombre}}</span>
                                      <span class="badge"><i class="fa fa-clock-o"></i>{{$mensaje->envio}}</span>
                                    </div>
                                    <p>{{$mensaje->cuerpo}}</p>
                                    @if($mensaje->archivo!=null)
                                      <span class="borde"><a target="_blank" href="{{URL::asset('Orb/images/adjuntos/'.$mensaje->archivo)}}">{{$mensaje->archivo}}</a></span> <!--Buttons-->
                                    @endif
                                  </div>
                                </li>
                              @endif
                            @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                  <!-- /chat-content-inner --> 
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
        {{Form::open(array('url'=>'chat/enviarmensaje', 'class'=>'orb-form','method' => 'post', 'id'=>'mensaje_form', 'enctype'=>'multipart/form-data',  'target'=>"contenedor_subir_archivo"))}}
          @if(count($chats) > 0)
            {{Form::hidden('actual_chat',1,array('id'=>'actual_chat'))}}
            {{Form::hidden('user_id',$active_user,array('id'=>'user_id'))}}
            {{Form::hidden('chat_id',$active_chat, array('id'=>'chat_id'))}}
            {{Form::hidden('group_id',$active_group, array('id'=>'group_id'))}}
            {{Form::hidden('active_nombre',$active_nombre, array('id'=>'active_nombre'))}}
            <div class="row">
              <div class="col-md-11">
                @if($active_group==1 && Auth::user()->type_id<>1)
                  {{Form::text('mensaje','',array('id'=>'text_mensaje', 'placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off", 'disabled'))}}
                @else
                  {{Form::text('mensaje','',array('id'=>'text_mensaje', 'placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off"))}}
                @endif
                <span id="div_mensaje" class="message-error"></span>
              </div>
              <div class="col-md-7 col-sm-8 col-xs-8">
                <div class="btn-group">
                  <span style="display: inline-block;"><input type="file" id="imagen" name="imagen" class="filestyle" data-input="false" data-iconName="glyphicon-camera" data-buttonText=""></span>
                  <span style="display: inline-block;"><input type="file" id="archivo" name="archivo" class="filestyle" data-input="false" data-iconName="glyphicon-paperclip" data-buttonText=""></span>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                  @if($active_group==1 && Auth::user()->type_id<>1)
                    <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" onclick="enviarMensaje();"  disabled/>
                  @else
                    <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" onclick="enviarMensaje();" />
                  @endif
              </div>
            </div>
          @else
            {{Form::hidden('actual_chat','',array('id'=>'actual_chat'))}}
            {{Form::hidden('user_id','',array('id'=>'user_id'))}}
            {{Form::hidden('chat_id','', array('id'=>'chat_id'))}}
            {{Form::hidden('group_id','', array('id'=>'group_id'))}}
            {{Form::hidden('active_nombre','', array('id'=>'active_nombre'))}}
            <div class="row">
              <div class="col-md-11">
                {{Form::text('mensaje','',array('id'=>'text_mensaje', 'placeholder'=>'Escribe tu mensaje...', 'class'=>'form-control margin-bottom','rows'=>'2', 'autocomplete'=>"off", 'disabled'))}}
                <span id="div_mensaje" class="message-error"></span>
              </div>
              <div class="col-md-7 col-sm-8 col-xs-8">
                <div class="btn-group">
                  <span style="display: inline-block;"><input type="file" id="imagen" name="imagen" class="filestyle" data-input="false" data-iconName="glyphicon-camera" data-buttonText=""></span>
                  <span style="display: inline-block;"><input type="file" id="archivo" name="archivo" class="filestyle" data-input="false" data-iconName="glyphicon-paperclip" data-buttonText=""></span>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                  <input type="submit" value="Enviar" id="boton_enviar" class="btn btn-info pull-right" onclick="enviarMensaje();"  disabled/>
              </div>
            </div>
          @endif
          <iframe width="1" height="1" frameborder="0" name="contenedor_subir_archivo" style="display: none"></iframe>
        {{Form::close()}}
      </div>
      <div id="cargar"></div>
      <!-- /Chat-form --> 
    </div>
  </div>
  <!-- End Widget -->
    <script>
    function pintahoradinamic() {
      @if(Auth::user()->type_id!=3)
        if ({{count($chats)}}<8) {
          $('#chats_div').css('right','0px')
        }
      @else
        $('#chats_div').css('right','-10px')
      @endif
      chat = $('#chat_id').val();
      user = $('#user_id').val();
      grupo = $('#group_id').val();
      nuevas_conversaciones();
      cargarChat(chat, user, grupo);
    }
    
    function nuevas_conversaciones() {
      $.ajax({
        url: '/chat/buscachat',
        type: 'POST',
        dataType: 'JSON',
        error: function() {
          $("#ul_chats").html('Ha ocurrido un error...');
        },
        success: function(respuesta) {
          if (respuesta) {
            var html = '';
            var var_chat = 0;
            var var_user = 0;
            for (i = 0; i < respuesta.length; i++) {
              if(respuesta[i].chat!="")
                var_chat = respuesta[i].chat
              if(respuesta[i].user_id!="")
                var_user = respuesta[i].user_id;
              html += '<li>'+
                        '<a id="chat'+i+'" href="#" onclick="cargarChat('+var_chat+','+
                        var_user+','+respuesta[i].grupo+',\'chat'+i+'\','+ '\''+respuesta[i].nombre+'\')">'+
                          '<span class="chat-name">'+respuesta[i].nombre+'<span>'+
                          '<span class="user-img">'+
                            '<img src="http://incubamas.com/'+respuesta[i].foto+'" alt="User"/>'+
                          '</span><br/>'+
                          '<span class="label label-success" style="font-size: 0.6em;">';
                            if(respuesta[i].puesto!="")
                              html += respuesta[i].puesto;
                            else
                              html += 'Emprendedor';
              html +=     '</span>';
                          if(respuesta[i].ultimo_mensaje != null && respuesta[i].ultimo_visto != null)
                            if((Date.parse(respuesta[i].ultimo_mensaje)) > (Date.parse(respuesta[i].ultimo_visto)))
                              html += '<span class="badge" id="nuevo'+var_chat+'">Nuevos</span>';
              html +=    '</a>'+
                      '</li>';
            }
            $("#ul_chats").html(html);
          }
          else {
            $("#ul_chats").html('');
          }
          $(".nano").nanoScroller();
        }
      });
    }
    
    function cargarChat(chat, user, grupo, id, chat_name) {
      $('#actual_chat').val(id);
      $('#chat_id').val(chat);
      $('#user_id').val(user);
      $('#group_id').val(grupo);
      $('#active_nombre').val(chat_name);
      if(chat_name !="")
        $('#titulo_chat').text(chat_name);
      else
        $('#titulo_chat').text('');
      $(".nano").nanoScroller();
      if (chat!=0) {
        if (!(grupo==1 && {{Auth::user()->type_id}}!=1)) {
          $('#text_mensaje').prop( "disabled", false);
          $('#boton_enviar').prop( "disabled", false);
        }else{
          $('#text_mensaje').prop( "disabled", true);
          $('#boton_enviar').prop( "disabled", true);
        }
      }else{
        $('#text_mensaje').prop( "disabled", false);
        $('#boton_enviar').prop( "disabled", false);
      }
      $.ajax({
        url: '/chat/buscar',
        type: 'POST',
        data: {chat_id: chat},
        dataType: 'JSON',
        error: function() {
          $("#div_char").html('Ha ocurrido un error...');
        },
        success: function(respuesta) {
          if (respuesta) {
            var html = '';
            var nombre;
            var foto;
            for (i = 0; i < respuesta.length; i++) {
              if (respuesta[i].asesor==null){
                if(respuesta[i].emprendedor==null){
                  nombre = 'Incubito';
                  foto = 'Orb/images/emprendedores/generic-emprendedor.png';
                }else{
                  nombre = respuesta[i].emprendedor;
                  foto = 'Orb/images/emprendedores/'+respuesta[i].emprendedor_foto;
                }
              }else{
                nombre = respuesta[i].asesor;
                foto = 'accio/images/equipo/'+respuesta[i].asesor_foto;
              }
              if (respuesta[i].user_id != {{Auth::user()->id}}){ 
                html += '<li class="left clearfix">'+
                  '<span class="user-img pull-left">'+
                    '<img src="http://incubamas.com/'+foto+'" alt="Foto" class="img-circle" />'+
                  '</span>'+
                  '<div class="chat-body clearfix">'+
                    '<div class="header">'+
                      '<span class="name">'+nombre+'</span>'+
                      '<span class="badge"><i class="fa fa-clock-o"></i>'+respuesta[i].created_at+'</span>'+
                    '</div>'+
                    '<p>'+respuesta[i].cuerpo+'</p>';
                    if(respuesta[i].archivo!=null)
                      html += '<span class="borde"><a target="_blank" href="http://incubamas.com/Orb/images/adjuntos/'+respuesta[i].archivo+'">'+respuesta[i].original+'</a></span>';
                  html += '</div>'+
                '</li>';
              } else{
                html += '<li class="right clearfix">'+
                  '<span class="user-img pull-right">'+
                    '<img src="http://incubamas.com/'+foto+'" alt="Foto" class="img-circle" />'+
                  '</span>'+
                  '<div class="chat-body clearfix">'+
                    '<div class="header">'+
                      '<span class="name">'+nombre+'</span>'+
                      '<span class="badge"><i class="fa fa-clock-o"></i>'+respuesta[i].created_at+'</span>'+
                    '</div>'+
                    '<p>'+respuesta[i].cuerpo+'</p>';
                    if(respuesta[i].archivo!=null)
                      html += '<span class="borde"><a target="_blank" href="http://incubamas.com/Orb/images/adjuntos/'+respuesta[i].archivo+'">'+respuesta[i].original+'</a></span>';
                  html += '</div>'+
                '</li>';
              }
              $("#div_chat").html(html);
              $(".nano").nanoScroller({ scroll: 'bottom' });
              $("#nuevo"+chat).html('');
            }
          }
          else {
            $("#div_chat").html('Inicia una conversacion');
          }          
        }
      });
    }
    function enviarMensaje() {
      cargando()
      $("#mensaje_form").submit();
    }
    function cargando(){
      $("#cargar").html('Cargando...');
    } 
    function resultadoOk(){
      $("#text_mensaje").val('');
      $('#archivo').val(null);
      $('#imagen').val(null);
      cargarChat($("#chat_id").val());
      $("#cargar").html('');
      $(".badge").text('');
    }
    function resultadoOkNew(chat_id, user_id){
      location.href = "index/"+chat_id+"/"+user_id+"/4/"+$('#titulo_chat').text();
    } 
    function resultadoErroneo(mensaje){
      $("#div_mensaje").html(mensaje);
      $("#cargar").html('');
    }
    function nuevoMensajeErroneo(mensaje){
      $("#error_nuevo").html(mensaje);      
    }
    function cambiar(chat, user, grupo, id, nombre){
      resultadoOk()
      $("#"+id).attr('onclick', 'cargarChat('+chat+','+user+','+grupo+',"'+id+'","'+nombre+'")');
      cargarChat(chat,grupo,id,nombre);
    }
    function para() {
      if ({{Auth::user()->type_id}}!=1) {
        if($("#radio_asesor").is(':checked')) {  
          $('#emprendedores').hide();
          $('#asesores').show();
        } else {          
          $('#emprendedores').show();
          $('#asesores').hide();
        }
      }
    }
    function nuevoMensaje() {
      if($("#radio_asesor").is(':checked')) {  
        $('#destino').val($('#asesores').text());
        $('#tipo_usuario').val("Asesor");
      } else {
        $('#destino').val($('#emprendedores').text());
        $('#tipo_usuario').val("Emprendedor");
      }
    }
  </script>
@stop

@section('scripts')
  @parent
  <script type="text/javascript" src="{{ URL::asset('Orb/js/bootstrap-filestyle.js') }}"></script>
  <!--X-Editable--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/bootstrap-editable.min.js') }}"></script> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo.js') }}"></script> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo-mock.js') }}"></script> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/select2.js') }}"></script> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/jquery.mockjax.js') }}"></script>
@stop