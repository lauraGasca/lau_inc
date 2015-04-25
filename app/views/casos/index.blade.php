@section('titulo')
    IncubaM&aacute;s | Casos de &Eacute;xito
@stop

@section('casos')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Casos de &Eacute;xito</li>
@stop

@section('titulo-seccion')
    <h1>Casos de &Eacute;xito
        <small> Listado</small>
    </h1>
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if($errors->first('buscar'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div id="items" class="items-switcher items-view-grid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            {{Form::open(['url'=>'casos/busqueda', 'method' => 'POST'])}}
                                <span class="input-group-btn">
                                    {{Form::text('buscar', null, ['class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead'])}}
                                    {{Form::submit('Ir!', ['class'=>'btn btn-default']) }}
                                </span>
                                <span style="color: rgb(202, 16, 16);">{{$errors->first('buscar')}}</span><br/><br/>
                            {{Form::close()}}
                        </div>
                    </div>
                    <div class="col-md-2">
                        {{HTML::link('casos','Todos los Registros', ['class'=>'btn btn-default'])}}
                    </div>
                    <div class="col-md-2">
                        {{HTML::link('casos/crear','Nuevo Registro', ['class'=>'btn btn-default'])}}
                    </div>
                    <div class="col-md-2" style="text-align: right;">
                        <a href="#Servicios" role="button" data-target="#Servicios" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit">Servicios</i></a>
                    </div>
                    <div class="col-md-2 items-options">
                        {{HTML::link('#','Cuadricula', ['class'=>"items-icon items-grid items-selected", 'data-view'=>"items-view-grid"])}}
                        {{HTML::link('#','Lista', ['class'=>"items-icon items-list", 'data-view'=>"items-view-list"])}}
                    </div>
                </div>
                <ul>
                    @if($parametro<>'')
                        <span style="color: rgb(192, 194, 199); width: 100%;  text-align: left;  float: left;">
                            Resultados para "{{$parametro}}"
                        </span><br/><br/>
                    @endif
                    @if(count($casos) > 0)
                        @foreach($casos as $caso)
                            <li>
                                <div class="items-inner clearfix">
                                    <a class="items-image" href="#">
                                        {{ HTML::image('Orb/images/casos_exito/'.$caso->imagen, $caso->nombre_proyecto, array('height' => '10%')) }}
                                    </a>
                                    <h3 class="items-title">{{$caso->nombre_proyecto}}</h3>
                                    <span class="label label-success">{{$caso->categoria}}</span>
                                    <div class="items-details"><strong>Registrado:</strong> {{$caso->creado}}</div>
                                    <div class="control-buttons">
                                        <a href="{{url('casos/delete/'.$caso->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');" title="Eliminar"><i class="fa fa-times-circle"></i></a>
                                        <a href="{{url('casos/editar/'.$caso->id)}}" title="Modificar"><i class="fa fa-cog"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <span style="font-style: italic; width: 100%; text-align: left; float: left;">
                            No se encontraron resultados
                        </span><br/><br/>
                    @endif
                </ul>
            </div>
            {{$casos->links();}}
        </div>
    </div>
    <!-------Servicios------->
    @if($errors->first('nombre')) <div class="modal-backdrop  in"></div> @endif
    <div id="Servicios" class="modal @if($errors->first('nombre')) animated fadeInLeft @endif" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @if($errors->first('nombre')) style="display: block;" @endif>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Servicios</h4>
                </div>
                <div class="modal-body">
                    {{Form::open(['url'=>'casos/crear-servicio', 'class'=>'orb-form','method' => 'post'])}}
                        <fieldset>
                            {{Form::label('nombre', 'Servicios', array('class' => 'label'))}}
                            <div class="col-md-11 espacio_abajo" style="overflow: auto; height: 200px;">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        @foreach($servicios_all as $servicio)
                                            <tr>
                                                <td>{{$servicio->nombre}}</td>
                                                <td>
                                                    <a href="{{url('casos/delete-servicio/'.$servicio->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="col-md-6 espacio_abajo">
                                @if($errors->first('nombre'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
                                        ¡Por favor, revise los datos del formulario!
                                    </div>
                                @endif
                                {{Form::label('nombre', '* Servicio', array('class' => 'label'))}}
                                    <label class="input">
                                        <i class="icon-prepend fa fa-cube"></i>
                                        {{Form::text('nombre')}}
                                        <span class="message-error">{{$errors->first('nombre')}}</span><br/>
                                    </label>
                                * Los campos son obligatorios
                            </div>
                            <div class="col-md-5 espacio_abajo" style="padding-top: 30px;">
                                <button class="btn btn-primary">A&ntilde;adir</button>
                            </div>
                        </fieldset>
                    {{Form::close()}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop  