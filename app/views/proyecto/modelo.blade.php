@section('titulo')
    IncubaM&aacute;s | Plan de Negocios
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('emprendedores/perfil/'.$emprendedor_id,'Perfil')}}</li>
    <li class="active">Plan de Negocios</li>
@stop

@section('css')
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
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$porcentaje}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentaje}}%;"> {{$porcentaje}}% </div>
                    </div>
                </div>
                @if($porcentaje>0)
                    <div class="col-md-4"><br/>
                        <a class="btn btn-primary" href="{{url('plan-negocios/exportar-word/'.$emprendedor_id)}}">Descargar en Word</a>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="panel-group" id="accordion">
                        @foreach($modulos as $modulo)
                            <div class="panel panel-success">
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
                                            <br/>
                                            <h4>
                                                {{$pregunta->pregunta}}
                                                <?php
                                                    $texto = "";
                                                    $archivo = "";
                                                ?>
                                                @foreach($progresos as $progreso)
                                                    @if($progreso->pregunta_id == $pregunta->id)
                                                        @if($progreso->estado == 1)
                                                            <i class="fa-3x entypo-check" style="background: none repeat scroll 50% 0% #5EDE5B; color: white; font-size: 20px; margin-left: 10px;"></i>
                                                            @if($progreso->texto != '')
                                                                <?php $texto = $progreso->texto; ?>
                                                            @endif
                                                            @if($progreso->archivo != '')
                                                                <?php $archivo = $progreso->archivo; ?>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </h4>
                                            <br/>
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#one-normal{{$pregunta->id}}" data-toggle="tab">Instrucciones</a></li>
                                                <li><a href="#two-normal{{$pregunta->id}}" data-toggle="tab"> Ejemplo</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="one-normal{{$pregunta->id}}">
                                                    {{$pregunta->instruccion}}<br/>
                                                    {{ Form::open(array('url'=>'plan-negocios/update-pregunta', 'class'=>'orb-form', 'method' => 'post', 'enctype'=>'multipart/form-data', 'target'=>"subir_archivo", 'id'=>'form'.$pregunta->id) )}}
                                                        <!--, 'target'=>"subir_archivo"-->
                                                        {{Form::hidden('pregunta_id',$pregunta->id)}}
                                                        {{Form::hidden('emprendedor_id', $emprendedor_id)}}
                                                        @if($pregunta->texto==1)
                                                            <label class="textarea">
                                                                {{Form::textarea('texto'.$pregunta->id,$texto,['id'=>'texto'.$pregunta->id])}}
                                                            </label><br/>
                                                        @endif
                                                        @if($pregunta->archive==1)
                                                            {{Form::file('archivo'.$pregunta->id,['id'=>'archivo'.$pregunta->id])}}
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
                                                            @if($archivo !='')
                                                                <div class="note"><strong>Nota:</strong> Se replazara el archvio existente</div>
                                                                <br/>
                                                                <strong>Archivo: </strong>
                                                                <a target="_blank" href="{{url('Orb/images/progresos/'.$archivo)}}">{{$archivo}}</a>
                                                            @endif
                                                        @endif<br/><br/><br/>
                                                        <div id="correcto{{$pregunta->id}}"></div><br/>
                                                        <div style="text-align: right;">
                                                            <input type="submit" class="btn btn-success" value="Guardar">
                                                        </div>
                                                    {{Form::close()}}
                                                </div>
                                                <div class="tab-pane estilo" id="two-normal{{$pregunta->id}}" style="font-family: 'Open Sans', sans-serif;font-size: medium; font-weight: 400; color: #555;">
                                                    @foreach($pregunta->ejemplos as $ejemplo)
                                                        {{$ejemplo->texto}}
                                                        @if($ejemplo->archivo!='')
                                                            <strong>Archivo de ejemplo: </strong>
                                                            <a target="_blank" href="{{url('Orb/images/ejemplos/'.$ejemplo->archivo)}}">{{$ejemplo->archivo}}</a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe width="1" height="1" frameborder="0" name="subir_archivo" style="display: none"></iframe>
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

