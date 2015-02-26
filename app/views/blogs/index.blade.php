@section('titulo')
    IncubaM&aacute;s | Entradas del Blog
@stop

@section('blog')
    class="active"
@stop

@section('mapa')
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="active">Entradas del Blog</li>
@stop

@section('titulo-seccion')
  <h1>Entradas del Blog<small> Listado</small></h1>
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
        <div class="col-md-4">
          <div class="input-group">
            {{ Form::open(array('url'=>'blog/busqueda', 'method' => 'post') )}}
              <span class="input-group-btn">
                {{Form::text('buscar', null, array('class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead'))}}
                {{ Form::submit('Ir!', array('class'=>'btn btn-default')) }}
              </span>
              <span class="message-error">{{$errors->first('buscar')}}</span>
            {{Form::close()}}
          </div>
        </div>
        <div class="col-md-2">
          {{HTML::link('blog','Todos los Registros',array('class'=>'btn btn-default'))}}
        </div>
        <div class="col-md-2">
          {{HTML::link('blog/crear','Nuevo Registro',array('class'=>'btn btn-default'))}}
        </div>
        <div class="col-md-2">
          <a href="#categorias" role="button" data-target="#categorias" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit">Categorias</i></a>
        </div>
        <div class="col-md-2">
          <a href="#tags" role="button" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit">Tags</i></a>
        </div>
      </div>
      <br/>
      <table class="table-dark table table-striped table-bordered table-hover margin-0px">
        <thead>
          <tr>
            <th width="60%" colspan="2">Entrada</th>
            <th width="10%">Creaci&oacute;n</th>
            <th width="10%">Publicaci&oacute;n</th>
            <th width="10%">Estado</th>
            <th width="10%">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if(count($blogs) > 0)
            @foreach($blogs as $blog)
              <tr>
                <td width="1%"><span class="num">{{$blog->id}}</span></td>
                <td>
                  <h5>{{$blog->titulo}}</h5>
                  <small><a target="_blank" href="{{ URL::asset('incuba/blog/'.$blog->id) }}" style="color:#FFF">{{ URL::asset('incuba/blog/'.$blog->id) }}</a></small>
                </td>
                <?php
                  $date = date_create($blog->created_at);
                  $fecha=date_format($date, 'd-m-Y');
                ?>
                <td>{{$fecha}}</td>
                <?php
                  $date = date_create($blog->fecha_publicacion);
                  $fecha=date_format($date, 'd-m-Y');
                ?>
                <td>{{$fecha}}</td>
                <?php
                  $fecha_actual = strtotime(date("d-m-Y"));
                  $date = date_create($blog->fecha_publicacion);
                  $fecha=date_format($date, 'd-m-Y');
                  $fecha_entrada = strtotime($fecha);
                ?>
                  @if($fecha_actual >= $fecha_entrada)
                    <td><span class="label label-success">Activo</span></td>
                  @else
                    <td><span class="label label-default">Inactivo</span></td>
                  @endif
                <td class="text-center">
                  <a title="Eliminar" href="{{URL('blog/delete/'.$blog->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');">
                    <i class="fa fa-times-circle"></i>
                  </a>
                  <a title="Editar" href="{{URL('blog/editar/'.$blog->id)}}">
                    <i class="fa fa-cog"></i>
                  </a>
                </td>
              </tr> 
            @endforeach
          @else
            <tr> 
              <th colspan="7">No hay ninguna entrada registrada</th>
            </tr> 
          @endif  
        </tbody>
        <tfoot>
          <tr>
            <th colspan="2">Entrada</th>
            <th>Creaci&oacute;n</th>
            <th>Publicaci&oacute;n</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </tfoot>
      </table>
      {{$blogs->links();}}
    </div>
  </div>
  <!-- /New widget -->
  <!-----------------Categorias--------------------->
  <div id="categorias" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Categorias</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(array('url'=>'blog/crearcategoria', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
            <fieldset>
              {{Form::label('nombre', 'Sategorias', array('class' => 'label'))}}
              <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    @if(count($categorias) > 0)
                      @foreach($categorias as $categoria)
                        <tr>
                          <td>{{$categoria->nombre}}</td>
                          <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('blog/deletecategoria/'.$categoria->id)}}" ><i class="fa fa-trash-o"></i></a>
                        </tr>
                      @endforeach
                    @endif 
                  </tbody>
                </table>
              </div>
            </fieldset>
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('nombre', '* Categoria', array('class' => 'label'))}}
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
  <!-----------------Tags--------------------->
  <div id="tags" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Tags</h4>
        </div>
        <div class="modal-body">
         {{ Form::open(array('url'=>'blog/creartag', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
            <fieldset>
              {{Form::label('nombre', 'Tags', array('class' => 'label'))}}
              <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    @if(count($tags) > 0)
                      @foreach($tags as $tag)
                        <tr>
                          <td>{{$tag->nombre}}</td>
                          <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('blog/deletetag/'.$tag->id)}}" ><i class="fa fa-trash-o"></i></a>
                        </tr>
                      @endforeach
                    @endif 
                  </tbody>
                </table>
              </div>
            </fieldset>
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('nombre', '* Tag', array('class' => 'label'))}}
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