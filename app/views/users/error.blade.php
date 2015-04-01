@section('titulo')
    Incubamas | Reportar Error
@stop

@section('css')
    @parent
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Reportar Error</li>
@stop

@section('titulo-seccion')
    <h1>Reportar Error <small>Enviar</small></h1>
@stop

@section('contenido')
    @if(Session::get('confirm'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            {{Session::get('confirm')}}
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{ Form::open(array('url'=>'usuarios/error', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data') )}}
            <fieldset>
                <div class="col-md-11 espacio_abajo">
                    {{Form::label('descripcion', '* Descripci&oacute;n del Error', array('class' => 'label'))}}
                    <label class="textarea">
                        {{Form::textarea('descripcion')}}
                        <script type="text/javascript">
                            CKEDITOR.replace( 'descripcion',
                                    {
                                        toolbar : 'Incuba'
                                    });
                        </script>
                    </label>
                    <span class="message-error">{{$errors->first('descripcion')}}</span>
                </div>
                <div class="col-md-11 espacio_abajo">
                    {{Form::label('archivo', '* Imagen del Error', array('class' => 'label'))}}
                    {{Form::file('foto',['id'=>'archivo', 'accept'=>"image/*"])}}
                    <script>
                        $("#archivo").fileinput({
                            previewFileType: "image",
                            showCaption: false,
                            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                            browseClass: "btn btn-success",
                            browseLabel: " Subir Imagen",
                            removeClass: "btn btn-danger",
                            removeLabel: "Borrar",
                            removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                            showUpload: false
                        });
                    </script>
                    <span class="message-error">{{$errors->first('foto')}}</span>
                </div>
            </fieldset>
            <footer>
                <div class="col-md-6 espacio_abajo" >
                    {{ Form::submit('Enviar', array('class'=>'btn btn-default')) }}
                </div>
                <div class="col-md-5 espacio_abajo" style="text-align: right;">
                    * Los campos son obligatorios
                </div>
            </footer>
            {{Form::close()}}
        </div>
    </div>
    <!-- End .powerwidget -->
@stop