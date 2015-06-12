<!DOCTYPE html>
<html lang="es">
    <head>
        <style>html{font-family:sans-serif;font-size: 12px;font-weight: 300;}  .jumbotron{background-color:#eee}  th, td {border: 1px solid #aaa;  border-collapse: collapse;  }  table{border-collapse: collapse;  }</style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div style="position:float; float: right; ">
                    {{ HTML::image('Orb/images/pagado.jpg', 'Pagado', array('style' => 'width:15%; padding-left: 600px; padding-top:0px')) }}
                    <br/><br/>
                    <div style="position:float; float: right; text-align: right;">
                        <span style="font-size: 25px;">IncubaM&aacute;s</span><br/>
                        <span>Sinaloa Ote No. 119</span><br/>
                        <span>Col. Alameda</span><br/>
                        <span>Celaya, Gto</span><br/>
                        <span>M&eacute;xico</span><br/>
                    </div>
                    <div style="position: absolute; top:120px;">
                        {{ HTML::image('Orb/images/Logo_footer.png', 'Logo Incubamas', array('style' => 'width:40%')) }}
                    </div>
                </div>
            </div>
            <br/><br/>
            <div class="jumbotron" style="padding: 0px; line-height: 5px; margin:0px;">
                <p style="font-size: 20px;"><strong> &nbsp; Orden No. {{$pago->id}}</strong></p>
                <p> &nbsp; Fecha del Recibo: {{strftime("%d/%b/%Y", strtotime(date('d-m-Y')));}}</p>
            </div>
            <br/><br/>
            <div style="position:float; float: right; text-align: left;">
                <span style="font-size: 20px;"><strong>A nombre de </strong></span><br/>
                <span>{{utf8_decode($emprendedor->usuario->nombre)}} {{utf8_decode($emprendedor->usuario->apellidos)}}</span><br/>
                @if($solicitud->empresa_id <> '' && $solicitud->empresa->negocio_casa<>2)
                    <span>
                        {{utf8_decode($solicitud->empresa->calle)}} No. {{utf8_decode($solicitud->empresa->num_ext)}}
                        @if($pago->num_int<>"")
                            No. exterior {{utf8_decode($solicitud->empresa->num_int)}}
                        @endif
                    </span><br/>
                    <span>Col. {{utf8_decode($solicitud->empresa->colonia)}}, C.P {{$solicitud->empresa->cp}}</span><br/>
                    <span>{{utf8_decode($solicitud->empresa->municipio)}}, {{utf8_decode($solicitud->empresa->estado)}}</span><br/>
                @else
                    <span>
                        {{utf8_decode($emprendedor->calle)}} No. {{utf8_decode($emprendedor->num_ext)}}
                        @if($emprendedor->num_int<>"")
                            No. exterior {{utf8_decode($emprendedor->num_int)}}
                        @endif
                    </span><br/>
                    <span>Col. {{utf8_decode($emprendedor->colonia)}}, C.P {{$emprendedor->cp}}</span><br/>
                    <span>{{utf8_decode($emprendedor->municipio)}}, {{utf8_decode($emprendedor->estado)}}</span><br/>
                @endif                
                <span>M&eacute;xico</span><br/>
            </div>
            <br/><br/>
            <table style="width:100%; ">
                <tr BGCOLOR="#eee">
                    <td style="text-align: center;"><strong>Descripci&oacute;n</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;">Pago de servicio de: {{utf8_decode($solicitud->nombre)}}</td>
                    <td style="text-align: center;">{{$pago->monto_total}}</td>
                </tr>
                <tr BGCOLOR="#eee">
                    <td style="text-align: right;"><strong>Subtotal&nbsp; </strong></td>
                    <td style="text-align: center;">{{$pago->monto_total}}</td>
                </tr>
                <tr BGCOLOR="#eee">
                    <td style="text-align: right;"><strong>Impuestos&nbsp; </strong></td>
                    <td style="text-align: center;">-</td>	
                </tr>
                <tr style="border: none;">
                    <td style="text-align: right; border: none;"><strong>Total&nbsp; </strong></td>
                    <td style="text-align: center; border: none;">{{$pago->monto_total}}</td>
                </tr>
            </table>                
            <br/><br/><br/>
            <h3>Transacciones</h3>
            <table style="width:100%; ">
                <tr BGCOLOR="#eee">
                    <td style="text-align: center;"><strong>Fecha de la Transacci&oacute;n</strong></td>
                    <td style="text-align: center;"><strong>Forma de Pago</strong></td>
                    <td style="text-align: center;"><strong>Recibido por</strong></td>
                    <td style="text-align: center;"><strong>Fecha del Siguiente Pago</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">{{$pago->emision}}</td>
                    <td style="text-align: center;">Efectivo</td>
                    <td style="text-align: center;">{{utf8_decode($asesor->nombre)}}  {{utf8_decode($asesor->apellidos)}}</td>
                    @if($solicitud->estado=='Liquidado')
                        <td style="text-align: center;">Cuenta Liquidada</td>
                    @else
                        <td style="text-align: center;">{{$pago->siguiente}}</td>
                    @endif
                </tr>
            </table>
            
            <br/><br/>
            <span style="font-size: 12px;">Este recibo no es una factura por lo que no tiene validez fiscal y
            se genera s&oacute;lo para fines informativos. En caso de requerir factura, solicitarla a
            contabilidad@incubamas.com en un plazo no mayor a 30 d&iacute;as despu&eacute;s de la emisi&oacute;n de este recibo.</span>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <br/><br/><br/><br/><br/>
            <div style="position:float; float: right; text-align: right;">
                <span style="font-size: 18px;">www.IncubaMas.com</span><br/>
            </div>
        </div>
    </body>
</html>