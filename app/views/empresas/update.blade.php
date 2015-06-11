@section('titulo')
    Incubamas | Emprendedores
@stop

@section('emprendedores')
    class="active"
@stop

@section('css')
    @parent
    {{ HTML::style('Orb/js/fileinput/css/fileinput.min.css') }}
    {{ HTML::script('Orb/js/fileinput/js/fileinput.min.js') }}
    {{ HTML::script('Orb/js/jquery.maskedinput.js')}}
    {{ HTML::script('Orb/js/jquery.maskMoney.js') }}
    <script type="text/javascript">
        $(function () {
            $("#cpEmp").mask("99999");
            $("#monto_financiamiento").maskMoney();
            $("#costo_proyecto").maskMoney();
            $("#aportacion").maskMoney();
        });
    </script>
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li>{{HTML::link('emprendedores','Emprendedores')}}</li>
    <li>{{HTML::link('emprendedores/editar/'.$empresa->emprendedor_id,'Emprendedor')}}</li>
    <li class="active">Editar</li>
@stop

@section('titulo-seccion')
    <h1>Emprendedores
        <small>Editar</small>
    </h1>
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
    <div class="powerwidget cold-grey" id="profile" data-widget-editbutton="false">
        <div class="inner-spacer">
            {{Form::model($empresa, ['url'=>'empresas/editar', 'class'=>'orb-form','method' => 'post', 'enctype'=>'multipart/form-data'])}}
                {{Form::hidden('id')}}
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('nombre_empresa', '* Nombre del proyecto', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-building"></i>{{Form::text('nombre_empresa')}}
                            <span class="message-error">{{$errors->first('nombre_empresa')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('regimen_fiscal', 'Tipo de  Régimen fiscal', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('regimen_fiscal', [null=>'Selecciona', 'Incorporacion Fiscal'=>'Incorporaci&oacute;n Fiscal', 'Actividad Empresarial y Profesional'=>'Actividad Empresarial y Profesional'])}}
                            <span class="message-error">{{$errors->first('regimen_fiscal')}}</span>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('idea_negocio', '* Describe la idea de negocio o las actividades de tu negocio ', ['class' => 'label'])}}
                        <label class="textarea">
                            {{Form::textarea('idea_negocio')}}
                            <span class="message-error">{{$errors->first('idea_negocio')}}</span>
                        </label>
                        <div class="note">
                            <strong>Nota:</strong>Maximo 500 caracteres
                        </div>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('necesidad', '¿Qu&eacute; problema o necesidad resuelves con esto?', ['class' => 'label'])}}
                        <label class="textarea">
                            {{Form::textarea('necesidad')}}
                            <span class="message-error">{{$errors->first('necesidad')}}</span>
                        </label>
                        <div class="note">
                            <strong>Nota:</strong>Maximo 500 caracteres
                        </div>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('producto_servicio', '* Describe el producto o servicio que ofreces o quieres ofrecer', ['class' => 'label'])}}
                        <label class="textarea">
                            {{Form::textarea('producto_servicio', null, ['style'=>'height: 200px;'])}}
                            <span class="message-error">{{$errors->first('producto_servicio')}}</span>
                        </label>
                        <div class="note">
                            <strong>Nota:</strong>Maximo 500 caracteres
                        </div>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('director', 'Director General', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-group"></i>{{Form::text('director')}}
                            <span class="message-error">{{$errors->first('director')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('asistente', 'Asistente o Administrador', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-group"></i>{{Form::text('asistente')}}
                            <span class="message-error">{{$errors->first('asistente')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('pagina_web', 'Página Web de la Empresa', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-globe"></i>{{Form::text('pagina_web')}}
                            <span class="message-error">{{$errors->first('pagina_web')}}</span><br/><br/>
                        </label>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('giro_actividad', 'Rubro, Giro y/o Actividad', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('giro_actividad', [null=>'Selecciona', 'Servicio y Comercio'=>'Servicio y Comercio','Industria Ligera'=>'Industria Ligera'])}}
                            <span class="message-error">{{$errors->first('giro_actividad')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('sector', 'Sector Estrat&eacute;gico', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('sector', [null=>'Selecciona', 'Agro industrial'=>'Agro industrial','Automotriz'=>'Automotriz',
                            'Productos Químicos'=>'Productos Químicos','Cuero Calzado'=>'Cuero Calzado',
                            'Servicios de Investigación'=>'Servicios de Investigación','Turístico'=>'Turístico',
                            'Equipo medico'=>'Equipo medico','Farmacéuticos y Cosméticos'=>'Farmacéuticos y Cosméticos',
                            'Aeronáutica'=>'Aeronáutica','Construcción'=>'Construcción','Químico'=>'Químico',
                            'Agricultura'=>'Agricultura','Comercio'=>'Comercio','Software'=>'Software',
                            'Electrónica'=>'Electrónica','Textil y Confección'=>'Textil y Confección',
                            'Maquiladoras'=>'Maquiladoras','Otro'=>'Otro'])}}
                            <span class="message-error">{{$errors->first('sector')}}</span>
                        </label>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-11 espacio_abajo">
                        <h3>Datos Fiscales</h3><br/>
                    </div>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('razon_social', '* Raz&oacute;n Social', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-building"></i>{{Form::text('razon_social')}}
                            <span class="message-error">{{$errors->first('razon_social')}}</span>
                        </label>
                    </div>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('rfc', 'RCF con homoclave', ['class' => 'label'])}}
                        <label class="input">
                            <i class="icon-prepend fa fa-gavel"></i>{{Form::text('rfc')}}
                            <span class="message-error">{{$errors->first('rfc')}}</span>
                        </label>
                    </div>
                    <div class="col-md-11 espacio_abajo">
                        {{Form::label('negocio_casa', '* ¿La dirección de tu negocio es la misma que tú casa?', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('negocio_casa', [null=>'Selecciona', 1=>'No', 2=>'Si'], null, ['id'=>'direccion'])}}
                            <span class="message-error">{{$errors->first('negocio_casa')}}</span>
                        </label>
                    </div>
                    <div id="divDireccion" @if($empresa->negocio_casa!=1&&!$errors->first('calle')&&!$errors->first('num_ext')&&!$errors->first('num_int')&&!$errors->first('colonia')&&!$errors->first('municipio')&&!$errors->first('cp')&&!$errors->first('estado')) style="visibility: hidden" @endif>
                        <div class="col-md-4 espacio_abajo">
                            {{Form::label('calle', 'Calle', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-book"></i>{{Form::text('calle', null, ['id'=>'calleEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('calle')}}</span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-3 espacio_abajo">
                            {{Form::label('num_ext', 'N&uacute;mero Exterior', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_ext', null, ['id'=>'num_extEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('num_ext')}}</span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-3 espacio_abajo">
                            {{Form::label('num_int', 'N&uacute;mero Interior', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-slack"></i>{{Form::text('num_int', null, ['id'=>'num_intEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('num_int')}}</span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-4 espacio_abajo">
                            {{Form::label('colonia', 'Colonia o Fraccionamiento', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-book"></i>{{Form::text('colonia', null, ['id'=>'coloniaEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('colonia')}}</span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-4 espacio_abajo">
                            {{Form::label('municipio', 'Municipio', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-book"></i>{{Form::text('municipio', null, ['id'=>'municipioEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('municipio')}}</span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-2 espacio_abajo">
                            {{Form::label('cp', 'C&oacute;digo Postal', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-book"></i>{{Form::text('cp', null, ['id'=>'cpEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('cp')}}</span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('estado', 'Estado', ['class' => 'label'])}}
                            <label class="select">
                                {{Form::select('estado', [null=>'Selecciona un Estado','Aguascalientes'=>'Aguascalientes', 'Baja California'=>'Baja California',
                                'Baja California Sur'=>'Baja California Sur', 'Campeche'=>'Campeche','Coahuila'=>'Coahuila',
                                'Colima'=>'Colima', 'Chiapas'=>'Chiapas', 'Chihuahua'=> 'Chihuahua', 'Distrito Federal'=>'Distrito Federal',
                                'Durango'=>'Durango', 'Guanajuato'=>'Guanajuato', 'Guerrero'=>'Guerrero', 'Hidalgo'=>'Hidalgo', 'Jalisco'=>'Jalisco',
                                'Estado de México'=>'Estado de México', 'Michoacán'=>'Michoacán', 'Morelos'=>'Morelos', 'Nayarit'=>'Nayarit',
                                'Nuevo León'=>'Nuevo León', 'Oaxaca'=>'Oaxaca', 'Puebla'=>'Puebla', 'Querétaro'=>'Querétaro',
                                'Quintana Roo'=>'Quintana Roo', 'San Luis Potosí'=>'San Luis Potosí', 'Sinaloa'=>'Sinaloa', 'Sonora'=>'Sonora',
                                'Tabasco'=>'Tabasco', 'Tamaulipas'=>'Tamaulipas','Tlaxcala'=>'Tlaxcala','Veracruz'=>'Veracruz','Yucatán'=>'Yucatán',
                                'Zacatecas'=>'Zacatecas'], null, ['id'=>'estadoEmp'])}}
                                @if(Session::get('form')==2)
                                    <span class="message-error">{{$errors->first('estado')}}</span>
                                @endif
                            </label>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo">
                        {{Form::label('financiamiento', '* ¿Desea un  acceder un financiamiento?', ['class' => 'label'])}}
                        <label class="select">
                            {{Form::select('financiamiento', [null=> 'Selecciona', 1=>'No', 2=>'Si'], null, ['id'=>'desea'])}}
                            <span class="message-error">{{$errors->first('financiamiento')}}</span>
                        </label>
                    </div>
                    <div id="divFinanciamiento" @if($empresa->financiamiento!=2&&!$errors->first('monto_financiamiento')&&!$errors->first('costo_proyecto')&&!$errors->first('aportacion')) style="visibility: hidden" @endif>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('monto_financiamiento', 'Monto a solicitar del financiamiento', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-money"></i>{{Form::text('monto_financiamiento', null, ['id'=>'monto_financiamiento', 'data-prefix'=>"$ "])}}
                                <span class="message-error">{{$errors->first('monto_financiamiento')}}</span>
                            </label>
                        </div>
                        <div class="col-md-6 espacio_abajo">
                            {{Form::label('costo_proyecto', 'Costo total del proyecto', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-money"></i>{{Form::text('costo_proyecto', null, ['id'=>'costo_proyecto', 'data-prefix'=>"$ "])}}
                                <span class="message-error">{{$errors->first('costo_proyecto')}}</span>
                            </label>
                        </div>
                        <div class="col-md-5 espacio_abajo">
                            {{Form::label('aportacion', 'Aportación de Emprendedor', ['class' => 'label'])}}
                            <label class="input">
                                <i class="icon-prepend fa fa-money"></i>{{Form::text('aportacion', null, ['id'=>'aportacion', 'data-prefix'=>"$ "])}}
                                <span class="message-error">{{$errors->first('aportacion')}}</span>
                            </label>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-5 espacio_abajo">
                        {{Form::label('logo', 'Logo de la Empresa', ['class' => 'label'])}}
                        {{Form::file('logo', ['accept'=>"image/*", 'id'=>'logo'.$empresa->id])}}
                        <span class="message-error">{{$errors->first('logo')}}</span>
                        <div class="note"><strong>Nota:</strong>La imagen debe medir 300 x 300</div>
                        <script>
                            $("#logo{{$empresa->id}}").fileinput({
                                previewFileType: "image",
                                initialPreview: [
                                    "<img src='{{url('Orb/images/empresas/'.$empresa->logo)}}' class='file-preview-image'>"
                                ],
                                browseClass: "btn btn-success",
                                browseLabel: " Selecciona otro Logo ",
                                browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                                showCaption: false,
                                showUpload: false,
                                showRemove: false
                            });
                        </script>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="col-md-6 espacio_abajo" >
                        {{ Form::submit('Guardar', ['class'=>'btn btn-info'])}}
                    </div>
                    <div class="col-md-5 espacio_abajo" style="text-align: right;">
                        * Los campos son obligatorios
                    </div>
                </fieldset>
            {{Form::close()}}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('Orb/bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js') }}
    <script type="text/javascript">
        $( "#direccion" ).change(function() {
            if(direccion.selectedIndex == 1)
                $( "#divDireccion" ).css('visibility', 'visible');
            else {
                $("#divDireccion").css('visibility', 'hidden');
                $("#calleEmp").val('');
                $("#num_extEmp").val('');
                $("#num_intEmp").val('');
                $("#coloniaEmp").val('');
                $("#municipioEmp").val('');
                $("#cpEmp").val('');
                $("#estadoEmp").val('');
            }
        });
        $( "#desea" ).change(function() {
            if (desea.selectedIndex == 2)
                $("#divFinanciamiento").css('visibility', 'visible');
            else
            {
                $("#divFinanciamiento").css('visibility', 'hidden');
                $("#monto_financiamiento").val('');
                $("#costo_proyecto").val('');
                $("#aportacion").val('');
            }
        });
    </script>
@stop