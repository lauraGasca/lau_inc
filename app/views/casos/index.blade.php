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
  <h1>Casos de &Eacute;xito<small> Listado</small></h1>
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
  <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
    <div class="inner-spacer">
      <div id="items" class="items-switcher items-view-grid">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              {{ Form::open(array('url'=>'casos/busqueda', 'method' => 'POST') )}}
                <span class="input-group-btn">
                  {{Form::text('buscar', null, array('class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead'))}}
                  {{ Form::submit('Ir!', array('class'=>'btn btn-default')) }}
                </span>
                <span class="message-error">{{$errors->first('buscar')}}</span><br/><br/>
              {{Form::close()}}
            </div>
          </div>
          <div class="col-md-2">
            {{HTML::link('casos','Todos los Registros',array('class'=>'btn btn-default'))}}
          </div>
          <div class="col-md-2">
            {{HTML::link('casos/crear','Nuevo Registro',array('class'=>'btn btn-default'))}}
          </div>
          <div class="col-md-2" style="text-align: right;">
            <a href="#Servicios" role="button" data-target="#Servicios" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit">Servicios</i></a>
          </div>
          <div class="col-md-2 items-options">
            <a href="#" class="items-icon items-grid items-selected" data-view="items-view-grid">Cuadricula</a>
            <a href="#" class="items-icon items-list" data-view="items-view-list">Lista</a>
          </div>
        </div>
        @if(count($casos) > 0)
          <ul>
            @foreach($casos as $caso)
              <li>
                <div class="items-inner clearfix">
                  <a class="items-image" href="#">
                    <img height="10%" src="{{ URL::asset('Orb/images/casos_exito/'.$caso->imagen) }}">
                  </a>
                  <h3 class="items-title">{{$caso->nombre_proyecto}}</h3>
                  <span class="label label-success">{{$caso->categoria}}</span>
                  <?php $date = date_create($caso->created_at);
                    $fecha=date_format($date, 'd-m-Y');?>
                  <div class="items-details"><strong>Registrado:</strong> {{$fecha}}</div>
                  <div class="control-buttons">
                    <a href="{{url('casos/delete/'.$caso->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');" title="Eliminar"><i class="fa fa-times-circle"></i></a>
                    <a href="{{url('casos/editar/'.$caso->id)}}" title="Modify"><i class="fa fa-cog"></i></a>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        @else
            No hay ningun Casos de &Eacute;xito registrado
        @endif
      </div>
      {{$casos->links();}}
    </div>
  </div>
    <!-------Servicios------->
  <div id="Servicios" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Servicios</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(array('url'=>'casos/crearservicio', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
            <fieldset>
              {{Form::label('nombre', 'Servicios', array('class' => 'label'))}}
              <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    @if(count($servicios_all) > 0)
                      @foreach($servicios_all as $servicio)
                        <tr>
                          <td>{{$servicio->nombre}}</td>
                          <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('casos/deleteservicio/'.$servicio->id)}}" ><i class="fa fa-trash-o"></i></a>
                        </tr>
                      @endforeach
                    @endif 
                  </tbody>
                </table>
              </div>
            </fieldset>
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('nombre', '* Servicio', array('class' => 'label'))}}
                <label class="input">
                  <i class="icon-prepend fa fa-cube"></i>
                  {{Form::text('nombre')}}
                </label>
                * Los campos son obligatorios
                <span class="message-error">{{$errors->first('nombre')}}</span>
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