@section('titulo')
    Incubamas | Casos de &Eacute;xito
@stop

@section('casos')
    class="active"
@stop

@section('css')
    @parent
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    {{ HTML::style('Orb/tags/css/jquery.tagit.css') }}
    {{ HTML::style('Orb/tags/css/tagit.ui-zendesk.css') }}
    {{ HTML::script('Orb/tags/js/tag-it.js') }}
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
    <script>
        $(function(){
            var sampleTags = [{{$servicios}}];
            $('#tags').tagit({
                availableTags: sampleTags,
                singleField: true,
                singleFieldNode: $('#serv_tags')
            });
        });
    </script>
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('casos','Casos de &Eacute;xito')}}</li>
    <li class="active">Crear</li>
@stop

@section('titulo-seccion')
    <h1>Casos de &Eacute;xito<small>Crear</small></h1>
@stop

@section('contenido')
    @if(count($errors)>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            ¡Por favor, revise los datos del formulario!
        </div>
    @endif
    <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{ Form::open(['url'=>'casos/crear', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('nombre_proyecto', '* Nombre del Proyecto', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-cube"></i>{{Form::text('nombre_proyecto')}}
                            <span class="message-error">{{$errors->first('nombre_proyecto')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('categoria', '* Categoria', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('categoria', [null => 'Selecciona','Comercio' => 'Comercio','Servicio' => 'Servicio','Industria' => 'Industria','Incubandose' => 'Incubandose'])}}
                            <span class="message-error">{{$errors->first('categoria')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('about_proyect', '* Acerca del Proyecto', ['class' => 'label'])}}
                        <label class="textarea">
                            {{ Form::textarea('about_proyect', null, ['rows'=>'5']) }}
                            <span class="message-error">{{$errors->first('about_proyect')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('servicios', 'Servicios', ['class' => 'label'])}}
                        {{Form::text('servicios', null, ['style'=>'visibility: hidden', 'id'=>'serv_tags']) }}
                        <ul id="tags"></ul>
                        <span class="message-error">{{$errors->first('servicios')}}</span>
                        <div class="note"><strong>Nota:</strong> Escribe el nombre del servicio y al poner un espacio o dar enter se seleccionara. <br/> Si ya existe un servicio que empiece con esa letra, aparecera una lista de sugerencias.</div>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('imagen', '* Imagen', ['class' => 'label'])}}
                        {{Form::file('imagen', ['accept'=>"image/*"])}}<br/>
                        <span class="message-error" style="font-weight: bold">{{$errors->first('imagen')}}</span>
                        <div class="note"><strong>Nota:</strong>La imagen debe medir 300 x 300</div>
                    </div>
                </fieldset>
                <footer>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Crear', ['class'=>'btn btn-default']) }}
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
    <script type="text/javascript">
        $("#imagen").fileinput({
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: " Selecciona la imagen ",
            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
            showCaption: false,
            removeClass: "btn btn-danger",
            removeLabel: "Borrar",
            removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
            showUpload: false
        });
    </script>
@stop