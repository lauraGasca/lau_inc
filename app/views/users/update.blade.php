@section('titulo')
    Incubamas | Editar Perfil
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Editar Perfil</li>
@stop

@section('titulo-seccion')
    <h1>Usuario
        <small>Editar Perfil</small>
    </h1>
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::model($usuario, ['url'=>'usuarios/editar', 'class'=>'orb-form','method' => 'post',])}}
                {{Form::hidden('id')}}
                <fieldset>
                    <div class="col-md-8 espacio_abajo">
                        {{Form::label('user', '* Nombre de Usuario', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::text('user')}}
                        </label>
                        <span class="message-error">{{$errors->first('user')}}</span>
                    </div>
                    <div class="col-md-8 espacio_abajo">
                        {{Form::label('password', 'Contraseña', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::password('password')}}
                        </label>
                        <span class="message-error">{{$errors->first('password')}}</span>
                    </div>
                    <div class="col-md-8 espacio_abajo">
                        {{Form::label('password_confirmation', 'Confirma la contraseña', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::password('password_confirmation')}}
                        </label>
                        <span class="message-error">{{$errors->first('password_confirmation')}}</span>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Guardar', ['class'=>'btn btn-info'])}}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </fieldset>
            {{Form::close()}}
        </div>
    </div>
@stop