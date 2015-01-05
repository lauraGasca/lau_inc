@section('titulo')
    Incubamas | Calendario
@stop

@section('calendario')
    class="active"
@stop

@section('mapa')
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="active">Calendario</li>
@stop

@section('css')
  @parent
  <link rel="stylesheet" href="{{ URL::asset('Orb/bower_components/bootstrap-calendar/css/calendar.css')}}">
  <script type="text/javascript" src="{{ URL::asset('Orb/bower_components/jquery/jquery.min.js')}}"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="{{ URL::asset('Orb/bower_components/bootstrap-calendar/js/language/es-MX.js')}}"></script>
  <script src="{{ URL::asset('Orb/bower_components/moment/moment.js')}}"></script>
  <script src="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js')}}"></script>
  <script src="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>
  <link rel="stylesheet" href="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
  <script src="{{ URL::asset('Orb/bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js')}}"></script>
@show

@section('titulo-seccion')
    <h1>Calendario<small> Incubamas</small></h1>
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
  <div class="powerwidget" id="forms-9" data-widget-editbutton="false">
    <div class="inner-spacer">
      <div class="container">     
	<div class="row">	
	  <div class="page-header">
	    <div class="pull-right form-inline" style="float: left !important; width: 93%;">
	      <div class="btn-group">
		<button class="btn btn-primary" data-calendar-nav="prev"><<</button>
		<button class="btn" data-calendar-nav="today">Hoy</button>
		<button class="btn btn-primary" data-calendar-nav="next">>></button>
	      </div>
	      <div class="btn-group" style="float: right;">
		<button class="btn btn-warning" data-calendar-view="year">Año</button>
		<button class="btn btn-warning active" data-calendar-view="month">Mes</button>
		<button class="btn btn-warning" data-calendar-view="week">Semana</button>
		<button class="btn btn-warning" data-calendar-view="day">Día</button>
	      </div>
	       
	    </div>
	    <br/><br/><br/><br/><br/>
	    <h3 style="display: inline-block;"></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <a class="btn btn-info" href="#myModal3" data-toggle="modal">Concretar Cita</a>&nbsp;&nbsp;
	    <a class="btn btn-info" href="#myModal1" data-toggle="modal">Crear Evento</a>&nbsp;&nbsp;
	    <a class="btn btn-info" href="#Servicios" data-toggle="modal">Horarios no disponible</a>	      
	  </div>
	</div>
	<div class="row">
	  <div id="calendar"></div>
	</div>
	<!--ventana modal para el calendario-->
	<div class="modal fade" id="events-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Modal title</h4>
	      </div>
	      <div class="modal-body" style="height: 400px">
		<p>One fine body&hellip;</p>
	      </div>
	      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
      </div>
    </div>
  </div>
  <div id="myModal1" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Crear Evento</h4>
        </div>
	{{ Form::open(array('url'=>'calendario/evento/'.\Auth::user()->id, 'class'=>'orb-form','method' => 'post') )}}
	  {{Form::hidden('destino','calendario')}}
	<div class="modal-body">
	  <fieldset>
	    <div class="col-md-6 espacio_abajo">
	      {{Form::label('title', '* Nombre', array('class' => 'label'))}}
	      <label class="input">
		{{Form::text('title','',array('class'=>'form-control', 'id'=>"body"))}}
	      </label>
	      <span class="message-error">{{$errors->first('title')}}</span>
	    </div>
	    <div class="col-md-5 espacio_abajo">
	      {{Form::label('class', '* Color', array('class' => 'label'))}}
	      <label class="select">
		 {{Form::select('class', array("event-info"=>'Azul', "event-success"=>'Verde',
		    "event-inverse"=>'Negro',"event-warning"=>'Amarillo',"event-special"=>'Morado'))}}
	      </label>
	      <span class="message-error">{{$errors->first('class')}}</span>
	    </div>
	    <div class="col-md-6 espacio_abajo">
	      {{Form::label('from', '* De', array('class' => 'label'))}}
	      <label class="input">
		<i class="icon-prepend  fa fa-calendar"></i>
		{{Form::text('from','',array('class'=>'form-control', 'readonly', 'id'=>'from', 'onchange'=>'cambiar();'))}}
	      </label>
	      <span class="message-error">{{$errors->first('from')}}</span>
	    </div>
	    <div class="col-md-5 espacio_abajo">
	      {{Form::label('to', '* A', array('class' => 'label'))}}
	      <label class="input">
		<i class="icon-prepend  fa fa-calendar"></i>
		{{Form::text('to','',array('class'=>'form-control', 'readonly', 'id'=>'to','onchange'=>'cambiar();'))}}
	      </label>
	      <span class="message-error">{{$errors->first('to')}}</span>
	    </div>
	    <div class="col-md-6 espacio_abajo">
	      {{Form::label('event', 'Asunto', array('class' => 'label'))}}
	      <label class="input">
		{{Form::text('event','',array('class'=>'form-control', 'id'=>"body"))}}
	      </label>
	      <span class="message-error">{{$errors->first('event')}}</span>
	    </div>
	    
	    <div class="col-md-11 espacio_abajo" style="text-align: left;">
	      * Los campos son obligatorios
	    </div>
	  </fieldset>
        </div>
        <div class="modal-footer">
	  <span id="eventos">
	    @if($warning<>"")
	      <button onClick="return confirm('Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?');" class="btn btn-primary" id="evento_boton">Crear</button>
	    @else
	      <button class="btn btn-primary" id="evento_boton">Crear</button>
	    @endif
	  </span>
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
	{{Form::close()}}
      </div>
    </div>
  </div>
  <div id="myModal3" class="modal" data-easein="fadeInUp" data-easeout="fadeOutUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="titulo_pago">Concretar Cita</h4>
        </div>
	{{ Form::open(array('url'=>'calendario/crear/'.\Auth::user()->id, 'class'=>'orb-form','method' => 'post') )}}
	  {{Form::hidden('destino','calendario')}}
        <div class="modal-body">
            <fieldset>
              <div class="col-md-11 espacio_abajo">
		@if(Auth::user()->type_id == 3)
		  {{Form::label('consultor', '* Consultor', array('class' => 'label'))}}
		@else
		  {{Form::label('consultor', '* Emprendedor', array('class' => 'label'))}}
		@endif
                <label class="select">
                   {{Form::select('consultor', $asesores,  '',array('id' => 'objetivo','onchange'=>'cambiar();'))}}
                </label>
                <span class="message-error">{{$errors->first('consultor')}}</span>
              </div>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('from', '* Fecha', array('class' => 'label'))}}
		<label class="input">
		  {{Form::text('from','',array('class'=>'form-control', 'readonly', 'id'=>'fecha', 'onchange'=>'cambiar();'))}}
                </label>
		<span class="message-error">{{$errors->first('from')}}</span>
              </div>
              <div class="col-md-5 espacio_abajo">
                {{Form::label('horario', '* Hora', array('class' => 'label'))}}
                <label class="select" id='hora'>
                   {{Form::select('horario', $horarios_disponibles, array('id' => 'horario'))}}
                </label>
                <span class="message-error">{{$errors->first('horario')}}</span>
              </div>
	      <div class="col-md-11 espacio_abajo">
                {{Form::label('event', 'Asunto', array('class' => 'label'))}}
                <label class="input">
                  {{Form::text('event','',array('class'=>'form-control', 'id'=>"body"))}}
                </label>
                <span class="message-error">{{$errors->first('event')}}</span>
              </div>
              <div class="col-md-11 espacio_abajo" style="text-align: left;">
                * Los campos son obligatorios
              </div>
            </fieldset>
        </div>
        <div class="modal-footer">
	  <span id="cita">
	    @if($warning_cita<>"")
	      <button onClick="return confirm('Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?');" class="btn btn-primary" id="cita_boton">Crear</button>
	    @else
	      <button class="btn btn-primary" id="cita_boton">Crear</button>
	    @endif
	  </span>
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        </div>
	{{Form::close()}}
      </div>
    </div>
  </div>
  <!-- End .powerwidget -->
      <!-------Servicios------->
  <div id="Servicios" class="modal" data-easein="fadeInLeft" data-easeout="fadeOutLeft"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Horarios En Los Que No Te Encuentras Disponible</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(array('url'=>'calendario/horariosasesor', 'class'=>'orb-form','method' => 'post') )}}
            <fieldset>
              {{Form::label('nombre', 'Horarios', array('class' => 'label'))}}
              <div class="col-md-11 espacio_abajo" style=" overflow: auto; height: 200px;">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    @if(count($nohorarios) > 0)
                      @foreach($nohorarios as $horario)
                        <tr>
                          <td>
			  @if($horario->dia==1)
			    Lunes
			  @else
			    @if($horario->dia==2)
			      Martes
			    @else
			      @if($horario->dia==3)
				Miercoles
			      @else
				@if($horario->dia==4)
				  Jueves
				@else
				  @if($horario->dia==5)
				    Viernes
				  @endif
				@endif
			      @endif
			    @endif
			  @endif
			  </td>
			  <td>{{$horario->horario}}</td>
                          <td><a onClick="return confirm('\u00BFSeguro que deseas eliminar?');" href="{{url('calendario/deletehorario/'.$horario->id)}}" ><i class="fa fa-trash-o"></i></a>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </fieldset>
            <fieldset>
              <div class="col-md-6 espacio_abajo">
                {{Form::label('dia', '* Dia', array('class' => 'label'))}}
                <label class="select">
                  {{Form::select('dia', array(1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes'), array('id' => 'horario'))}}
                </label>
                <span class="message-error">{{$errors->first('dia')}}</span>
              </div>
	      <div class="col-md-5 espacio_abajo">
                {{Form::label('horario', '* Horario', array('class' => 'label'))}}
                <label class="select">
                  {{Form::select('horario', $horarios)}}
                </label>
                <span class="message-error">{{$errors->first('horario')}}</span>
              </div>
	      <div class="col-md-6 espacio_abajo">
                <button class="btn btn-primary">A&ntilde;adir</button>
              </div>
	      <div class="col-md-11 espacio_abajo" style="text-align: left;">
		* Los campos son obligatorios
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
      
@section('scripts')
  <!--Fullscreen--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/fullscreen/screenfull.min.js') }}"></script> 
  <!--NanoScroller-->
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/nanoscroller/jquery.nanoscroller.min.js') }}"></script> 
  <!--Sparkline--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/sparkline/jquery.sparkline.min.js') }}"></script> 
  <!--Horizontal Dropdown--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/horisontal/cbpHorizontalSlideOutMenu.js') }}"></script> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/classie/classie.js') }}"></script> 
  <!--PowerWidgets--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/powerwidgets/powerwidgets.min.js') }}"></script>
  <!--Bootstrap--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/bootstrap/bootstrap.min.js') }}"></script> 
  <!--ToDo--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/todos/todos.js') }}"></script>
  <!--Bootstrap Animation--> 
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/animation/animation.js') }}"></script>
  <!--Main App-->
  <script type="text/javascript" src="{{ URL::asset('Orb/js/scripts.js') }}"></script>
  <!--Calendario-->
  <script src="{{ URL::asset('Orb/bower_components/underscore/underscore-min.js') }}"></script>
  <script src="{{ URL::asset('Orb/bower_components/bootstrap-calendar/js/calendar.js') }}"></script>
  <script type="text/javascript">
    function cambiar() {
      consultor = $('#objetivo').val();
      fecha = $('#fecha').val();
      from = $('#from').val();
      to = $('#to').val();
      $.ajax({
        url: '/calendario/horario',
        type: 'POST',
        data: {consultor: consultor, fecha: fecha, from: from, to: to},
        dataType: 'JSON',
        error: function() {
          $("#hora").html('Ha ocurrido un error...');
        },
        success: function(respuesta) {
          if (respuesta) {
	    //$("#hora").html(JSON.stringify(respuesta.warning ));
	    //$("#hora").html(JSON.stringify(respuesta));
	    
	    var html = '';
	    for (i = 0; i < respuesta.horarios.length; i++) {
	      html += '<option value="'+respuesta.horarios[i].id+'">'+respuesta.horarios[i].horario+'</option>';
	    }
	    $("#horario").html(html);
	    if (respuesta.warning == "Hay eventos") {
	      $("#cita").html('<button onClick="return confirm(\'Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?\');" class="btn btn-primary" id="cita_boton">Crear</button>');
	    }else{
	      $("#cita").html('<button class="btn btn-primary" id="cita_boton">Crear</button>');
	    }
	    if (respuesta.warning_evento == "Hay eventos") {
	      $("#eventos").html('<button onClick="return confirm(\'Se han detectado otros eventos en este dia. \u00BFSeguro que deseas continuar?\');" class="btn btn-primary" id="evento_boton">Crear</button>');
	    }else{
	      $("#eventos").html('<button class="btn btn-primary" id="evento_boton">Crear</button>');
	    }
          }
          else {
            $("#hora").html('No se que pasa');
          }          
        }
      });
    }
    $(function () {
      $('#fecha').datetimepicker({
	language: 'es',
	minDate:
	@if(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==0)
	  '{{date ( 'm/j/Y' , strtotime ('+3 day', strtotime(date('j-m-Y'))))}}',
	@elseif(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==6)
	  '{{date ( 'm/j/Y' , strtotime ('+4 day', strtotime(date('j-m-Y'))))}}',
	@else
	  '{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
	@endif
	maxDate:
	@if(date("w", strtotime ('+30 day', strtotime(date('j-m-Y'))))==0)
	  '{{date ( 'm/j/Y' , strtotime ('+31 day', strtotime(date('j-m-Y'))))}}',
	@elseif(date("w", strtotime ('+30 day', strtotime(date('j-m-Y'))))==6)
	  '{{date ( 'm/j/Y' , strtotime ('+32 day', strtotime(date('j-m-Y'))))}}',
	@else
	  '{{date ( 'm/j/Y' , strtotime ('+30 day', strtotime(date('j-m-Y'))))}}',
	@endif
	pickTime: false,
	defaultDate:
	@if(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==0)
	  '{{date ( 'm/j/Y' , strtotime ('+3 day', strtotime(date('j-m-Y'))))}}',
	@elseif(date("w", strtotime ('+2 day', strtotime(date('j-m-Y'))))==6)
	  '{{date ( 'm/j/Y' , strtotime ('+4 day', strtotime(date('j-m-Y'))))}}',
	@else
	  '{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
	@endif
	//'{{date ( 'm/j/Y' , strtotime ('+2 day', strtotime(date('j-m-Y'))))}}',
	disabledDates: [
	    moment("12/25/2014"),
	    moment("1/1/2015"),
	    moment("2/2/2015"),
	    moment("3/16/2015"),
	    moment("4/3/2015"),
	    moment("5/1/2015"),
	    moment("9/16/2015"),
	    moment("11/16/2015"),
	    moment("12/25/2015"),
	],
	daysOfWeekDisabled:[0,6]  
      });
      $('#from').datetimepicker({
	  language: 'es',
	  defaultDate: new Date(),
	  minDate: '{{date ( 'm/j/Y')}}',
      });
      $('#to').datetimepicker({
	  language: 'es',
	  defaultDate: new Date(),
	  minDate: '{{date ( 'm/j/Y')}}'
      });
      $("#from").on("dp.change",function (e) {
	if ($("#from").val()>$('#to').val()) {
	  $('#to').data("DateTimePicker").setDate(e.date);
	}
      });
      $("#to").on("dp.change",function (e) {
	 if ($("#from").val()>$('#to').val()) {
	  $('#from').data("DateTimePicker").setDate(e.date);
	}
      });
    });
    (function($){
      //creamos la fecha actual
      var date = new Date();
      var yyyy = date.getFullYear().toString();
      var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
      var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
  
      //establecemos los valores del calendario
      var options = {
        events_source: '{{url('calendario/obtener')}}',
        view: 'month',
        language: 'es-MX',
        tmpl_path: 'http://incubamas.com/Orb/bower_components/bootstrap-calendar/tmpls/',
        tmpl_cache: false,
        day: yyyy+"-"+mm+"-"+dd,
        time_start: '9:00',
        time_end: '18:00',
        time_split: '30',
        width: '93%',
        onAfterEventsLoad: function(events) 
        {
          if(!events) 
          {
            return;
          }
          var list = $('#eventlist');
          list.html('');
          $.each(events, function(key, val) 
          {
            $(document.createElement('li'))
              .html('<a href="' + val.url + '">' + val.title + '</a>')
              .appendTo(list);
          });
      },
      onAfterViewLoad: function(view) 
      {
        $('.page-header h3').text(this.getTitle());
        $('.btn-group button').removeClass('active');
        $('button[data-calendar-view="' + view + '"]').addClass('active');
      },
      classes: {
        months: {
          general: 'label'
        }
      }
    };
  
      var calendar = $('#calendar').calendar(options);
  
      $('.btn-group button[data-calendar-nav]').each(function() 
        {
          var $this = $(this);
          $this.click(function() 
          {
            calendar.navigate($this.data('calendar-nav'));
          });
        });
  
      $('.btn-group button[data-calendar-view]').each(function() 
      {
        var $this = $(this);
        $this.click(function() 
        {
          calendar.view($this.data('calendar-view'));
        });
      });
  
      $('#first_day').change(function()
      {
        var value = $(this).val();
        value = value.length ? parseInt(value) : null;
        calendar.setOptions({first_day: value});
        calendar.view();
      });
    }(jQuery));
  </script>
@stop
