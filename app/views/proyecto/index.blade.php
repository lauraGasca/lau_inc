@section('titulo')
    IncubaM&aacute;s | Plan de Negocios
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Plan de Negocios</li>
@stop

@section('css')
    @parent
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
@stop

@section('titulo-seccion')
    <h1>Plan de Negocios
        <small> Registro</small>
    </h1>
@stop

@section('contenido')
    <div class="powerwidget" id="forms-9" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="row">
                <div class="panel-group" id="accordion">
                    @foreach($modulos as $modulo)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$modulo->id}}">
                                        <i class="fa fa-4x fa-plus-square"></i>&nbsp;&nbsp;&nbsp; {{$modulo->nombre}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse{{$modulo->id}}" class="panel-collapse @if($modulo->id <> 1) collapse @else collapse in @endif">
                                <div class="panel-body">
                                    @foreach($modulo->preguntas as $pregunta)
                                        @if(Session::get('confirm'.$pregunta->id))
                                            <div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
                                                {{Session::get('confirm')}}
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <br/><br/>
                                            <h4>{{Form::label('entrada', $pregunta->pregunta)}}</h4><br/>
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#one-normal{{$pregunta->id}}" data-toggle="tab">Instrucciones</a></li>
                                                <li><a href="#two-normal{{$pregunta->id}}" data-toggle="tab"> Ejemplo</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="one-normal{{$pregunta->id}}">
                                                    {{$pregunta->instruccion}}<br/>
                                                    {{ Form::open(array('url'=>'plan-negocios/pregunta/'.$pregunta->id.'/'.$emprendedor_id, 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data', 'target'=>"subir_archivo") )}}
                                                        <label class="textarea">
                                                            {{Form::textarea('texto','',['id'=>'texto'.$pregunta->id])}}
                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('texto{{$pregunta->id}}', {toolbar: 'Incuba'});
                                                            </script>
                                                        </label>
                                                        <span class="message-error">{{$errors->first('entrada')}}</span>
                                                        <br/>
                                                        @if($pregunta->archive==1)
                                                            {{Form::file('archivo',['id'=>'archivo'.$pregunta->id])}}
                                                            <script>
                                                                $("#archivo{{$pregunta->id}}").fileinput({
                                                                    showCaption: false,
                                                                    browseClass: "btn btn-success",
                                                                    browseLabel: "Subir Archivo",
                                                                    removeClass: "btn btn-danger",
                                                                    removeLabel: "Borrar",
                                                                    removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                                                                    showUpload: false
                                                                });
                                                            </script>
                                                        @endif
                                                        <div style="text-align: right;">
                                                            <input type="submit" class="btn btn-success" value="Guardar">
                                                        </div>
                                                    {{Form::close()}}
                                                </div>
                                                <div class="tab-pane estilo" id="two-normal{{$pregunta->id}}" style="font-family: 'Open Sans', sans-serif;font-size: medium; font-weight: 400; color: #555;">
                                                    @foreach($modulo->ejemplos as $ejemplo)
                                                        @if($ejemplo->pregunta_id == $pregunta->id)
                                                            {{$ejemplo->texto}}
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <br/><br/>
                                    @endforeach
                                    <iframe width="1" height="1" frameborder="0" name="subir_archivo" style="display: none"></iframe>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
@stop