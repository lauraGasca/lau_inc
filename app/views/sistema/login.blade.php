@extends('layouts.auth')

@section('formulario')
    {{ Form::open(array('url'=>'sistema/login', 'class'=>'orb-form','method' => 'post') )}}
        <header>
            <div class="image-block">
                <img src="{{ URL::asset('Orb/images/logo.png') }}" alt="Logo" />
            </div>
            Acceder a IncubaM&aacute;s
        </header>
        @if(Session::get('login_errors'))
            <div class="breadcrumb clearfix">
                <span class="message-error">Nombre de usuario y/o contrase&ntilde;a invalidos</span>
            </div>
        @endif
        @if(Session::get('confirm'))
            <div class="breadcrumb clearfix">
                <span class="message-error">{{Session::get('confirm')}}</span>
            </div>
        @endif
        <fieldset>
            <section>
                <div class="row">
                    {{Form::label('user', 'Usuario', array('class' => 'label col col-4'))}}
                    <div class="col col-8">
                        <label class="input"> <i class="icon-append fa fa-user"></i>
                            {{Form::text('user')}}
                        </label>
                        <span class="message-error">{{$errors->first('user')}}</span>
                    </div>
                    
                </div>
            </section>
            <section>
                <div class="row">
                    {{Form::label('pass', 'Contrase&ntilde;a', array('class' => 'label col col-4'))}}
                    <div class="col col-8">
                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                            {{Form::password('password')}}
                        </label>
                        <span class="message-error">{{$errors->first('password')}}</span>
                        <!--<div class="note">
                            <a href="#">Olvidaste tu contrase&ntilde;a?</a>
                        </div>-->
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col col-4"></div>
                    <div class="col col-8">
                        <label class="checkbox">
                            {{Form::checkbox('remember')}}
                            <i></i>Mantener la sesi&oacute;n iniciada
                        </label>
                    </div>
                </div>
            </section>
        </fieldset>
        <footer>
            {{ Form::submit('Iniciar sesi&oacute;n', array('class'=>'btn btn-default')) }}
        </footer>
    {{Form::close()}}
@stop
                    