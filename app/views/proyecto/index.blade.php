@section('titulo')
    IncubaM&aacute;s | Plan de Negocios
@stop

@section('mapa')
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="active">Plan de Negocios</li>
@stop

@section('css')
    @parent
    <script type="text/javascript" src="{{ URL::asset('Orb/js/ckeditor/ckeditor.js') }}"></script>
@stop

@section('titulo-seccion')
  <h1>Plan de Negocios<small> Registro</small></h1>
@stop

@section('contenido')
  <!-- New widget -->
  <div class="powerwidget" id="forms-9" data-widget-editbutton="false">
    <div class="inner-spacer">
      <div class="row">
          <!--Panel Group-->
          <div class="panel-group" id="accordion">
              @foreach($modulos as $modulo)
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$modulo->id}}">
                                  <i class="fa fa-4x fa-plus-square"></i>&nbsp;&nbsp;&nbsp; {{$modulo->nombre}}
                              </a>
                          </h4>
                      </div>
                      <div id="collapse{{$modulo->id}}" class="panel-collapse @if($modulo->id <> 1) collapse @endif">
                          <div class="panel-body">
                              @foreach($modulo->preguntas as $pregunta)
                                  {{ Form::open(array('url'=>'plan-negocios/pregunta/'.$pregunta->id, 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data') )}}
                                    <fieldset>
                                      <div class="col-md-6 espacio_abajo" >
                                          {{Form::label('entrada', $pregunta->pregunta, array('class' => 'label'))}}
                                      </div>
                                      <div class="col-md-5 espacio_abajo" >
                                          <button type="submit" class="btn btn-default"><i class="fa entypo-floppy"></i></button>
                                      </div>
                                          <div class="col-md-11 espacio_abajo">
                                              <label class="textarea">
                                                  {{Form::textarea('entrada')}}
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
                                  {{Form::close()}}
                              @endforeach
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
          <!--/Panel Group-->
      </div>
    </div>
  </div>
  <!-- End Widget --> 
@stop  