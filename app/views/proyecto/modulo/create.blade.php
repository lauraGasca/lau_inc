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
    <li class="active">Crear</li>
@stop

@section('titulo-seccion')
    <h1>Modulo<small>Crear</small></h1>
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
            {{Form::open(['url'=>'plan-negocios/crear', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('nombre', '* Nombre del Modulo', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-question"></i>{{Form::text('nombre')}}
                            <span class="message-error">{{$errors->first('nombre')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('orden', '* Orden', ['class' => 'label'])}}
                        <label class="input">
                            {{Form::text('orden', count($modulos)+1)}}
                        </label>
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