@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('pagos/index/'.$emprendedor_id,'Pagos')}}</li>
    <li class="active">Crear</li>
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
    <h1>Pagos
        <small>Crear</small>
    </h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::open(['url'=>'pagos/crear-pago', 'class'=>'orb-form','method' => 'post'])}}
                {{Form::hidden('emprendedor_id', $emprendedor_id)}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('solicitud_id', '* Concepto', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('solicitud_id', [null=>'Selecciona']+$solicitudes_listado, null, ['id'=>'solicitud_id'])}}
                            {{Form::select('siguiente_id', [null=>'Selecciona']+$solicitudes_limite, null, ['id'=>'siguiente_id', 'style'=>'display: none'])}}
                        </label>
                        <span class="message-error">{{$errors->first('solicitud_id')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('monto', '* Monto total del Pago', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-money"></i>
                            {{Form::text('monto', null, ['id'=>'costo_total', 'data-prefix'=>"$ "])}}
                        </label>
                        <span class="message-error">{{$errors->first('monto')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('fecha_emision', '* Fecha de Emision', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-calendar"></i>
                            {{Form::text('fecha_emision', null, ['id'=>'fecha_emision'])}}
                        </label>
                        <span class="message-error">{{$errors->first('fecha_emision')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('recibido_by', '* Recibido por', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('recibido_by', [null=>'Selecciona']+$asesores)}}
                        </label>
                        <span class="message-error">{{$errors->first('recibido_by')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo" style="text-align: left;">
                        {{Form::label('siguiente_pago', 'Fecha del Siguiente Pago', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend  fa fa-calendar"></i>
                            {{Form::text('siguiente_pago', null, ['id'=>'siguiente_pago'])}}
                        </label>
                        <span class="message-error">{{$errors->first('siguiente_pago')}}</span>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Crear', ['class'=>'btn btn-info'])}}
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
        $(function () {
            $('#fecha_emision').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate:'1/1/2000',
                defaultDate: new Date(),
                maxDate: '1/1/2100'
            });
        });
        $(function () {
            $('#siguiente_pago').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate:'1/1/2000',
                defaultDate: new Date(),
                maxDate: '1/1/2100'
            });
        });
        $("#fecha_emision").on("dp.change", function (e) {
            if ($("#fecha_emision").val() > $('#siguiente_pago').val()) {
                $('#siguiente_pago').data("DateTimePicker").setDate(e.date);
            }
        });
        $("#siguiente_pago").on("dp.change", function (e) {
            if ($("#fecha_emision").val() > $('#siguiente_pago').val()) {
                $('#fecha_emision').data("DateTimePicker").setDate(e.date);
            }
        });
        $( "#solicitud_id" ).change(function() {
            siguiente_id.selectedIndex = solicitud_id.selectedIndex;
            $('#siguiente_pago').data("DateTimePicker").setMaxDate($( "#siguiente_id" ).val());
            if ($("#siguiente_pago").val() > $( "#siguiente_id" ).val()) {
                $('#siguiente_pago').data("DateTimePicker").setDate($( "#siguiente_id" ).val());
            }
            $('#fecha_emision').data("DateTimePicker").setMaxDate($( "#siguiente_id" ).val());
            if ($("#fecha_emision").val() > $( "#siguiente_id" ).val()) {
                $('#fecha_emision').data("DateTimePicker").setDate($( "#siguiente_id" ).val());
            }
        });
    </script>
@stop