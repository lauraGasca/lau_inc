@section('titulo')
    Incubamas | Emprendedores
@stop

@section('atendidos')
    class="active"
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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget powerwidget-as-portlet-white" id="darkportletdarktable" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="row">
                <div class="col-md-2">
                    {{HTML::link('atendidos/crear','+ Nuevo Registro',array('class'=>'btn btn-primary'))}}<br/>
                </div>
                <div class="col-md-2">
                    {{HTML::link('atendidos/excel','Exportar a Excel',array('class'=>'btn btn-success', 'target'=>"subir_archivo"))}}<br/>
                </div>
            </div>
            <br/>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="40%">Nombre</th>
                    <th width="25%">Correo</th>
                    <th width="20%">Telefono</th>
                    <th colspan="2" width="15%" class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @if(count($atendidos) > 0)
                    @foreach($atendidos as $atendido)
                        <tr>
                            <td>{{$atendido->nombre_completo}}</td>
                            <td>{{$atendido->correo}}</td>
                            <td>{{$atendido->telefono}}</td>
                            <td class="text-center">
                                <a  class="editar" title="Editar" href="{{URL('atendidos/editar/'.$atendido->id)}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="eliminar" title="Eliminar" href="{{URL('atendidos/delete/'.$atendido->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="5">No hay ninguna entrada registrada</th>
                    </tr>
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th colspan="2">Acciones</th>
                </tr>
                </tfoot>
            </table>
            {{$atendidos->links();}}
        </div>
    </div>
    <iframe width="1" height="1" frameborder="0" name="subir_archivo" style="display: none"></iframe>
@stop