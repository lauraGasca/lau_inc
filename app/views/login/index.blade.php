@section('titulo')
    IncubaM&aacute;s | Iniciar Sesi&oacute;n
@stop

@section('imagen')
    {{ HTML::image('pixit/images/user-icon.png','Usuario') }}
@stop

@section('contenido')
    <!-- BEGIN ERROR BOX -->
    @if(Session::has('login_errors'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>¡Error!</h4>
            Nombre de usuario y/o contrase&ntilde;a incorrectos
        </div>
    @endif
    @if(Session::get('confirm'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>¡Error!</h4>
            {{Session::get('confirm')}}
        </div>
    @endif
    <!-- END ERROR BOX -->
    {{Form::open(array('url'=>'sistema/login','method'=>'post'))}}
        {{Form::text('user', '',['placeholder'=>'Nombre de usuario','class'=>'input-field form-control user'])}}
        <br/>
        {{Form::password('password', ['placeholder'=>'Contraseña','class'=>'input-field form-control password'])}}
        <br/>
        <label class="checkbox">
            {{Form::checkbox('remember', true, false)}} Mantener la sesi&oacute;n iniciada
        </label>
        <button type="submit" class="btn btn-login">Ingresar</button>
    {{Form::close()}}
    <div class="login-links">
        {{HTML::link('sistema/olvidar', '¿Olvidaste tu contrase&ntilde;a?')}}
        <br>
        ¿No tienes cuenta?<strong> {{HTML::link('sistema/registrar', 'Registrate')}}</strong>
    </div>                       
@stop

@section('redes')
    <div class="social-login row">
        <div class="fb-login col-lg-12 col-md-12 animated flipInX">
            <a onclick="ventanaFB()" href="#" class="btn btn-facebook btn-block"><i class="fa fa-facebook"></i> | Conectar con <strong>Facebook</strong></a>
        </div>
    </div>
    <script>
        var miPopup
        function ventanaFB(){
            miPopup = window.open("{{url("sistema/fblogin")}}","miwin","width=600,height=400,scrollbars=yes")
            miPopup.focus()
        }
    </script>
@stop
