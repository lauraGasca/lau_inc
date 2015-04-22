@section('titulo')
    IncubaM&aacute;s | Registro
@stop

@section('css')
    @parent
    {{ HTML::style('pixit/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
    {{ HTML::style('pixit/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::script('pixit/bower_components/moment/min/moment.min.js') }}
    {{ HTML::script('pixit/bower_components/moment/locale/es.js') }}
@stop

@section('imagen')
    {{ HTML::image('pixit/images/register-icon.png','Usuario') }}
@stop

@section('contenido')
    <!-- Start Error box -->
    @if(Session::get('confirm'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>¡Registrado exitosamente!</h4>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>¡Error!</h4>
            Revise los datos del formulario
        </div>
    @endif
    <!-- End Error box -->
    {{Form::open(array('url'=>'sistema/registrar','method'=>'post'))}}
        {{Form::text('nombre', '',['placeholder'=>'Nombre(s)','class'=>'input-field'])}}
        <label class="error" for="nombre">{{$errors->first('nombre')}}</label>
        {{Form::text('apellidos', '',['placeholder'=>'Apellidos','class'=>'input-field'])}}
        <label class="error" for="apellidos">{{$errors->first('apellidos')}}</label>
        {{Form::text('user', '',['placeholder'=>'Nombre de usuario','class'=>'input-field'])}}
        <label class="error" for="user">{{$errors->first('user')}}</label>
        {{Form::email('email', '',['placeholder'=>'Email','class'=>'input-field'])}}
        <label class="error" for="email">{{$errors->first('email')}}</label>
        {{Form::text('fecha_nacimiento', '',['placeholder'=>'Fecha de Nacimiento','class'=>'input-field', 'id'=>'fec_nac'])}}
        <label class="error" for="fecha_nacimiento">{{$errors->first('fecha_nacimiento')}}</label>
        <label class="checkbox">
            {{Form::checkbox('acepto', true, false)}} {{HTML::link('sistema/olvidar', 'Acepto los Terminos y Condiciones', ['style'=>'color: #FFFFFF;'])}}
        </label>
        <label class="error" for="acepto">{{$errors->first('acepto')}}</label>
        <button type="submit" class="btn btn-login">Registrar</button>
    {{Form::close()}}
    <div class="login-links">
        {{HTML::link('sistema/olvidar', '¿Olvidaste tu contrase&ntilde;a?')}}
        <br>
        ¿Ya tienes una cuenta?<strong> {{HTML::link('sistema', 'Inicia Sesi&oacute;n')}}</strong>
    </div>
@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        $(function () {
            $('#fec_nac').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate:'1/1/1940',
                defaultDate:'1/1/1980',
                maxDate: '1/1/2000'
            });
        });
    </script>
    {{ HTML::script('pixit/bower_components/jquery/dist/jquery.min.js') }}
    {{ HTML::script('pixit/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
    {{ HTML::script('pixit/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}
@stop
