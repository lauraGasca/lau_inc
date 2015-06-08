@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
    <li>{{HTML::link('emprendedores/editar/'.$emprendedor_id,'Emprendedor')}}</li>
    <li class="active">Editar</li>
@stop

@section('css')
    @parent
    {{ HTML::script('Orb/js/jquery.maskedinput.js')}}
    <script type="text/javascript">
        $(function () {
            $("#tel").mask("(999) 999-9999");
        });
    </script>
@stop

@section('titulo-seccion')
    <h1>Socios
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
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::open(['url'=>'emprendedores/crear-socio', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('emprendedor_id',$emprendedor_id)}}
                <fieldset>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('empresa_id', '* Empresas', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('empresa_id', $empresas_listado)}}
                            <span class="message-error">{{$errors->first('empresa_id')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('nombre', '* Nombre', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>{{Form::text('nombre')}}
                            <span class="message-error">{{$errors->first('nombre')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('apellidos', '* Apellidos', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>{{Form::text('apellidos')}}
                            <span class="message-error">{{$errors->first('apellidos')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('email', '* Email', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-envelope"></i>{{Form::email('email')}}
                            <span class="message-error">{{$errors->first('email')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('telefono', '* Telefono', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-phone"></i>{{Form::text('telefono', null, ['id'=>'tel'])}}
                            <span class="message-error">{{$errors->first('telefono')}}</span>
                        </label>
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