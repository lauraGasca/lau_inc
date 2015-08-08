@section('titulo')
    IncubaM&aacute;s | Plan de Negocios
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('emprendedores/perfil/'.$emprendedor_id,'Perfil')}}</li>
    <li class="active">Plan de Negocios</li>
@stop

@section('css')
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
                <div class="col-md-8">
                    <h4 class="text-purple">Progreso</h4>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"> 60% </div>
                    </div>
                </div>
                <div class="col-md-4"><br/>
                    <a class="btn btn-success" href="{{url('plan-negocios/exportar-word/'.$emprendedor_id)}}">Descargar en Word</a>
                </div>
                <div class="col-md-12">
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
                                <div id="collapse{{$modulo->id}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        @foreach($modulo->preguntas as $pregunta)
                                            <div class="col-md-12">
                                                <br/><br/>
                                                <h4>{{Form::label('entrada', $pregunta->pregunta)}}
                                                    @foreach($progresos as $progreso)
                                                        @if($progreso->pregunta_id == $pregunta->id)
                                                            @if($progreso->estado == 1)
                                                                <i class="fa-3x entypo-check" style="background: none repeat scroll 50% 0% #5EDE5B; color: white; font-size: 20px; margin-left: 10px;"></i>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </h4><br/>
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#one-normal{{$pregunta->id}}" data-toggle="tab">Instrucciones</a></li>
                                                    <li><a href="#two-normal{{$pregunta->id}}" data-toggle="tab"> Ejemplo</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="one-normal{{$pregunta->id}}">
                                                        {{$pregunta->instruccion}}<br/>
                                                        {{ Form::open(array('url'=>'plan-negocios/update-pregunta', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data', 'target'=>"subir_archivo", 'id'=>'form'.$pregunta->id) )}}
                                                        <!--, 'target'=>"subir_archivo"-->
                                                        {{Form::hidden('pregunta_id',$pregunta->id)}}
                                                        {{Form::hidden('emprendedor_id', $emprendedor_id)}}
                                                        <?php $texto = ""; ?>
                                                        @foreach($progresos as $progreso)
                                                            @if($progreso->pregunta_id == $pregunta->id)
                                                                <?php $texto = $progreso->texto; ?>
                                                            @endif
                                                        @endforeach
                                                        @if($pregunta->texto==1)
                                                            <label class="textarea">
                                                                {{Form::textarea('texto'.$pregunta->id,$texto,['id'=>'texto'.$pregunta->id])}}
                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('texto{{$pregunta->id}}', {toolbar: 'Incuba'});
                                                                </script>
                                                            </label><br/>
                                                        @endif
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
                                                        @endif<br/><br/><br/>
                                                        <div id="correcto{{$pregunta->id}}"></div><br/>
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
    </div>
@stop

@section('scripts')
    @parent
    <script>
        function mensaje(id, archivo)
        {
            $("#correcto"+id).html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>Se ha guardado correctamente </div>');
            if(archivo != 0)
                $('#archivo'+id).fileinput('clear');
        }
    </script>
@stop