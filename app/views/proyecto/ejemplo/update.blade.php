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
    <li><a href="{{url('plan-negocios/modulo/'.$ejemplo->pregunta->modulo_id)}}">{{$ejemplo->pregunta->modulo->nombre}}</a></li>
    <li><a href="{{url('plan-negocios/pregunta/'.$ejemplo->pregunta->id)}}">{{$ejemplo->pregunta->pregunta}}</a></li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Ejemplo<small>Editar</small></h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::model($ejemplo, ['url'=>'plan-negocios/editar-ejemplo', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
            {{Form::hidden('id')}}
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
                <div class="col-md-6 espacio_abajo">
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
                    @if($ejemplo->archivo!='')
                        <div class="note"><strong>Nota:</strong> Se replazara el archvio existente</div>
                        <br/><strong>Archivo: </strong><a target="_blank" href="{{url('Orb/images/ejemplos/'.$ejemplo->archivo)}}">{{$ejemplo->archivo}}</a>
                    @endif
                </div>
                @if($ejemplo->archivo!='')
                    <div class="col-md-5 espacio_abajo">
                        <label for="empresa" class="label">Elimina el archivo actual</label>
                        <input name="empresa" type="checkbox" value="yes" id="empresa"> Eliminar archivo
                    </div>
                @endif
            </fieldset>
            <footer>
                <div class="col-md-6 espacio_abajo" >
                    {{ Form::submit('Guardar', ['class'=>'btn btn-success']) }}
                </div>
                <div class="col-md-5 espacio_abajo" style="text-align: right;">
                    * Los campos son obligatorios
                </div>
            </footer>
            {{Form::close()}}
        </div>
    </div>
@stop