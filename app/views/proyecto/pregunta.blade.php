@section('titulo')
    IncubaM&aacute;s | Modelo de Negocio
@stop

@section('proyecto')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li><a href="{{url('plan-negocios')}}">Modelo de Negocio</a></li>
    <li><a href="{{url('plan-negocios/modulo/'.$pregunta->modulo_id)}}">{{$pregunta->modulo->nombre}}</a></li>
    <li class="active">{{$pregunta->pregunta}}</li>
@stop

@section('titulo-seccion')
    <h1>Pregunta<small> Ejemplos</small></h1>
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
    <div class="powerwidget powerwidget-as-portlet-white" id="darkportletdarktable" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="row">
                <div class="col-md-2">
                    {{HTML::link('plan-negocios/crear-ejemplo/'.$pregunta->id,'+ Nuevo Ejemplo', ['class'=>'btn btn-primary'])}}<br/><br/>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="90%" >Ejemplo</th>
                    <th width="10%" colspan="2" class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($pregunta->ejemplos as $ejemplo)
                        <tr>
                            <td>{{$ejemplo->texto}}</td>
                            <td class="text-center">
                                <a title="Editar" href="{{URL('plan-negocios/editar-ejemplo/'.$ejemplo->id)}}">
                                    <i class="fa fa-cog"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a title="Eliminar" href="{{URL('plan-negocios/delete-ejemplo/'.$ejemplo->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Ejemplo</th>
                    <th colspan="2">Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop  