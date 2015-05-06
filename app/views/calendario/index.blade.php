@section('titulo')
    Incubamas | Calendario
@stop

@section('calendario')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Calendario</li>
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/bower_components/bootstrap-calendar/css/calendar.css') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js') }}
    {{ HTML::style('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::script('Orb/bower_components/moment/moment.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js') }}
@show

@section('titulo-seccion')
    <h1>Calendario
        <small> {{Auth::user()->nombre.' '.Auth::user()->apellidos}}</small>
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
            ¡Por favor, revise los datos del formulario! {{var_dump($errors)}}
        </div>
    @endif

    <div class="powerwidget" id="forms-9" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="container">
                <div class="row">
                    <div class="page-header">
                        <div class="pull-right form-inline" style="float: left !important; width: 85%;">
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
                        <a class="btn btn-info" href="#myModal3" data-toggle="modal">Concretar Cita</a>&nbsp;&nbsp;
                        <a class="btn btn-info" href="#myModal1" data-toggle="modal">Crear Evento</a>&nbsp;&nbsp;
                        <a class="btn btn-info" href="#Servicios" data-toggle="modal">Horarios no disponible</a>&nbsp;&nbsp;
                        <a class="btn btn-info" href="#admin" data-toggle="modal">Borrar del Calendario</a>
                    </div>
                </div>
                <div class="row">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="titulo_pago">Concretar Cita</h4>
                </div>
                {{Form::open(['url'=>'calendario/crear', 'class'=>'orb-form','method' => 'post'])}}
                <div class="modal-body">
                    <fieldset>
                        <div class="col-md-11 espacio_abajo">
                            {{Form::label('user', '* Emprendedor', ['class' => 'label'])}}
                            <label class="select">
                                {{Form::select('user', $asesores,  '', ['id' => 'emprendedor'])}}
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
                                {{Form::select('horario_id', [null=>'Primero Selecciona el emprendedor'])}}
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
                            {{Form::checkbox('notifica', 'yes')}} Notificar al Emprendedor de la cita mediante un correo
                        </div>
                        <div class="col-md-11 espacio_abajo" style="text-align: left;">
                            <br/>* Los campos son obligatorios
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                        <span id="cita">
                                <button class="btn btn-primary" id="cita_boton">Crear</button>
                        </span>
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

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

    <div id="Servicios" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Horarios En Los Que No Te Encuentras Disponible</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url'=>'calendario/horarios-asesor', 'class'=>'orb-form','method' => 'post'])}}
                    <fieldset>
                        {{Form::label('nombre', 'Horarios', ['class' => 'label'])}}
                        <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                            <table class="table table-striped table-bordered table-hover">
                                <tbody>
                                @if(count($noHorarios)>0)
                                    @foreach($noHorarios as $noHorario)
                                        <tr>
                                            <td>{{$noHorario->dia}}</td>
                                            <td>{{$noHorario->horario->horario}}</td>
                                            <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('calendario/delete-horario/'.$noHorario->id)}}"><i class="fa fa-trash-o"></i></a>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" style="font-style: italic; color: gray;">No se han registrado horarios</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('dia', '* Dia', ['class' => 'label'])}}
                            <label class="select">
                                {{Form::select('dia', [null=>'Selecciona', 'Lunes'=>'Lunes', 'Martes'=>'Martes', 'Miercoles'=>'Miercoles', 'Jueves'=>'Jueves', 'Viernes'=>'Viernes'], ['id' => 'dia'])}}
                                <span class="message-error">{{$errors->first('dia')}}</span>
                            </label>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('horario_id', '* Horario', array('class' => 'label'))}}
                            <label class="select" id="divHorario">
                                {{Form::select('horario_id', [null=>'Primero Selecciona el dia'])}}
                                <span class="message-error">{{$errors->first('horario_id')}}</span>
                            </label>
                        </div>
                        <div class="col-md-11 espacio_abajo"></div>
                        <div class="col-md-5 espacio_abajo">
                            <button class="btn btn-primary">A&ntilde;adir</button>
                        </div>
                        <div class="col-md-5 espacio_abajo" style="text-align: right;">
                            <br/>* Los campos son obligatorios
                        </div>
                    </fieldset>
                    {{Form::close()}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="admin" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Citas y Eventos Futuros</h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                        {{Form::open(['url'=>'calendario/delete-evento', 'class'=>'orb-form','method' => 'post'])}}
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
                                                    <td>
                                                        @if($evento->confirmation == 1)
                                                            Confirmado
                                                        @else
                                                            Sin confirmar
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::radio('evento_id', $evento->id) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" style="font-style: italic; color: gray;">No tienes eventos registrados</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                    <div id = "divBorrarCita" class="col-md-11 espacio_abajo" style="visibility: hidden">
                                        {{Form::label('empresa', 'Selecciona la opci&oacute;n deseada', ['class' => 'label'])}}
                                        {{Form::checkbox('correo', 'yes')}} Enviarme un correo con los datos del Evento/Cita Cancelada<br/>
                                        {{Form::checkbox('notifica', 'yes')}} Notificar al Emprendedor de la cancelacion de la cita mediante un correo
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
        //Al añadir un horario no disponible. Cuando se selecciona un dia, se ponen solo los horarios disponibles del asesor para ese dia
        $( "#dia" ).change(function() {
            dia = $('#dia').val();
            $.ajax({
                url: '/calendario/horario-dia',
                type: 'POST',
                data: {dia: dia},
                dataType: 'JSON',
                error: function () {
                    $("#divHorario").html('Ha ocurrido un error...');
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
                        $("#divHorario").html(html);
                    }
                    else {
                        $("#divHorario").html('No se que pasa');
                    }
                }
            });
        });

        var eventos = {
            change: function(){
                emprendedor = $('#emprendedor').val();
                fecha = $('#fecha').val();
                $.ajax({
                    url: '/calendario/horario',
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
        $('#emprendedor').on(eventos);
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

        //Configuración del Calendario
        (function ($) {
            //creamos la fecha actual
            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            //establecemos los valores del calendario
            var options = {
                events_source: '{{url('calendario/obtener')}}',
                view: 'month',
                language: 'es-MX',
                tmpl_path: '{{url('Orb/bower_components/bootstrap-calendar/tmpls')}}/',
                tmpl_cache: false,
                day: yyyy + "-" + mm + "-" + dd,
                time_start: '9:00',
                time_end: '18:00',
                time_split: '30',
                width: '85%',
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
                defaultDate: new Date(),
                minDate: '{{date ( 'm/j/Y')}}'
            });
            $('#to').datetimepicker({
                language: 'es',
                defaultDate: new Date(),
                minDate: '{{date ( 'm/j/Y')}}'
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
