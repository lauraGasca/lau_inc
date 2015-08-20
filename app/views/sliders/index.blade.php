@section('titulo')
    IncubaM&aacute;s | Sliders
@stop

@section('sliders')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Sliders</li>
@stop

@section('titulo-seccion')
    <h1>Sliders<small> Listado</small></h1>
@stop

@section('contenido')
    <div class="powerwidget powerwidget-as-portlet-white" id="darkportletdarktable" data-widget-editbutton="false">
        <div class="inner-spacer">
            <div class="row">
                <ul class="thumbnails" >
                    @foreach($sliders as $slider)
                        <li class="col-md-4 col-sm-6">
                            <div class="thumbnail" @if($slider->activo) style="background-color: #5C9A61" @endif>
                                <div class='hover-fader'>
                                    <img src="{{url('Orb/images/sliders/'.$slider->imagen)}}" alt="slider" style="width:100%; height: 100%;">
                                </div>
                                <div class="caption">
                                    <div class="btn-group">
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{url('sliders/editar/'.$slider->id)}}" type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Cambiar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop  