@section('titulo')
    Incubamas | Emprendedores
@stop

@section('mensajes')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('mensajes','Mensajes')}}</li>
    <li class="active">Crear</li>
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/tags/chosen/chosen.css') }}
@stop

@section('titulo-seccion')
    <h1>Mensajes
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
            {{Form::open(['url'=>'mensajes/crear-incubito', 'class'=>'orb-form','method' => 'post'])}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo" style="text-align: left;">
                        {{Form::label('nombre', '* Titulo del Chat', array('class' => 'label'))}}
                        <label class="input">
                            {{Form::text('nombre', null)}}
                        </label>
                        <span class="message-error">{{$errors->first('nombre')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('tipo', '* Para', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('tipo[]', [2=>'Asesores', 3=>'Emprendedores'], null, ['data-placeholder'=>"Selecciona", 'class'=>"chosen-select-width", 'multiple'])}}
                        </label>
                        <span class="message-error">{{$errors->first('tipo')}}</span>
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
    {{ HTML::script('Orb/tags/chosen/chosen.jquery.js') }}
    {{ HTML::script('Orb/tags/chosen/prism.js') }}
    <script type="text/javascript">
        $(".chosen-select-width").chosen({width: "100%"});
    </script>
@stop