@section('titulo')
    IncubaM&aacute;s | Modelo de Negocio
@stop

@section('proyecto')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li><a href="{{url('plan-negocios')}}">Modelo de Negocio</a></li>
    <li class="active">{{$modulo->nombre}}</li>
@stop

@section('titulo-seccion')
    <h1>Modulo<small> Preguntas</small></h1>
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
                    {{HTML::link('plan-negocios/crear-pregunta/'.$modulo->id,'+ Nueva Pregunta', ['class'=>'btn btn-primary'])}}<br/><br/>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="50%" colspan="2">Pregunta</th>
                    <th width="15%" class="text-center">Archivo</th>
                    <th width="15%" class="text-center">Texto</th>
                    <th width="20%" colspan="2" class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($modulo->preguntas as $pregunta)
                        <tr>
                            <td width="5%"><span class="num">{{$pregunta->orden}}</span></td>
                            <td><h5><a href="{{url('plan-negocios/pregunta/'.$pregunta->id)}}">{{$pregunta->pregunta}}</a></h5></td>
                            <td class="text-center"> @if($pregunta->archive==0) No @else Si @endif </td>
                            <td class="text-center"> @if($pregunta->texto==0) No @else Si @endif </td>
                            <td class="text-center">
                                <a class="editar" title="Editar" href="{{URL('plan-negocios/editar-pregunta/'.$pregunta->id)}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="eliminar" title="Eliminar" href="{{URL('plan-negocios/delete-pregunta/'.$pregunta->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">Pregunta</th>
                    <th>Archivo</th>
                    <th>Texto</th>
                    <th colspan="2">Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop  