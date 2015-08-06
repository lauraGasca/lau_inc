@section('titulo')
    Incubamas | Modelo de Negocio
@stop

@section('proyecto')
    class="active"
@stop

@section('css')
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li><a href="{{url('plan-negocios')}}">Modelo de Negocio</a></li>
    <li><a href="{{url('plan-negocios/modulo/'.$pregunta->modulo_id)}}">{{$pregunta->modulo->nombre}}</a></li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Pregunta<small>Editar</small></h1>
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
            {{Form::model($pregunta, ['url'=>'plan-negocios/editar-pregunta', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
            {{Form::hidden('id')}}
            <fieldset>
                <div class="col-md-11 espacio_abajo">
                    {{Form::label('pregunta', '* Pregunta', ['class' => 'label'])}}
                    <label class="input">
                        <i class="icon-prepend fa fa-question"></i>{{Form::text('pregunta')}}
                        <span class="message-error">{{$errors->first('pregunta')}}</span>
                    </label>
                </div>
                <div class="col-md-11 espacio_abajo">
                    {{Form::label('instruccion', 'Instruccion', ['class' => 'label'])}}
                    <label class="textarea">
                        {{Form::textarea('instruccion')}}
                        <script type="text/javascript">
                            CKEDITOR.replace('instruccion', {toolbar : 'Incuba'});
                        </script>
                        <span class="message-error">{{$errors->first('instruccion')}}</span>
                    </label>
                </div>
                <div class="col-md-6 espacio_abajo">
                    {{Form::label('orden', '* Orden', ['class' => 'label'])}}
                    <label class="input">
                        {{Form::text('orden')}}
                    </label>
                </div>
                <div class="col-md-5 espacio_abajo">
                    {{Form::label('texto-archivo', '* Requerir al Usuario', ['class' => 'label'])}}
                    <label class="checkbox-inline" for="checkboxes-0">
                        <input name="checkboxes" id="checkboxes-0" value="1" type="checkbox">
                        {{Form::checkbox('texto', true , true)}} Texto
                        <span class="message-error">{{$errors->first('texto')}}</span>
                    </label>
                    <label class="checkbox-inline" for="checkboxes-0">
                        <input name="checkboxes" id="checkboxes-0" value="1" type="checkbox">
                        {{Form::checkbox('archive', true , false)}} Archivo
                        <span class="message-error">{{$errors->first('archive')}}</span>
                    </label>
                </div>
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