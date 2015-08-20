@section('titulo')
    IncubaM&aacute;s | Sliders
@stop

@section('sliders')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('sliders','Sliders')}}</li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Sliders<small> Editar</small></h1>
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
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
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{ Form::model($slider, ['url'=>'sliders/editar', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('id')}}
                <fieldset>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('imagen', '* Imagen', ['class' => 'label'])}}
                        {{Form::file('imagen', ['accept'=>"image/*"])}}<br/>
                        <div class="note"><strong>Nota:</strong>La imagen debe medir 1370 x 770</div>
                        <span class="message-error" style="font-weight: bold">{{$errors->first('imagen')}}</span>
                        <script type="text/javascript">
                            $("#imagen").fileinput({
                                previewFileType: "image",
                                browseClass: "btn btn-success",
                                initialPreview: [
                                    "<img src='{{url('Orb/images/sliders/'.$slider->imagen)}}' class='file-preview-image'>"
                                ],
                                browseLabel: " Selecciona otra imagen ",
                                browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                                showCaption: false,
                                showRemove: false,
                                showUpload: false
                            });
                        </script>
                    </div>
                    <div class="col-md-3 espacio_abajo">
                        {{Form::label('activo', '* Estado', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('activo', [1=>'Activo', 0=>'Inactivo'])}}
                            <span class="message-error">{{$errors->first('activo')}}</span>
                        </label>
                    </div>
                </fieldset>
                <footer>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Guardar', ['class'=>'btn btn-primary']) }}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </footer>
            {{Form::close()}}
        </div>
    </div>
@stop