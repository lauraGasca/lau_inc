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
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb clearfix">
                    {{Session::get('confirm')}}
                </div>
            </div>
        </div>
    @endif
    @if(count($errors)>0)
        <script>
            alert("¡Por favor, revise los datos del formulario!");
        </script>
        @endif
                <!-- New widget -->
        <div class="powerwidget powerwidget-as-portlet-white" id="darkportletdarktable" data-widget-editbutton="false">
            <div class="inner-spacer">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            {{ Form::open(array('url'=>'atendidos/busqueda', 'method' => 'post') )}}
                            <span class="input-group-btn">
                                {{Form::text('buscar', null, array('class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead'))}}
                                {{ Form::submit('Ir!', array('class'=>'btn btn-default')) }}
                            </span>
                            <span class="message-error">{{$errors->first('buscar')}}</span>
                            {{Form::close()}}
                        </div>
                    </div>
                    <div class="col-md-5">
                        {{HTML::link('atendidos/crear','Nuevo Registro',array('class'=>'btn btn-default'))}}
                    </div>
                </div>
                <br/>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="15%">Nombre</th>
                        <th width="15%">Correo</th>
                        <th width="15%">Telefono</th>
                        <th width="55%">Direcci&oacute;n</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($atendidos) > 0)
                        @foreach($atendidos as $atendido)
                            <tr>
                                <td>{{$atendido->nombre_completo}}</td>
                                <td>{{$atendido->correo}}</td>
                                <td>{{$atendido->telefono}}</td>
                                <td>{{$atendido->direccion}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="4">No hay ninguna entrada registrada</th>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Direcci&oacute;n</th>
                    </tr>
                    </tfoot>
                </table>
                {{$atendidos->links();}}
            </div>
        </div>
        <!-- /New widget -->
@stop  