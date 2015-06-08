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
                <div class="col-md-4">
                    <div class="input-group">
                        {{ Form::open(['url'=>'blog/busqueda', 'method' => 'post'])}}
                            <span class="input-group-btn">
                                {{Form::text('buscar', null, ['class'=>'form-control', 'placeholder'=>'Buscar', 'data-provide'=>'typeahead'])}}
                                {{Form::submit('Ir!', ['class'=>'btn btn-default']) }}
                            </span>
                            <span style="color: rgb(202, 16, 16);   font-weight: bold;">{{$errors->first('buscar')}}</span><br/><br/>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="col-md-2">
                    {{HTML::link('blog','Todos los Registros', ['class'=>'btn btn-default'])}}
                </div>
                <div class="col-md-2">
                    {{HTML::link('blog/crear','Nuevo Registro', ['class'=>'btn btn-default'])}}
                </div>
                <div class="col-md-2">
                    <a href="#categorias" role="button" data-target="#categorias" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit">Categorias</i></a>
                </div>
                <div class="col-md-2">
                    <a href="#tags" role="button" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit">Tags</i></a>
                </div>
            </div>
            @if($parametro<>'')
                <span style="color: rgb(192, 194, 199); width: 100%;  text-align: left;  float: left;">
                            Resultados para "{{$parametro}}"
                </span><br/><br/>
            @endif
            <table class="table-dark table table-striped table-bordered table-hover margin-0px">
                <thead>
                    <tr>
                        <th width="60%" colspan="2" >Entrada</th>
                        <th width="10%" style="text-align: center;">Creaci&oacute;n</th>
                        <th width="10%" style="text-align: center;">Publicaci&oacute;n</th>
                        <th width="10%" style="text-align: center;">Estado</th>
                        <th width="10%" colspan="2" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($blogs) > 0)
                        @foreach($blogs as $blog)
                            <tr>
                                <td width="1%"><span class="num">{{$blog->id}}</span></td>
                                <td>
                                    <h5>{{$blog->titulo}}</h5>
                                    <small><a target="_blank" href="{{ URL::asset('blogs/'.$blog->slug.'/'.$blog->id) }}" style="color:#FFF">{{ URL::asset('blogs/'.$blog->slug.'/'.$blog->id) }}</a></small>
                                </td>
                                <td style="text-align: center;">{{$blog->creado}}</td>
                                <td style="text-align: center;">{{$blog->publicacion}}</td>
                                <td style="text-align: center;">
                                    @if($blog->activo == 1)
                                        <span class="label label-success">Activo</span>
                                    @else
                                        <span class="label label-default">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                <a title="Editar" href="{{URL('blog/editar/'.$blog->id)}}">
                                <i class="fa fa-cog"></i>
                                </a>
                                </td>
                                <td class="text-center">
                                    <a title="Eliminar" href="{{URL('blog/delete/'.$blog->id)}}" onClick="return confirm('\u00BFSeguro que deseas eliminar?');">
                                        <i class="fa fa-times-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="8" style="color: white; font-style: italic;">No hay ninguna entrada registrada</th>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Entrada</th>
                        <th style="text-align: center;">Creaci&oacute;n</th>
                        <th style="text-align: center;">Publicaci&oacute;n</th>
                        <th style="text-align: center;">Estado</th>
                        <th colspan="2" style="text-align: center;">Acciones</th>
                    </tr>
                </tfoot>
            </table>
            {{$blogs->links();}}
        </div>
    </div>
    @if($errors->first('nombre')||$errors->first('tag')) <div class="modal-backdrop  in"></div> @endif
    <!-------------------------------------------------Categorias------------------------------------------------------------->
    <div id="categorias" class="modal @if($errors->first('nombre')) animated fadeInLeft @endif" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @if($errors->first('nombre')) style="display: block;" @endif>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Categorias</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url'=>'blog/crear-categoria', 'class'=>'orb-form','method' => 'post'] )}}
                        <fieldset>
                            {{Form::label('nombre', 'Categorias', array('class' => 'label'))}}
                            <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        @foreach($categorias as $categoria)
                                            <tr>
                                                <td>{{$categoria->nombre}}</td>
                                                <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('blog/delete-categoria/'.$categoria->id)}}" ><i class="fa fa-trash-o"></i></a>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="col-md-11 espacio_abajo">
                                @if($errors->first('nombre'))
                                    <br/><div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
                                        ¡Por favor, revise los datos del formulario!
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 espacio_abajo">
                                {{Form::label('nombre', '* Categoria', array('class' => 'label'))}}
                                <label class="input">
                                    <i class="icon-prepend fa fa-cube"></i>{{Form::text('nombre')}}
                                    <span class="message-error">{{$errors->first('nombre')}}</span><br/>
                                </label>
                                <br/>* Los campos son obligatorios
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
    <!---------------------------------------------------Tags----------------------------------------------------------------->
    <div id="tags" class="modal @if($errors->first('tag')) animated fadeInLeft @endif" data-easein="fadeInLeft" data-easeout="fadeOutLeft" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @if($errors->first('tag')) style="display: block;" @endif>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Tags</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url'=>'blog/crear-tag', 'class'=>'orb-form','method' => 'post') )}}
                        <fieldset>
                            {{Form::label('nombre', 'Tags', array('class' => 'label'))}}
                            <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        @foreach($tags as $tag)
                                            <tr>
                                                <td>{{$tag->tag}}</td>
                                                <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('blog/delete-tag/'.$tag->id)}}" ><i class="fa fa-trash-o"></i></a>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="col-md-11 espacio_abajo">
                                @if($errors->first('tag'))
                                    <br/><div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
                                        ¡Por favor, revise los datos del formulario!
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 espacio_abajo">
                                {{Form::label('tag', '* Tag', array('class' => 'label'))}}
                                <label class="input">
                                    <i class="icon-prepend fa fa-cube"></i>{{Form::text('tag')}}
                                    <span class="message-error">{{$errors->first('tag')}}</span><br/>
                                </label>
                                <br/>* Los campos son obligatorios
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