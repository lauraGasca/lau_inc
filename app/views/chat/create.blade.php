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
            {{Form::open(['url'=>'mensajes/crear', 'class'=>'orb-form','method' => 'post'])}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('para', '* Tipo de usuario', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('para', [null=>'Selecciona', 1=>'Emprendedor', 2=>'Asesor'], null, ['id'=>'para'])}}
                        </label>
                        <span class="message-error">{{$errors->first('para')}}</span>
                    </div>
                    <div class="col-md-5 espacio_abajo" id="divEmprendedor" @if(!$errors->first('emprendedor')) style="visibility: hidden" @endif >
                        {{Form::label('emprendedor', '* Emprendedor', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('emprendedor', [null=>'Selecciona']+ $emprendedores, null, ['id'=>'emprendedor'])}}
                        </label>
                        <span class="message-error">{{$errors->first('emprendedor')}}</span>
                    </div>
                    <div class="col-md-6 espacio_abajo" id="divAsesor" @if(!$errors->first('asesor')) style="visibility: hidden" @endif >
                        {{Form::label('asesor', '* Asesor', array('class' => 'label'))}}
                        <label class="select">
                            {{Form::select('asesor[]', $asesores, null, ['id'=>'asesor','data-placeholder'=>"Selecciona", 'class'=>"chosen-select-width", 'multiple'])}}
                        </label>
                        <span class="message-error">{{$errors->first('asesor')}}</span>
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
        $( "#para" ).change(function() {
            switch($( "#para" ).val())
            {
                case '1':
                    $("#divEmprendedor").css('visibility', 'visible');
                    $("#divAsesor").css('visibility', 'hidden');
                    break;
                case '2':
                    $("#divAsesor").css('visibility', 'visible');
                    $("#divEmprendedor").css('visibility', 'hidden');
                    break;
                default:
                    $("#divEmprendedor").css('visibility', 'hidden');
                    $("#divAsesor").css('visibility', 'hidden');
            }
        });
    </script>
@stop