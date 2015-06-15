@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    @if($procede==1)
        <li>{{HTML::link('emprendedores/perfil/'.$emprendedor_id,'Perfil')}}</li>
    @else
        <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
        <li>{{HTML::link('emprendedores/editar/'.$emprendedor_id,'Emprendedor')}}</li>
    @endif
    <li class="active">Editar</li>
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
@stop

@section('titulo-seccion')
    <h1>Documentos
        <small>Subir</small>
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
            {{Form::open(['url'=>'emprendedores/subir-documento', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('emprendedor_id',$emprendedor_id)}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('documento_id', '* Documento', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('documento_id', [null=>'Selecciona']+$documentos, null, ['id'=>'selecDocumento'])}}
                            <span class="message-error">{{$errors->first('documento_id')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo" id="otroDocumento" @if(!$errors->first('nombre')) style="visibility: hidden" @endif >
                        {{Form::label('nombre', 'Especifica el otro documento', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-archive"></i>
                            {{Form::text('nombre','', ['id'=>'otro'])}}
                            <span class="message-error">{{$errors->first('nombre')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('pertenece', '* ¿A quien pertenece el documento?', ['class' => 'label'])}}
                        <label class="select">
                            @if(count($empresas_listado) > 0 && count($socios_listado) > 0)
                                {{Form::select('pertenece', [null=>'Selecciona', 1=> 'Emprendedor', 2=>'Empresa', 3=>'Socio'], null, ['id'=>'pertenece'])}}
                            @else
                                @if(count($empresas_listado) > 0)
                                    {{Form::select('pertenece', [null=>'Selecciona', 1=> 'Emprendedor', 2=>'Empresa'], null, ['id'=>'pertenece'])}}
                                @else
                                    @if(count($socios_listado) > 0)
                                        {{Form::select('pertenece', [null=>'Selecciona', 1=> 'Emprendedor', 3=>'Socio'], null, ['id'=>'pertenece'])}}
                                    @else
                                        {{Form::select('pertenece', [1=> 'Emprendedor'], null, ['id'=>'pertenece'])}}
                                    @endif
                                @endif
                            @endif
                            <span class="message-error">{{$errors->first('pertenece')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo" id="divEmpresa" @if(!$errors->first('empresa_id')) style="visibility: hidden" @endif >
                        {{Form::label('empresa_id', '* Empresa', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('empresa_id', [null=>'Selecciona']+$empresas_listado)}}
                            <span class="message-error">{{$errors->first('empresa_id')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo" id="divSocio" @if(!$errors->first('socio_id')) style="visibility: hidden" @endif >
                        {{Form::label('socio_id', '* Socio', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('socio_id', [null=>'Selecciona']+$socios_listado)}}
                            <span class="message-error">{{$errors->first('socio_id')}}</span>
                        </label>
                    </div>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('documento', '* Documento a subir', ['class' => 'label'])}}
                        {{Form::file('documento', ['id'=>'documento'])}}
                        <br/><br/><span class="message-error" style="font-weight: bold">{{$errors->first('documento')}}</span>
                        <script>
                            $("#documento").fileinput({
                                browseLabel: " Documento a subir ",
                                showCaption: false,
                                removeClass: "btn btn-danger",
                                removeLabel: "Borrar",
                                removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                                showUpload: false
                            });
                        </script>
                    </div>
                    <div class="col-md-11 espacio_abajo" style="text-align: left;">
                        * Los campos son obligatorios
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Subir', ['class'=>'btn btn-info'])}}
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
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    <script type="text/javascript">
        $( "#selecDocumento" ).change(function() {
            if ($( "#selecDocumento" ).val() == 20)
                $("#otroDocumento").css('visibility', 'visible');
            else {
                $("#otroDocumento").css('visibility', 'hidden');
                $("#otro").val('');
            }
        });
        $( "#pertenece" ).change(function() {
            switch($( "#pertenece" ).val())
            {
                case '1':
                    $("#divSocio").css('visibility', 'hidden');
                    $("#divEmpresa").css('visibility', 'hidden');
                    $("#empresa_id").val('');
                    $("#socio_id").val('');
                    break;
                case '2':
                    $("#divSocio").css('visibility', 'hidden');
                    $("#socio_id").val('');
                    $("#divEmpresa").css('visibility', 'visible');
                    break;
                case '3':
                    $("#divSocio").css('visibility', 'visible');
                    $("#divEmpresa").css('visibility', 'hidden');
                    $("#empresa_id").val('');
                    break;
                default:
                    $("#divSocio").css('visibility', 'hidden');
                    $("#divEmpresa").css('visibility', 'hidden');
                    $("#empresa_id").val('');
                    $("#socio_id").val('');
                    break;
            }
        });
    </script>
@stop