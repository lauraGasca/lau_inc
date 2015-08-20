@section('titulo')
    IncubaM&aacute;s | Convocatorias
@stop

@section('convocatorias')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Convocatorias</li>
@stop

@section('titulo-seccion')
    <h1>Convocatorias<small> Listado</small></h1>
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    <div class="powerwidget powerwidget-as-portlet-white" id="darkportletdarktable" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="row">
                <div class="col-md-2">
                    {{HTML::link('convocatorias/crear','Nuevo Registro', ['class'=>'btn btn-primary'])}}<br/><br/>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-th-block table-hover">
                    <thead>
                    <tr>
                        <th style="width: 30%;">Nombre</th>
                        <th style="width: 50%; text-align: center;">Obetivo</th>
                        <th style="width: 10%; text-align: center;">Estatus</th>
                        <th style="width: 10%;" colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($convocatorias as $convocatoria)
                        <tr>
                            <td>
                                <img src="{{url('Orb/images/convocatorias/'.$convocatoria->imagen)}}" alt="slider" style="width:100px; display: inline;">
                                {{$convocatoria->nombre}}
                            </td>
                            <td>
                                {{$convocatoria->descripcion}}
                            </td>
                            @if($convocatoria->estatus==1)
                                <td style="color: green; text-align: center;">
                                    <i class="fa fa-check"></i> Activo
                                </td>
                            @else
                                <td style="color: red; text-align: center;">
                                    <i class="fa fa-times"></i> Inactivo
                                </td>
                            @endif
                            <td>
                                <a href="{{url('convocatorias/update/'.$convocatoria->id)}}" style="color: #666666;">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{url('convocatorias/delete/'.$convocatoria->id)}}" style="color: #666666;" onclick="return confirm('\u00BFSeguro que deseas eliminar?');" >
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$convocatorias->links();}}
            </div>
        </div>
    </div>
@stop  