@section('titulo')
    IncubaM&aacute;s | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('css')
  @parent
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/jquery/jquery.min.js') }}"></script> 
@show

@section('mapa')
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
  <li class="active">Pagos</li>
@stop

@section('titulo-seccion')
  <h1>Emprendedores<small> Pagos</small></h1>
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
  @if(Session::get('monto')||Session::get('fecha')||Session::get('liquidado')
    ||Session::get('fecha-siguiente')||Session::get('fecha-emision')||Session::get('monto-pago'))
    <script>
      alert("¡Por favor, revise los datos del formulario!");
    </script>
  @endif
  @if(count($errors)>0)
    <script>
      alert("¡Por favor, revise los datos del formulario!");
    </script>
 @endif
  <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
    <span class="encabezado_tabla">
      Registro de Pago
    </span>
    <div class="inner-spacer">
      <!-- Widget Row Start grid -->
      <div class="row" id="powerwidgets">
        <div class="col-md-12 bootstrap-grid">
          <div class="col-md-8 bootstrap-grid">
            {{ Form::open(array('url'=>'emprendedores/cambiaprograma', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
              {{Form::hidden('emprendedor_id',$emprendedor->id)}}
              <fieldset>
                <div class="col-md-9 espacio_abajo">
                  <label class="select">
                    {{Form::select('programa', array('Emprendedor'=>'Emprendedor', 'Empresarial'=>'Empresarial', 'Programa Especial'=>'Programa Especial'), $emprendedor->programa)}}
                  <span class="message-error">{{$errors->first('programa')}}</span>
                </div>
                <div class="col-md-1 espacio_abajo">
                  <button type="submit" onClick="return confirm('\u00BFSeguro que deseas guardar los cambios?');" class="btn btn-default"><i class="fa entypo-floppy"></i></button>
                </div>
              </fieldset>
            {{Form::close()}}
          </div>
          <div class="col-md-4 bootstrap-grid">
            <div class="buttons-margin-bottom" style="text-align: center; padding-top: 10px;">
              <a href="#myModal1" role="button" data-target="#myModal1" class="btn btn-default" data-toggle="modal" onclick="altaServicio();">Alta de Servicio</a>
              @if(count($solicitudes) > 0)
                <a href="#myModal3" role="button" class="btn btn-default" data-toggle="modal" onclick="altaPago();">Alta de Pago</a>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-12 bootstrap-grid" >
          <div class="col-md-8 bootstrap-grid"> 
            <table class="table table-striped table-hover margin-0px">
              <thead>
                <tr>
                  <th>Empresa</th>
                  <th>Servicio</th>
                  <th>Costo</th>
                  <th>Pagos Realizados</th>
                  <th>Limite de pago</th>
                  <th>Estatus</th>
                  <th colspan="2"></th>
                </tr>
              </thead>
              <tbody>
              @if(count($solicitudes) > 0)
                @foreach($solicitudes as $solicitud)
                  <tr>
                    @if($solicitud->empresa<>'')
                      <td>{{$solicitud->empresa}}</td>
                    @else
                      <td>{{$solicitud->nombre_completo}}</td>
                    @endif
                    <td>{{$solicitud->servicios}}</td>
                    <td>$ {{number_format($solicitud->monto, 2, '.', ',');}}</td>
                    <td>$ {{number_format($solicitud->pagos, 2, '.', ',');}}</td>
                    <?php
                      $date = date_create($solicitud->fecha_limite);
                      $fecha=date_format($date, 'd-m-Y');
                    ?>
                    <td>{{$fecha}}</td>
                    <td>
                      @if($solicitud->estado=="Liquidado")
                        <span class="label label-success">Liquidado</span>
                      @else
                        @if($solicitud->estado=="Activo")
                          <span class="label label-info">Activo</span>
                        @else
                          @if($solicitud->estado=="Vencido")
                            <span class="label label-danger">Vencido</span>
                          @else
                            @if($solicitud->estado=="Alerta")
                              <span class="label label-warning">Alerta</span>
                            @endif
                          @endif
                        @endif
                      @endif
                    </td>
                    <td><a href="#myModal1" data-toggle="modal" id="linkEditaServicio" onclick="editaServicio({{$solicitud->id}});"><i class="fa fa-pencil"></i></a></td>                      
                    <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/deletesolicitud/'.$solicitud->id)}}" ><i class="fa fa-trash-o"></i></a></td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6"><i>No hay servicios registrados</i></td>
                </tr>
              @endif                
              </tbody>
            </table>
          </div>
          <div class="col-md-4 bootstrap-grid">
            <center >
              <table class="table table-condensed table-bordered margin-0px" style="width: 80%; text-align: center;">
                <thead>
                  <tr>
                    <th style="text-align: center;">Pagos Realizados</th>
                    <th style="text-align: center;">Adeudo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="active">
                    <td>$ {{number_format($total_pagos->total, 2, '.', ',');}}</td>
                    <td>$ {{number_format($total_servicios, 2, '.', ',');}}</td>
                  </tr>
                </tbody>
              </table>
            </center>
          </div>
        </div>
        <div class="col-md-12 bootstrap-grid" style="padding-top: 50px;">
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
                <th>Siguiente Pago</th>
                <th colspan="2"></th>
              </tr>
            </thead>
            <tbody>
            @if(count($pagos) > 0)
              @foreach($pagos as $pago)
                <tr class="active">
                  <td><a target="_blank" href="{{url('emprendedores/imprimirpago/'.$pago->id)}}" ><i class="fa fa-print"></i></a></td>
                  @if($emprendedor->email<>'')
                    <td><a onClick="return confirm('\u00BFSeguro que deseas enviar?');" href="{{url('emprendedores/enviarpago/'.$pago->id.'/'.$emprendedor->id)}}" ><i class="fa fa-paper-plane"></i></a></td>
                  @else
                    <td></td>
                  @endif
                  <td>{{$pago->id}}</td>
                  <td>{{$pago->nombre_solicitud}}</td>
                  <td>{{$pago->nombre_completo}}</td>
                  <td>$ {{number_format($pago->monto, 2, '.', ',');}}</td>
                  <?php
                    $fecha_actual = strtotime(date("Y-m-d"));
                    $date = date_create($pago->created_at);
                    $fecha=date_format($date, 'Y-m-d');
                    $fecha_limite = strtotime($fecha);
                    $nueva_fecha = strtotime ( '+1 day' , $fecha_limite);                    
                    $date = date_create($pago->fecha_emision);
                    $fecha=date_format($date, 'd-m-Y');
                  ?>
                  <td>{{$fecha}}</td>
                  <?php
                    $date = date_create($pago->siguiente_pago);
                    $fecha=date_format($date, 'd-m-Y');
                  ?>
                  <td>{{$fecha}}</td>
                  <td><a href="#myModal3" data-toggle="modal" id="linkEditaServicio" onclick="editaPago({{ltrim($pago->id, '0')}});"><i class="fa fa-pencil"></i></a></td>
                  <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/deletepago/'.$pago->id)}}" ><i class="fa fa-trash-o"></i></a></td>
                </tr>
              @endforeach
            @else
              @if(count($pagos_emp) > 0)
                @foreach($pagos_emp as $pago)
                  <tr class="active">
                    <td><a target="_blank" href="{{url('emprendedores/imprimirpago/'.$pago->id.'/recibo.pdf')}}" ><i class="fa fa-print"></i></a></td>
                    @if($emprendedor->email<>'')
                      <td><a onClick="return confirm('\u00BFSeguro que deseas enviar?');" href="{{url('emprendedores/enviarpago/'.$pago->id.'/'.$emprendedor->id.'/pago.pdf')}}" ><i class="fa fa-paper-plane"></i></a></td>
                    @else
                      <td></td>
                    @endif
                    <td>{{$pago->id}}</td>
                    <td>{{$pago->nombre_solicitud}}</td>
                    <td>{{$pago->nombre_completo}}</td>
                    <td>$ {{number_format($pago->monto, 2, '.', ',');}}</td>
                    <?php
                      $date = date_create($pago->fecha_emision);
                      $fecha=date_format($date, 'd-m-Y');
                    ?>
                    <td>{{$fecha}}</td>
                    <td><a href="#myModal3" data-toggle="modal" id="linkEditaServicio" onclick="editaPago({{ltrim($pago->id, '0')}});"><i class="fa fa-pencil"></i></a></td>
                    <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/deletepago/'.$pago->id."/".$emprendedor->id)}}" ><i class="fa fa-trash-o"></i></a></td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6"><i>No hay pagos registrados</i></td>
                </tr>
              @endif
            @endif   
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Alta de Servicio</h4>
        </div>
        <div class="modal-body" id="editarServicio">
          {{Form::open(array('url'=>'emprendedores', 'class'=>'orb-form','method' => 'post', 'id'=>'servicio_form', 'enctype'=>'multipart/form-data') )}}
            {{Form::hidden('emprendedor_id',$emprendedor->id)}}
            {{Form::hidden('solicitud_id','',array('id'=>'solicitud_ajax'))}}
            <span class="message-error">{{$errors->first('emprendedor')}}</span>
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('empresa', 'Empresa', array('class' => 'label'))}}
                <label class="select">
                @if(count($empresas)>0)
                  {{Form::select('empresa', array(null=>'Selecciona')+$empresas,'',array('id'=>'empresa_ajax'))}}
                @else
                  {{Form::select('empresa', array(null=>$emprendedor->name." ".$emprendedor->apellidos),null,array('id'=>'empresa_ajax'))}}
                @endif
                </label>
                <span class="message-error">{{$errors->first('empresa')}}</span>
              </div>
              <div class="col-md-5 espacio_abajo">
                {{Form::label('servicio', '* Servicio', array('class' => 'label'))}}
                <label class="select">
                  {{Form::select('servicio', array(null=>'Selecciona')+$servicios,'',array('id'=>'servicio_ajax'))}}
                </label>
                <span class="message-error">{{$errors->first('servicio')}}</span>
              </div>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('monto', '* Costo total del Servicio', array('class' => 'label'))}}
                <label class="input">
                  <i class="icon-prepend fa fa-money"></i>
                  {{Form::text('monto','',array('id'=>'monto_ajax'))}}
                </label>
                <span class="message-error">{{$errors->first('monto')}}</span>
                @if(Session::get('monto'))
                  <span class="message-error">{{Session::get('monto')}}</span>
                @endif
              </div>
              <div class="col-md-5 espacio_abajo">
                {{Form::label('fecha_limite', '* Fecha Limite de Pago', array('class' => 'label'))}}
                <label class="input">
                  <i class="icon-prepend  fa fa-calendar"></i>
                  {{Form::text('date','',array('id'=>'date2'))}}
                </label>
                <span class="message-error">{{$errors->first('date')}}</span>
                @if(Session::get('fecha'))
                  <span class="message-error">{{Session::get('fecha')}}</span>
                @endif
              </div>
              <div class="col-md-11 espacio_abajo" style="text-align: left;">
                * Los campos son obligatorios
              </div>
            </fieldset>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="servicio_boton">Continuar</button>
          {{Form::close()}}
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="titulo_pago">Alta de Pago</h4>
        </div>
        <div class="modal-body" id='editarPago'>
          {{ Form::open(array('url'=>'emprendedores/crearpago', 'class'=>'orb-form','method' => 'post', 'id'=>'pago_form', 'enctype'=>'multipart/form-data') )}}
            {{Form::hidden('pago_id','',array('id'=>'pago_id'))}}
            {{Form::hidden('emprendedor_id',$emprendedor->id)}}
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('solicitud', '* Concepto', array('class' => 'label'))}}
                <label class="select">
                  {{Form::select('solicitud', $solicitud_lista + $solicitud_lista_emp,'',array('id'=>'solicitud_pago'))}}
                </label>
                <span class="message-error">{{$errors->first('solicitud')}}</span>
              </div>
              <div class="col-md-5 espacio_abajo">
                {{Form::label('monto', '* Monto total del Pago', array('class' => 'label'))}}
                <label class="input">
                  <i class="icon-prepend fa fa-money"></i>
                  {{Form::text('monto','',array('id'=>'monto_pago'))}}
                </label>
                <span class="message-error">{{$errors->first('monto')}}</span>
                @if(Session::get('monto-pago'))
                  <span class="message-error">{{Session::get('monto-pago')}}</span>
                @endif
              </div>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('fecha_emision', '* Fecha de Emision', array('class' => 'label'))}}
                <label class="input">
                  <i class="icon-prepend fa fa-calendar"></i>
                  {{Form::text('start','',array('id'=>'start'))}}
                </label>
                <span class="message-error">{{$errors->first('start')}}</span>
                @if(Session::get('fecha-emision'))
                  <span class="message-error">{{Session::get('fecha-emision')}}</span>
                @endif
              </div>
              <div class="col-md-5 espacio_abajo">
                {{Form::label('recibido', '* Recibido por', array('class' => 'label'))}}
                <label class="select">
                  {{Form::select('recibido', $asesores)}}
                </label>
                <span class="message-error">{{$errors->first('recibido')}}</span>
              </div>
              <div class="col-md-6 espacio_abajo" style="text-align: left;">
                {{Form::checkbox('ultimo', 'yes', '',array('id'=>'ultimo','onchange'=>'evento();'))}} Cuenta Liquidada
                <label class="input">
                  <i class="icon-prepend  fa fa-calendar"></i>
                  {{Form::text('finish','',array('id'=>'finish', 'placeholder'=>'Fecha del Siguiente Pago'))}}
                </label>
                <span class="message-error">{{$errors->first('date')}}</span>
                @if(Session::get('fecha-siguiente'))
                  <span class="message-error">{{Session::get('fecha-siguiente')}}</span>
                @endif
                @if(Session::get('liquidado'))
                  <span class="message-error">{{Session::get('liquidado')}}</span>
                @endif
              </div>
              <div class="col-md-11 espacio_abajo" style="text-align: left;">
                * Los campos son obligatorios
              </div>
            </fieldset>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="pago_boton">Crear</button>
          {{Form::close()}}
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End .powerwidget -->
  <script type="text/javascript">
    function editaServicio(servicio) {
      $.ajax({
        url: '/emprendedores/editarservicio',
        type: 'GET',
        data: {servicio_id: servicio},
        dataType: 'JSON',
        error: function() {
          $("#editarServicio").html('<div> Ha surgido un error. </div>');
        },
        success: function(respuesta) {
          if (respuesta) {
            $("#servicio_form").attr("action", "/emprendedores/editarservicio");
            $("#monto_ajax").val(respuesta.costo);
            $("#date2").val(respuesta.fecha);
            $("#solicitud_ajax").val(respuesta.solicitud);
            $("#empresa_ajax").val(respuesta.empresa);
            $("#servicio_ajax").val(respuesta.servicio);
            $("#servicio_boton").text('Guardar');
            $("#myModalLabel").text('Editar Servicio');
          } else {
            $("#editarServicio").html('<div> Ha ocurrido un error. </div>');
          }
        }
      });
    }
    function altaServicio() {
      $("#servicio_form").attr("action", "/emprendedores/crearservicio");
      $("#myModalLabel").text('Alta de Servicio');
      $("#servicio_boton").text('Crear'); 
    }
    function editaPago(pago) {
      $.ajax({
        url: '/emprendedores/editarpago',
        type: 'GET',
        data: {pago_id: pago},
        dataType: 'JSON',
        error: function() {
           $("#editarPago").html('<div> Ha surgido un error. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#pago_form").attr("action", "/emprendedores/editarpago");
              $("#titulo_pago").text('Editar Pago');
              $("#pago_boton").text('Guardar');
              
              $("#pago_id").val(respuesta.pago);
              $("#solicitud_pago").val(respuesta.solicitud);
              $("#monto_pago").val(respuesta.monto);
              $("#start").val(respuesta.start);
              $("#recibido").val(respuesta.recibido);
              if (respuesta.finish==null) {
                $("#ultimo").prop("checked", true);
                $("#finish").prop('disabled', true);
              }else{              
                $("#finish").val(respuesta.finish);
              }
           } else {
              $("#editarPago").html('<div> Ha ocurrido un error. </div>');
           }
        }
      });
    }
    function altaPago() {
      $("#pago_form").attr("action", "/emprendedores/crearpago");
      $("#titulo_pago").text('Alta de Pago');
      $("#pago_boton").text('Crear'); 
    }
    function evento() {
      if ($("#ultimo").prop("checked")) {
        $("#finish").prop('disabled', true);
        $("#finish").val('');
      }else{
        $("#finish").prop('disabled', false);
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