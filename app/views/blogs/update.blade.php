@section('titulo')
    Incubamas | Entradas del Blog
@stop

@section('css')
  @parent
  <script type="text/javascript" src="{{ URL::asset('Orb/js/ckeditor/ckeditor.js') }}"></script>
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/address.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/select2.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/typeahead.js-bootstrap.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/demo-bs3.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('Orb/css/vendors/x-editable/bootstrap-editable.css') }}" rel="stylesheet" type="text/css">
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
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb clearfix">
          {{Session::get('confirm')}}
        </div>
      </div>
    </div>
  @endif
  <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
    <div class="inner-spacer">
      {{ Form::open(array('url'=>'blog/editar', 'class'=>'orb-form','method' => 'post', 'id'=>'data-pickers', 'enctype'=>'multipart/form-data') )}}
      {{Form::hidden('blog_id', $blogs->id)}}
        <fieldset>
          <div class="col-md-6 espacio_abajo">
            {{Form::label('titulo', '* T&iacute;tulo', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-cube"></i>
              {{Form::text('titulo',$blogs->titulo)}}
            </label>
            <span class="message-error">{{$errors->first('titulo')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('fecha', '* Fecha de publicaci&oacute;n', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-calendar"></i>
              <?php
                $date = date_create($blogs->fecha_publicacion);
                $fecha=date_format($date, 'd.m.Y');
              ?>
              {{Form::text('finish',$fecha,array('id'=>'finish'))}}
            </label>
            <span class="message-error">{{$errors->first('finish')}}</span>
          </div>
          <div class="col-md-2 espacio_abajo">
            {{Form::label('cat', '* Categoria', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('categoria', $categorias, $blogs->categoria_id)}}
            </label>
            <span class="message-error">{{$errors->first('categoria')}}</span>
          </div>
          <div class="col-md-11 espacio_abajo">
            {{Form::label('entrada', '* Entrada', array('class' => 'label'))}}
            <label class="textarea">
              {{Form::textarea('entrada', $blogs->entrada)}}
              <script type="text/javascript">
                CKEDITOR.replace( 'entrada',
                {
                        toolbar : 'Incuba'
                });
              </script>
            </label>
            <span class="message-error">{{$errors->first('entrada')}}</span>
          </div>
        </fieldset>
        <fieldset>
          <div class="col-md-6 espacio_abajo">
            {{Form::label('tags', 'Tags', array('class' => 'label'))}}
            <label class="select select-multiple">
              {{Form::select('tags[]', $tags, $etiquetados, array('multiple'))}}
            </label>
            <span class="message-error">{{$errors->first('tags[]')}}</span>
            <div class="note">
              <strong>
                  Nota:
              </strong>
              Manten precionado Ctrl para seleccionar multiples tags
            </div><br/>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('img', '* Imagen', array('class' => 'label'))}}
            <img height="10%" src="{{ URL::asset('Orb/images/entradas/'.$blogs->imagen) }}" style="width: 100px;">
            <br/><br/>{{Form::file('archivo')}}
            <span class="message-error">{{$errors->first('archivo')}}</span>
          </div>
        </fieldset>
        <footer>
          <div class="col-md-6 espacio_abajo" >
            {{ Form::submit('Guardar', array('class'=>'btn btn-default')) }}
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

@section('scripts')
    @parent
    <!--Forms-->
    <script type="text/javascript" src="{{ URL::asset('Orb/js/scripts.js') }}"></script>      
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.form.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.validate.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.maskedinput.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/jquery-steps/jquery.steps.min.js')}}"></script> 
    <!--X-Editable--> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/bootstrap-editable.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo-mock.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/select2.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/address.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/jquery.mockjax.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/moment.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/select2-bootstrap.css') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/typeahead.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/typeaheadjs.js') }}"></script>
    <!--iOnRangeSlider--> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/ionrangeslider/ion.rangeSlider.min.js') }}"></script> 
    <!--Knob--> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/knob/jquery.knob.js') }}"></script> 
@stop