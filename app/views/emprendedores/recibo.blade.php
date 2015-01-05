<!DOCTYPE html>
<html lang="es">
    <head>
        <style>
            html{
                font-family:sans-serif;
                font-size: 12px;
                font-weight: 300;
            }
            .jumbotron{
                background-color:#eee
            }
            th, td {
                border: 1px solid #aaa;
                border-collapse: collapse;
            }
            table{
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div style="position:float; float: right; ">
                    <img src="{{URL::asset('Orb/images/pagado.jpg')}}" alt="Logo" style="width:15%; padding-left: 600px; padding-top:0px"/>
                    <br/><br/>
                    <div style="position:float; float: right; text-align: right;">
                        <span style="font-size: 25px;">IncubaM&aacute;s</span><br/>
                        <span>Divisi&oacute;n del Norte No. 124 B</span><br/>
                        <span>Col. El Vergel, C.P 38000</span><br/>
                        <span>Celaya, Gto</span><br/>
                        <span>M&eacute;xico</span><br/>
                    </div>
                    <div style="position: absolute; top:120px;">
                        <img src="{{URL::asset('Orb/images/Logo_footer.png')}}" alt="Logo" style="width:40%"/>
                    </div>
                </div>
            </div>
            <br/><br/>
            <div class="jumbotron" style="padding: 0px; line-height: 5px; margin:0px;">
                <p style="font-size: 20px;"><strong> &nbsp; Orden No. {{$pago->id}}</strong></p>
                <p> &nbsp; Fecha del Recibo: {{date('d-m-Y')}}</p>
            </div>
            <br/><br/>
            <div style="position:float; float: right; text-align: left;">
                <span style="font-size: 20px;"><strong>A nombre de </strong></span><br/>
                <span>{{utf8_decode($pago->name)}} {{utf8_decode($pago->apellido_emp)}}</span><br/>
                @if($pago->calle<>""||$pago->num_ext<>""||$pago->colonia<>""||$pago->cp<>""||$pago->municipio<>""||$pago->estado<>"")
                        <span>
                        {{utf8_decode($pago->calle)}} No. {{utf8_decode($pago->num_ext)}}
                        @if($pago->num_int<>"")
                            No. exterior {{utf8_decode($pago->num_int)}}
                        @endif
                    </span><br/>
                    <span>Col. {{utf8_decode($pago->colonia)}}, C.P {{$pago->cp}}</span><br/>
                    <span>{{utf8_decode($pago->municipio)}}, {{utf8_decode($pago->estado)}}</span><br/>
                @else
                        <span>
                        {{utf8_decode($pago->calle_2)}} No. {{utf8_decode($pago->num_ext_2)}}
                        @if($pago->num_int_2<>"")
                            No. exterior {{utf8_decode($pago->num_int_2)}}
                        @endif
                    </span><br/>
                    <span>Col. {{utf8_decode($pago->colonia_2)}}, C.P {{$pago->cp_2}}</span><br/>
                    <span>{{utf8_decode($pago->municipio_2)}}, {{utf8_decode($pago->estado_2)}}</span><br/>
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
                    <td style="text-align: center;">Pago de servicio de: {{utf8_decode($pago->servicios)}} para {{utf8_decode($pago->nombre_empresa)}}</td>
                    <td style="text-align: center;">$ {{number_format($pago->monto, 2, '.', ',');}}</td>
                </tr>
                <tr BGCOLOR="#eee">
                    <td style="text-align: right;"><strong>Subtotal&nbsp; </strong></td>
                    <td style="text-align: center;">$ {{number_format($pago->monto, 2, '.', ',');}}</td>	
                </tr>
                <tr BGCOLOR="#eee">
                    <td style="text-align: right;"><strong>Impuestos&nbsp; </strong></td>
                    <td style="text-align: center;">-</td>	
                </tr>
                <tr style="border: none;">
                    <td style="text-align: right; border: none;"><strong>Total&nbsp; </strong></td>
                    <td style="text-align: center; border: none;">$ {{number_format($pago->monto, 2, '.', ',');}}</td>	
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
                    <?php
                        $date = date_create($pago->fecha_emision);
                        $fecha=date_format($date, 'd-m-Y');
                    ?>
                    <td style="text-align: center;">{{$fecha}}</td>
                    <td style="text-align: center;">Efectivo</td>
                    <td style="text-align: center;">{{utf8_decode($pago->nombre)}}  {{utf8_decode($pago->apellidos)}}</td>
                    <?php
                        if($pago->siguiente_pago==null)
                            $fecha = "Cuenta Liquidada";
                        else{
                            $date = date_create($pago->siguiente_pago);
                            $fecha=date_format($date, 'd-m-Y');
                        }
                    ?>
                    <td style="text-align: center;">{{$fecha}}</td>
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
        </div> <!-- /container -->  
    </body>
</html>