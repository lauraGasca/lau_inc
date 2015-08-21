@section('titulo')
    IncubaM&aacute;s | Usuarios
@stop

@section('usuarios')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Usuarios</li>
@stop

@section('titulo-seccion')
    <h1>Usuarios
        <small> Listado</small>
    </h1>
@stop

@section('css')
    @parent
    {{HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js')}}
    {{HTML::script('Orb/js/app.js')}}
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    <div class="powerwidget" id="forms-9" data-widget-editbutton="false" ng-app="IncubaApp">
        <div class="inner-spacer" ng-controller="SearchCtrl">
            <div class="row">
                <div class="col-md-3">
                    {{HTML::link('usuarios/crear','Nuevo Usuario',array('class'=>'btn btn-primary'))}}<br/><br/>
                </div>
            </div>
            <br/>
            <div class="row">
                <ul class="thumbnails" >
                    <div>
                        @if(count($asesores)>0)
                            @foreach($asesores as $asesor)
                                <li class="col-md-3 col-sm-6">
                                    <div class="thumbnail">
                                        <div class='hover-fader'>
                                            {{ HTML::image('Orb/images/emprendedores/'.$asesor->foto, $asesor->nombre." ".$asesor->apellidos, ['style'=>"width:100%; height: 100%;"]) }}
                                        </div>
                                        <div class="caption">
                                            <span class="label @if($asesor->active==1) label-success @else label-dark @endif ">
                                                @if($asesor->active==1) Activo @else Inactivo @endif
                                            </span>
                                            <br/><br/>
                                            <p class="small">
                                                {{substr (strip_tags($asesor->nombre." ".$asesor->apellidos), 0, 20)}}
                                                |{{$asesor->user}}<br/>
                                                <i class="fa fa-envelope"> @if($asesor->email<>"") {{$asesor->email}} @else No dispobible @endif </i><br/>
                                                {{$asesor->puesto}} | {{$asesor->tipos->nombre}}
                                            </p>
                                            <div class="btn-group">
                                                <div class="btn-group btn-group-xs">
                                                    <a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('usuarios/delete/'.$asesor->id)}}" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Eliminar</a>
                                                </div>
                                                <div class="btn-group btn-group-xs">
                                                    <a href="{{url('usuarios/editar-user/'.$asesor->id)}}" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Modificar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="col-md-12" style="font-style: italic;">
                                No se encontraron resultados
                            </li>
                        @endif
                    </div>
                </ul>
            </div>
        </div>
    </div>
@stop  