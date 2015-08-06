@section('titulo')
    Incubamas | Modelo de Negocio
@stop

@section('proyecto')
    class="active"
@stop

@section('css')
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}

    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li><a href="{{url('plan-negocios')}}">Modelo de Negocio</a></li>
    <li><a href="{{url('plan-negocios/modulo/'.$pregunta->modulo_id)}}">{{$pregunta->modulo->nombre}}</a></li>
    <li><a href="{{url('plan-negocios/pregunta/'.$pregunta->id)}}">{{$pregunta->pregunta}}</a></li>
    <li class="active">Crear</li>
@stop

@section('titulo-seccion')
    <h1>Ejemplo<small>Crear</small></h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::open(['url'=>'plan-negocios/crear-ejemplo', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('pregunta_id', $pregunta->id)}}
                <fieldset>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('texto', '* Ejemplo', ['class' => 'label'])}}
                        <label class="textarea">
                            {{Form::textarea('texto')}}
                            <script type="text/javascript">
                                CKEDITOR.replace('texto', {toolbar : 'Incuba'});
                            </script>
                            <span class="message-error">{{$errors->first('texto')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('archivo', 'Adjuntar Archivo', ['class' => 'label'])}}
                        {{Form::file('archivo')}}<br/>
                        <span class="message-error" style="font-weight: bold">{{$errors->first('archivo')}}</span>
                        <script>
                            $("#archivo").fileinput({
                                browseLabel: " Documento a subir ",
                                showCaption: false,
                                removeClass: "btn btn-danger",
                                removeLabel: "Borrar",
                                removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                                showUpload: false
                            });
                        </script>
                    </div>
                </fieldset>
                <footer>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Crear', ['class'=>'btn btn-success']) }}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </footer>
            {{Form::close()}}
        </div>
    </div>
@stop