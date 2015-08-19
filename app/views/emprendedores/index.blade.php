@section('titulo')
    IncubaM&aacute;s | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Emprendedores</li>
@stop

@section('titulo-seccion')
    <h1>Emprendedores
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
    @if($errors->first('buscar'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget" id="forms-9" data-widget-editbutton="false" ng-app="IncubaApp">
        <div class="inner-spacer" ng-controller="SearchCtrl">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        {{ Form::open(array('url'=>'emprendedores/busqueda', 'method' => 'post') )}}
                            <span class="input-group-btn">
                                {{Form::text('buscar', null, array('class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead', 'ng-change'=>'search()', 'ng-model'=>'searchInput'))}}
                                {{ Form::submit('Ir!', array('class'=>'btn btn-default')) }}
                            </span>
                            <span style="color: rgb(202, 16, 16);">{{$errors->first('buscar')}}</span><br/><br/>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="col-md-3">
                    {{HTML::link('emprendedores','Todos los Registros',array('class'=>'btn btn-default'))}}
                </div>
                <div class="col-md-3">
                    {{HTML::link('emprendedores/crear','Nuevo Registro',array('class'=>'btn btn-default'))}}
                </div>
            </div>
            <br/>
            <div class="row">
                <ul class="thumbnails" >
                    <div ng-show='mostrar'>
                        <li class="col-md-12" style="color: rgb(192, 194, 199);">
                            Resultados para "@{{ searchInput}}"
                        </li>
                        <li class="col-md-3 col-sm-6" ng-repeat="emprendedor in emprendedores">
                            <div class="thumbnail">
                                <div class='hover-fader'>
                                    <a href="{{url('emprendedores/perfil/')}}/@{{ emprendedor.id }}">
                                        <img src="{{url('Orb/images/emprendedores/')}}/@{{ emprendedor.usuario.foto }}" alt="@{{ emprendedor.usuario.nombre }} @{{ emprendedor.usuario.apellidos }}" style="width:100%; height: 100%;">
                                        <span class='zoom'>
                                            <img ng-repeat="empresa in emprendedor.empresas" ng-show="$last" src="{{url('Orb/images/empresas/')}}/@{{ empresa.logo }}" alt="@{{ empresa.nombre_empresa }}" style="width:100%; height: 100%;">
                                        </span>
                                    </a>
                                </div>
                                <div class="caption">
                                    <span class="label label-success" ng-if="emprendedor.estatus=='Activo'">@{{ emprendedor.estatus }}</span>
                                    <span class="label label-warning" ng-if="emprendedor.estatus=='Suspendido'">@{{ emprendedor.estatus }}</span>
                                    <span class="label label-danger" ng-if="emprendedor.estatus=='Cancelado'">@{{ emprendedor.estatus }}</span>
                                    <span class="label label-dark" ng-if="emprendedor.estatus=='Inactivo'">@{{ emprendedor.estatus }}</span>
                                    <br/><br/>
                                    <p class="small">
                                        @{{(emprendedor.usuario.nombre + " " +emprendedor.usuario.apellidos).substring(0, 20)}}| @{{emprendedor.ingreso}}<br/>
                                        <i class="fa fa-envelope" ng-if="emprendedor.usuario.email"> @{{emprendedor.usuario.email}} </i>
                                        <i class="fa fa-envelope" ng-if="!emprendedor.usuario.email"> No dispobible </i><br/>
                                        <i class="fa fa-phone" ng-if="emprendedor.tel_fijo"> @{{emprendedor.tel_fijo}}</i>
                                        <i class="fa fa-phone" ng-if="!emprendedor.tel_fijo"> No dispobible </i>
                                        | <i class="fa fa-mobile" ng-if="emprendedor.tel_movil"> @{{emprendedor.tel_movil}}</i>
                                        <i class="fa fa-mobile" ng-if="!emprendedor.tel_movil"> No dispobible </i>
                                    </p>
                                    <div class="btn-group">
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{url('pagos/index/')}}/@{{ emprendedor.id }}" type="button" class="btn btn-default"><i class="fa fa-money"></i> Pagos</a>
                                        </div>
                                        <div class="btn-group btn-group-xs">
                                            <a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/delete/')}}/@{{ emprendedor.usuario.id }}" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Eliminar</a>
                                        </div>
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{url('emprendedores/editar/')}}/@{{ emprendedor.id }}" type="button" class="btn btn-default"><i class="fa fa-pencil"></i>Modificar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                    <div ng-hide='mostrar'>
                        @if($parametro<>'')
                            <li class="col-md-12" style="color: rgb(192, 194, 199);">
                                Resultados para "{{$parametro}}"
                            </li>
                        @endif
                        @if(count($emprendedores)>0)
                            @foreach($emprendedores as $emprendedor)
                                <li class="col-md-3 col-sm-6">
                                    <div class="thumbnail">
                                        <div class='hover-fader'>
                                            <a href="{{url('emprendedores/perfil/'.$emprendedor->id)}}">
                                                {{ HTML::image('Orb/images/emprendedores/'.$emprendedor->usuario->foto, $emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos, ['style'=>"width:100%; height: 100%;"]) }}
                                                <span class='zoom'>
                                                    @foreach($emprendedor->empresas as $empresa)
                                                        {{ HTML::image('Orb/images/empresas/'.$empresa->logo, $empresa->nombre_empresa, ['style'=>"width:100%; height: 100%;"]) }}
                                                        <?php break; ?>
                                                    @endforeach
                                                </span>
                                            </a>
                                        </div>
                                        <div class="caption">
                                            <span class="label
                                                @if($emprendedor->estatus=="Activo") label-success
                                                @else
                                                    @if($emprendedor->estatus=="Suspendido") label-warning
                                                    @else @if($emprendedor->estatus=="Cancelado") label-danger
                                                          @else label-dark @endif
                                                    @endif
                                                @endif
                                                    ">{{$emprendedor->estatus}}
                                            </span>
                                            <br/><br/>
                                            <p class="small">
                                                {{substr (strip_tags($emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos), 0, 20)}}
                                                |{{$emprendedor->ingreso}}<br/>
                                                <i class="fa fa-envelope"> @if($emprendedor->usuario->email<>"") {{$emprendedor->usuario->email}} @else No dispobible @endif </i><br/>
                                                <i class="fa fa-phone"> @if($emprendedor->tel_fijo<>"") {{$emprendedor->tel_fijo}} @else No disponible @endif </i>
                                                | <i class="fa fa-mobile"> @if($emprendedor->tel_movil<>"") {{$emprendedor->tel_movil}} @else No dispobible @endif </i>
                                            </p>
                                            <div class="btn-group">
                                                <div class="btn-group btn-group-xs">
                                                    <a href="{{url('pagos/index/'.$emprendedor->id)}}" type="button" class="btn btn-default"><i class="fa fa-money"></i> Pagos</a>
                                                </div>
                                                <div class="btn-group btn-group-xs">
                                                    <a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/delete/'.$emprendedor->usuario->id)}}" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Eliminar</a>
                                                </div>
                                                <div class="btn-group btn-group-xs">
                                                    <a href="{{url('emprendedores/editar/'.$emprendedor->id)}}" type="button" class="btn btn-default"><i class="fa fa-pencil"></i>Modificar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <li class="col-md-12">
                                {{$emprendedores->links()}}
                            </li>
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