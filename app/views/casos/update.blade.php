@section('titulo')
  Incubamas | Casos de &Eacute;xito
@stop

@section('casos')
    class="active"
@stop

@section('mapa')
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li>{{HTML::link('casos','Casos de &Eacute;xito')}}</li>
  <li class="active">Editar</li>
@stop

@section('titulo-seccion')
  <h1>Casos de &Eacute;xito<small>Editar</small></h1>
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
  <div class="powerwidget col-grey" id="user-directory" data-widget-editbutton="false">
    <div class="inner-spacer">
      {{ Form::open(array('url'=>'casos/editar', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data') )}}
        {{Form::hidden('caso_id', $caso->id)}}
        <fieldset>
          <div class="col-md-6 espacio_abajo">
            <span class="message-error">{{$errors->first('caso_id')}}</span>
            {{Form::label('nom_pro', '* Nombre del Proyecto', array('class' => 'label'))}}
            <label class="input">
              <i class="icon-prepend fa fa-cube"></i>
              {{Form::text('nombre_proyecto', $caso->nombre_proyecto)}}
            </label>
            <span class="message-error">{{$errors->first('nombre_proyecto')}}</span>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('cat', '* Categoria', array('class' => 'label'))}}
            <label class="select">
              {{Form::select('categoria', array(
                  'Comercio' => 'Comercio',
                  'Servicio' => 'Servicio',
                  'Industria' => 'Industria',
                  'Incubandose' => 'Incubandose'), $caso->categoria)}}
            </label>
            <span class="message-error">{{$errors->first('categoria')}}</span>
          </div>
          <div class="col-md-11 espacio_abajo">
            {{Form::label('about', '* Acerca del Proyecto', array('class' => 'label'))}}
            <label class="textarea">
              {{ Form::textarea('about_proyect', $caso->about_proyect, array('rows'=>'3')) }}
            </label>
            <span class="message-error">{{$errors->first('about_proyect')}}</span>
          </div>
        </fieldset>
        <fieldset>
          <div class="col-md-12 espacio_abajo">
            {{Form::label('servicios', 'Servicios', array('class' => 'label'))}}
          </dev>
          <div class="col-md-6 espacio_abajo">
            <label class="select select-multiple">
              {{Form::select('servicios[]', $servicios, $relaciones, array('multiple'))}}
            </label>
            <span class="message-error">{{$errors->first('servicios[]')}}</span>
            <div class="note">
              <strong>
                Nota:
              </strong>
              Manten precionado Ctrl para seleccionar multiples sevicios
            </div>
          </div>
          <div class="col-md-5 espacio_abajo">
            {{Form::label('img', '* Imagen', array('class' => 'label'))}}
            <img height="10%" src="{{ URL::asset('Orb/images/casos_exito/'.$caso->imagen) }}"  style="width: 100px;">
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
@stop

@section('scripts')
    @parent
    <!--Forms--> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.form.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.validate.min.js') }}"></script> 
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.maskedinput.min.js') }}"></script> 
@stop