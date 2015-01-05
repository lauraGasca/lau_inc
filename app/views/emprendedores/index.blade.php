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
  <h1>Emprendedores<small> Listado</small></h1>
@stop

@section('contenido')
  <!-- New widget -->
  <div class="powerwidget" id="forms-9" data-widget-editbutton="false">
    <div class="inner-spacer">
      <div class="row">
        <div class="col-md-6">
          <div class="input-group">
            {{ Form::open(array('url'=>'emprendedores/busqueda', 'method' => 'post') )}}
              {{Form::text('buscar', null, array('class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead'))}}
              <span class="input-group-btn">
                {{ Form::submit('Ir!', array('class'=>'btn btn-default')) }}
              </span>
              <span class="message-error">{{$errors->first('buscar')}}</span>
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
      @if(Session::get('confirm'))
        <div class="row">
          <div class="col-md-12">
            <div class="breadcrumb clearfix">
              {{Session::get('confirm')}}
            </div>
          </div>
        </div>
      @endif
      <br/>
      <div class="row">
        <ul class="thumbnails">
          @if(count($emprendedores) > 0)
            @foreach($emprendedores as $emprendedor)
              <li class="col-md-3 col-sm-6">
                <div class="thumbnail" >
                  <div class='hover-fader'>
                    <a href="{{url('emprendedores/perfil/'.$emprendedor->id)}}">
                      <img class="img-rounded img-responsive" src="{{URL::asset('Orb/images/emprendedores/'.$emprendedor->imagen)}}" alt="Emprendedor" style="width:100%; height: 100%;">
                      <span class='zoom'>
                        @if($emprendedor->logo<>"")
                          <img valign="middle" src="{{URL::asset('Orb/images/empresas/'.$emprendedor->logo)}}" alt="Logo" style="width:100%; height: 100%;"/>
                        @endif
                      </span>
                    </a>
                  </div>
                  <div class="caption">
                    @if($emprendedor->estatus=="Activo")
                      <span class="label label-success">Activo</span>
                      @else
                        @if($emprendedor->estatus=="Suspendido")
                          <span class="label label-warning">Suspendido</span>
                        @else
                          @if($emprendedor->estatus=="Cancelado")
                            <span class="label label-danger">Cancelado</span>
                          @endif
                        @endif
                    @endif
                    <br/><br/>
                    <p class="small">
                      {{substr (strip_tags($emprendedor->name." ".$emprendedor->apellidos), 0, 25)}} | 
                      <?php
                        $date = date_create($emprendedor->fecha_ingreso);
                        $fecha=date_format($date, 'd-m-Y');
                      ?>
                      {{$fecha}}<br/>
                      @if($emprendedor->email<>"")
                        <i class="fa fa-envelope"> {{$emprendedor->email}}</i><br/>
                      @else
                        <i class="fa fa-envelope"> No dispobible</i><br/>
                      @endif
                      @if($emprendedor->tel_fijo<>"")
                        <i class="fa fa-phone"> {{$emprendedor->tel_fijo}}</i>
                      @else
                        <i class="fa fa-phone"> No disponible</i>
                      @endif
                      | @if($emprendedor->tel_movil<>"")
                        <i class="fa fa-mobile"> {{$emprendedor->tel_movil}}</i>
                      @else
                        <i class="fa fa-mobile"> No dispobible</i>
                      @endif
                    </p>
                    <div class="btn-group">
                      <div class="btn-group btn-group-xs">
                        <a href="{{url('emprendedores/pagos/'.$emprendedor->id)}}" type="button" class="btn btn-default"><i class="fa fa-money"></i> Pagos</a>
                      </div>
                      <div class="btn-group btn-group-xs">
                        <a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('emprendedores/delete/'.$emprendedor->id)}}" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Eliminar</a>
                      </div>
                      <div class="btn-group btn-group-xs">
                        <a href="{{url('emprendedores/editar/'.$emprendedor->id)}}" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Modificar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            @endforeach
          @else
            <li class="col-md-3 col-sm-6">
              No hay ningun emprendedor registrado
            </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
  <!-- End Widget --> 
@stop  