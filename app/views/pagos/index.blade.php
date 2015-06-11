@section('titulo')
    IncubaM&aacute;s | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('css')
  @parent
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/jquery/jquery.min.js') }}"></script>
  {{ HTML::style('pixit/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
  {{ HTML::script('pixit/bower_components/moment/min/moment.min.js') }}
  {{ HTML::script('pixit/bower_components/moment/locale/es.js') }}
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
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <span class="encabezado_tabla">
        Registro de Pago
        </span>
        <div class="inner-spacer">
            <div class="row" id="powerwidgets">
                <div class="col-md-12 bootstrap-grid">
                    <div class="col-md-8 bootstrap-grid">
                        {{Form::open(['url'=>'pagos/cambia-programa', 'class'=>'orb-form','method' => 'post'])}}
                            {{Form::hidden('emprendedor_id',$emprendedor->id)}}
                            <fieldset>
                                <div class="col-md-9 espacio_abajo">
                                    <label class="select">
                                        {{Form::select('programa', ['Emprendedor'=>'Emprendedor', 'Empresarial'=>'Empresarial', 'Programa Especial'=>'Programa Especial'], $emprendedor->programa)}}
                                        <span class="message-error">{{$errors->first('programa')}}</span>
                                    </label>
                                </div>
                                <div class="col-md-1 espacio_abajo">
                                    <button type="submit" onClick="return confirm('\u00BFSeguro que deseas guardar los cambios?');" class="btn btn-default"><i class="fa entypo-floppy"></i></button>
                                </div>
                            </fieldset>
                        {{Form::close()}}
                    </div>
                    <div class="col-md-4 bootstrap-grid">
                        <div class="buttons-margin-bottom" style="text-align: center; padding-top: 10px;">
                            {{HTML::link('pagos/crear-solicitud/'.$emprendedor->id,'Alta de Servicio', ['class'=>'btn btn-primary', 'style'=>'color:#FFF'])}} &nbsp;&nbsp;
                            @if(count($solicitudes) > 0)
                                {{HTML::link('pagos/crear-pago/'.$emprendedor->id,'Alta de Pago', ['class'=>'btn btn-primary', 'style'=>'color:#FFF'])}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 bootstrap-grid" >
                    <div class="col-md-8 bootstrap-grid">
                        <table class="table table-striped table-hover margin-0px">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Empresa</th>
                                    <th>Servicio</th>
                                    <th>Costo</th>
                                    <th>Pagos</th>
                                    <th>Limite</th>
                                    <th>Estatus</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($solicitudes) > 0)
                                    @foreach($solicitudes as $solicitud)
                                        <tr>
                                            <td>{{$solicitud->id}}</td>
                                            <td>
                                                @if($solicitud->empresa_id<>'')
                                                    {{$solicitud->empresa->nombre_empresa}}
                                                @else
                                                    {{$emprendedor->usuario->nombre}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($solicitud->servicio_id == 5)
                                                    {{$solicitud->nombre}}
                                                @else
                                                    {{$solicitud->servicio->nombre}}
                                                @endif
                                            </td>
                                            <td>{{$solicitud->monto_total}}</td>
                                            <td>
                                                <?php $sumaPagos=0; ?> @foreach($solicitud->pagos as $pago) <?php $sumaPagos+= $pago->monto; ?> @endforeach
                                                $ {{number_format($sumaPagos, 2, '.', ',');}}
                                            </td>
                                            <td>{{$solicitud->limite}}</td>
                                            <td>
                                                <span class="label @if($solicitud->estado=="Liquidado")label-success @else @if($solicitud->estado=="Activo") label-info @else @if($solicitud->estado=="Vencido") label-danger @else @if($solicitud->estado=="Alerta") label-warning @endif @endif @endif @endif">{{$solicitud->estado}}</span>
                                            </td>
                                            <td><a href="{{url('pagos/editar-solicitud/'.$solicitud->id)}}" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                                            <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('pagos/delete-solicitud/'.$solicitud->id)}}" ><i class="fa fa-trash-o"></i></a></td>
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
                        <table class="table table-condensed table-bordered margin-0px" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Pagos Realizados</th>
                                    <th style="text-align: center;">Adeudo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="active">
                                    <td style="text-align: center;">{{$pagosRealizados}}</td>
                                    <td style="text-align: center;">{{$adeudo}}</td>
                                </tr>
                            </tbody>
                        </table>
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
                                        @if($emprendedor->usuario->email<>'')
                                            <td><a target="_blank" href="{{url('emprendedores/imprimir-pago/'.$pago->id)}}" ><i class="fa fa-print"></i></a></td>
                                            <td><a onClick="return confirm('\u00BFSeguro que deseas enviar?');" href="{{url('emprendedores/enviar-pago/'.$pago->id.'/'.$emprendedor->id)}}" ><i class="fa fa-paper-plane"></i></a></td>
                                        @else
                                            <td colspan="2" style="text-align: center"><a target="_blank" href="{{url('emprendedores/imprimir-pago/'.$pago->id)}}" ><i class="fa fa-print"></i></a></td>
                                        @endif
                                        <td>{{$pago->id}}</td>
                                        <td>{{$pago->solicitud->nombre}}</td>
                                        <td>{{$pago->recibido->nombre}} {{$pago->recibido->apellidos}}</td>
                                        <td>{{$pago->monto_total}}</td>
                                        @if($pago->siguiente<>'')
                                            <td>{{$pago->emision}}</td>
                                            <td>{{$pago->siguiente}}</td>
                                        @else
                                            <td colspan="2">{{$pago->emision}}</td>
                                        @endif
                                        <td><a href="{{url('pagos/editar-pago/'.$pago->id)}}" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                                        <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('pagos/delete-pago/'.$pago->id)}}" ><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><i>No hay pagos registrados</i></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop