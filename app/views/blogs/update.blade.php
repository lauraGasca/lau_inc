@section('titulo')
    Incubamas | Entradas del Blog
@stop

@section('css')
    @parent
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    {{ HTML::style('Orb/bower_components/bootstrap-calendar/css/calendar.css') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js') }}
    {{ HTML::style('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::script('Orb/bower_components/moment/moment.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js') }}
    {{ HTML::script('Orb/js/ckeditor/ckeditor.js') }}
    {{ HTML::style('Orb/tags/css/jquery.tagit.css') }}
    {{ HTML::style('Orb/tags/css/tagit.ui-zendesk.css') }}
    {{ HTML::script('Orb/tags/js/tag-it.js') }}
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
    <script>
        $(function(){
            var sampleTags = [{{$tags}}];
            $('#tags').tagit({
                availableTags: sampleTags,
                singleField: true,
                singleFieldNode: $('#serv_tags')
            });
        });
    </script>
@stop

@section('blog')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('blog','Entradas del Blog')}}</li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Entradas del Blog<small>Editar</small></h1>
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
            {{ Form::model($blog, ['url'=>'blog/editar', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('id')}}
                <fieldset>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('titulo', '* T&iacute;tulo', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-cube"></i>{{Form::text('titulo')}}
                            <span class="message-error">{{$errors->first('titulo')}}</span>
                        </label>
                    </div>
                    <div class="col-md-3 espacio_abajo">
                        {{Form::label('fecha_publicacion', '* Fecha de publicaci&oacute;n', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-calendar"></i>{{Form::text('fecha_publicacion', $blog->publicar, ['id'=>'fecha','readonly'])}}
                            <span class="message-error">{{$errors->first('fecha_publicacion')}}</span>
                        </label>
                    </div>
                    <div class="col-md-2 espacio_abajo">
                        {{Form::label('categoria_id', '* Categoria', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('categoria_id', [null=>'Selecciona']+$categorias)}}
                            <span class="message-error">{{$errors->first('categoria_id')}}</span>
                        </label>
                    </div>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('entrada', '* Entrada', ['class' => 'label'])}}
                        <label class="textarea">
                            {{Form::textarea('entrada')}}
                            <script type="text/javascript">
                                CKEDITOR.replace('entrada', {toolbar : 'Incuba'});
                            </script>
                            <span class="message-error">{{$errors->first('entrada')}}</span>
                        </label>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('tags', 'Tags', ['class' => 'label'])}}
                        {{Form::text('tags', $etiquetados, ['style'=>'visibility: hidden', 'id'=>'serv_tags']) }}
                        <ul id="tags"></ul>
                        <span class="message-error">{{$errors->first('tags')}}</span>
                        <div class="note"><strong>Nota:</strong> Escribe el nombre del tag y al poner un espacio o dar enter se seleccionara. <br/> Si ya existe un tag que empiece con esa letra, aparecera una lista de sugerencias.</div>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('imagen', 'Imagen', ['class' => 'label'])}}
                        {{Form::file('imagen', ['accept'=>"image/*"])}}<br/>
                        <span class="message-error" style="font-weight: bold">{{$errors->first('imagen')}}</span>
                        <div class="note"><strong>Nota:</strong>La imagen debe medir 300 x 300</div>
                    </div>
                </fieldset>
                <footer>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Guardar', ['class'=>'btn btn-default']) }}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </footer>
            {{Form::close()}}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('Orb/bower_components/underscore/underscore-min.js') }}
    {{ HTML::script('Orb/bower_components/bootstrap-calendar/js/calendar.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}
    <script type="text/javascript">
        $(function () {
            $('#fecha').datetimepicker({
                pickTime: false,
                language: 'es',
                minDate:'1/1/2000',
                defaultDate: new Date()
            });
        });
        $("#imagen").fileinput({
            previewFileType: "image",
            browseClass: "btn btn-success",
            initialPreview: [
                "<img src='{{url('Orb/images/entradas/'.$blog->imagen)}}' class='file-preview-image'>"
            ],
            browseLabel: " Selecciona otra imagen ",
            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
            showCaption: false,
            showRemove: false,
            showUpload: false
        });
    </script>
@stop