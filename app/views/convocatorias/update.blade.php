@section('titulo')
    IncubaM&aacute;s | Convocatorias
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}
@stop

@section('convocatorias')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('convocatorias','Convocatorias')}}</li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Convocatorias<small>Editar</small></h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{ Form::model($convocatoria,['url'=>'convocatorias/update', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('id')}}
                <fieldset>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('nombre', '* Nombre de la Convocatoria', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-cube"></i>{{Form::text('nombre')}}
                            <span class="message-error">{{$errors->first('nombre')}}</span>
                        </label>
                    </div>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('descripcion', '* Descripción', ['class' => 'label'])}}
                        <label class="textarea">
                            {{Form::textarea('descripcion')}}
                            <script type="text/javascript">
                                CKEDITOR.replace('descripcion', {toolbar : 'Incuba'});
                            </script>
                            <span class="message-error">{{$errors->first('descripcion')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('estatus', 'Estatus', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('estatus',[null =>'Selecciona', 1=>'Activo', 0=>'Inactivo'], null, ['class'=>"form-control", 'tabindex'=>"2"])}}
                            <span class="message-error">{{$errors->first('estatus')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('imagen', '* Imagen', ['class' => 'label'])}}
                        {{Form::file('imagen', ['accept'=>"image/*"])}}<br/>
                        <span class="message-error" style="font-weight: bold">{{$errors->first('imagen')}}</span>
                        <script type="text/javascript">
                            $("#imagen").fileinput({
                                previewFileType: "image",
                                browseClass: "btn btn-success",
                                initialPreview: [
                                    "<img src='{{url('Orb/images/convocatorias/'.$convocatoria->imagen)}}' class='file-preview-image'>"
                                ],
                                browseLabel: " Selecciona otra imagen ",
                                browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                                showCaption: false,
                                showRemove: false,
                                showUpload: false
                            });
                        </script>
                        <div class="note"><strong>Nota:</strong>La imagen debe medir 250 x 270</div>
                    </div>
                </fieldset>
                <footer>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Guardar', ['class'=>'btn btn-primary'])}}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </footer>
            {{Form::close()}}
        </div>
    </div>
@stop