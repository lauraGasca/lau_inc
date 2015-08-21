@section('titulo')
    Incubamas | Entradas del Blog
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
@stop

@section('usuarios')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('usuarios','Usuarios')}}</li>
    <li class="active">Crear</li>
@stop

@section('titulo-seccion')
    <h1>Usuarios<small>Crear</small></h1>
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
            {{ Form::open(['url'=>'usuarios/crear', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                <fieldset>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('user', '* Nombre de Usuario', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::text('user')}}
                        </label>
                        <span class="message-error">{{$errors->first('user')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('email', '* Correo electr&oacute;nico', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-envelope"></i>{{Form::email('email')}}
                            <span class="message-error">{{$errors->first('email')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('nombre', '* Nombre', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>{{Form::text('nombre')}}
                            <span class="message-error">{{$errors->first('nombre')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('apellidos', '* Apellidos', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>{{Form::text('apellidos')}}
                            <span class="message-error">{{$errors->first('apellidos')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('puesto', '* Puesto', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::text('puesto')}}
                        </label>
                        <span class="message-error">{{$errors->first('puesto')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('type_id', '* Tipo de Usuario', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('type_id', $tipos)}}
                            <span class="message-error">{{$errors->first('type_id')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('password', '* Contraseña', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::password('password')}}
                        </label>
                        <span class="message-error">{{$errors->first('password')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('password_confirmation', '* Confirma la contraseña', array('class' => 'label'))}}
                        <label class="input">
                            <i class="icon-prepend fa fa-user"></i>
                            {{Form::password('password_confirmation')}}
                        </label>
                        <span class="message-error">{{$errors->first('password_confirmation')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('active', '* Estado', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('active', [1=>'Activo', 0=>'Inactivo'])}}
                            <span class="message-error">{{$errors->first('active')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('foto', 'Foto', ['class' => 'label'])}}
                        {{Form::file('foto', ['accept'=>"image/*"])}}<br/>
                        <span class="message-error" style="font-weight: bold">{{$errors->first('foto')}}</span>
                        <div class="note"><strong>Nota:</strong>La imagen debe medir 300 x 300</div>
                        <script type="text/javascript">
                            $("#foto").fileinput({
                                previewFileType: "image",
                                browseClass: "btn btn-success",
                                browseLabel: " Selecciona la imagen ",
                                browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
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
                        {{ Form::submit('Crear', ['class'=>'btn btn-primary'])}}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </footer>
            {{Form::close()}}
        </div>
    </div>
@stop