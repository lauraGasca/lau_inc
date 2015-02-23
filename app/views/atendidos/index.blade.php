@section('titulo')
    Incubamas | Emprendedores
@stop

@section('atendidos')
    class="active"
@stop

@section('css')
    @parent
    {{ HTML::script('Orb/js/jquery.maskedinput.js')}}
    <script type="text/javascript">
        $(function() {
            $("#telefono").mask("(999) 999-9999? x99999");
            $("#monto").mask("$999,999.99");
        });
    </script>
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Personas Atendidas</li>
@stop

@section('titulo-seccion')
    <h1>Personas Atendidas
        <small>Registrar</small>
    </h1>
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i>
            </button>
            {{Session::get('confirm')}}
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{ Form::open(array('url'=>'atendidos/crear', 'class'=>'orb-form','method' => 'post') )}}
            <fieldset>
                <div class="col-md-5 espacio_abajo">
                    {{Form::label('nombre_completo', '* Nombre Completo', array('class' => 'label'))}}
                    <label class="input">
                        <i class="icon-prepend fa fa-user"></i>
                        {{Form::text('nombre_completo')}}
                    </label>
                    <span class="message-error">{{$errors->first('nombre_completo')}}</span>
                </div>
                <div class="col-md-3 espacio_abajo">
                    {{Form::label('correo', 'Correo electr&oacute;nico', array('class' => 'label'))}}
                    <label class="input">
                        <i class="icon-prepend fa fa-envelope"></i>
                        {{Form::email('correo')}}
                    </label>
                    <span class="message-error">{{$errors->first('correo')}}</span>
                </div>
                <div class="col-md-3 espacio_abajo">
                    {{Form::label('telefono', '* Tel&eacute;fono Fijo', array('class' => 'label'))}}
                    <label class="input">
                        <i class="icon-prepend fa fa-phone"></i>
                        {{Form::text('telefono','',array('id'=>'telefono'))}}
                    </label>
                    <span class="message-error">{{$errors->first('telefono')}}</span>
                </div>
                <div class="col-md-11 espacio_abajo">
                    {{Form::label('direccion', 'Domicilio', array('class' => 'label'))}}
                    <label class="input">
                        <i class="icon-prepend fa fa-book"></i>
                        {{Form::text('direccion')}}
                    </label>
                    <span class="message-error">{{$errors->first('direccion')}}</span>
                </div>
                <div class="col-md-6 espacio_abajo">
                    {{Form::label('programa', 'Programa a Vincular', array('class' => 'label'))}}
                    <label class="select select-multiple">
                        {{Form::select('programa[]', $programas, "", array('multiple'))}}
                    </label>
                    <span class="message-error">{{$errors->first('programa')}}</span>
                    <div class="note">
                        <strong>
                            Nota:
                        </strong>
                        Manten precionado Ctrl para seleccionar multiples programas
                    </div>
                </div>
                <div class="col-md-5 espacio_abajo">
                    {{Form::label('monto', 'Monto a solicitar', array('class' => 'label'))}}
                    <label class="input">
                        <i class="icon-prepend fa fa-book"></i>
                        {{Form::text('monto',null,['id'=>'monto'])}}
                    </label>
                    <span class="message-error">{{$errors->first('monto')}}</span>
                </div>
                <div class="col-md-12 espacio_abajo">
                </div>
                <div class="col-md-4 espacio_abajo">
                    {{Form::checkbox('enviar', 1)}} Enviar por correo
                </div>
                <div class="col-md-3 espacio_abajo">
                    {{Form::checkbox('imprimir', 1)}} Imprimir
                </div>
                <div class="col-md-12 espacio_abajo">
                    <span class="message-error">{{$errors->first('enviar')}}</span>
                </div>
            </fieldset>
            <footer>
                <div class="col-md-6 espacio_abajo">
                    {{ Form::submit('Guardar', array('class'=>'btn btn-default')) }}
                </div>
                <div class="col-md-5 espacio_abajo" style="text-align: right;">
                    * Los campos son obligatorios
                </div>
            </footer>
            {{Form::close()}}
        </div>
    </div>
@stop