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
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}
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
                        <a class="btn btn-success" href="{{url('plan-negocios/exportar-word/'.$emprendedor_id)}}">Descargar en Word</a>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="panel-group" id="accordion">
                        @foreach($modulos as $modulo)
                            <div class="panel panel-primary">
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
                                                <h4>{{Form::label('entrada', $pregunta->pregunta)}}
                                                    @foreach($progresos as $progreso)
                                                        @if($progreso->pregunta_id == $pregunta->id)
                                                            @if($progreso->estado == 1)
                                                                <i class="fa-3x entypo-check" style="background: none repeat scroll 50% 0% #5EDE5B; color: white; font-size: 20px; margin-left: 10px;"></i>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </h4><br/>

                                            </div>
                                            <br/><br/>
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
@stop

