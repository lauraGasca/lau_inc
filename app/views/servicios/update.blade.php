@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('pagos/index/'.$emprendedor->id,'Pagos')}}</li>
    <li class="active">Editar Servicio</li>
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/bower_components/bootstrap-calendar/css/calendar.css') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js') }}
    {{ HTML::style('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::script('Orb/bower_components/moment/moment.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js') }}
    {{ HTML::script('Orb/js/jquery.maskMoney.js') }}
    <script type="text/javascript">
        $(function () {
            $("#costo_total").maskMoney();
        });
    </script>
@stop

@section('titulo-seccion')
    <h1>Servicio
        <small>Editar</small>
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
            ¡Por favor, revise los datos del formulario! <?php var_dump($errors);?>
        </div>
    @endif
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::model($solicitud, ['url'=>'pagos/editar-solicitud', 'class'=>'orb-form','method' => 'post',])}}
                {{Form::hidden('id')}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('empresa_id', 'Empresa', array('class' => 'label'))}}
                        <label class="select">
                            @if(count($empresas_listado)>0)
                                {{Form::select('empresa_id', $empresas_listado)}}
                            @else
                                {{Form::select('empresa_id', [null=>$emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos])}}
                            @endif
                        </label>
                        <span class="message-error">{{$errors->first('empresa_id')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('fecha_limite', '* Fecha Limite de Pago', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend  fa fa-calendar"></i>
                            {{Form::text('fecha_limite', $solicitud->limita, ['id'=>'fecha_limite', 'readonly'])}}
                        </label>
                        <span class="message-error">{{$errors->first('fecha_limite')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('monto', '* Costo total del Servicio', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-money"></i>
                            {{Form::text('monto', null, ['id'=>'costo_total', 'data-prefix'=>"$ "])}}
                        </label>
                        <span class="message-error">{{$errors->first('monto')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('servicio_id', '* Servicio', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('servicio_id', [null=>'Selecciona']+$servicios, null, ['id'=>'servicios'])}}
                        </label>
                        <span class="message-error">{{$errors->first('servicio_id')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo" id="divNombre" @if(!$errors->first('nombre')&&$solicitud->servicio_id<>5) style="visibility: hidden" @endif>
                        {{Form::label('nombre', '* Servicio', array('class' => 'label'))}}
                        <label class="input">
                            {{Form::text('nombre', null, ['id'=>'nombre_servicio'])}}
                        </label>
                        <span class="message-error">{{$errors->first('nombre')}}</span>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Guardar', ['class'=>'btn btn-info'])}}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </fieldset>
            {{Form::close()}}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}
    <script type="text/javascript">
        $( "#servicios" ).change(function() {
            if( $( "#servicios" ).val() == 5)
                $( "#divNombre" ).css('visibility', 'visible');
            else {
                $("#divNombre").css('visibility', 'hidden');
                $("#nombre_servicio").val('');
            }
        });
        $(function () {
            $('#fecha_limite').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate: '{{$siguiente_pago}}',
                defaultDate: new Date(),
                maxDate: '1/1/2100'
            });
        });
    </script>
@stop