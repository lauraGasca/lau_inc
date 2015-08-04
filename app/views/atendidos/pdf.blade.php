<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Personas Atendidas</title>
        <style>html{font-family:sans-serif;font-size: 12px;font-weight: 300;}  .jumbotron{background-color:#eee}  th, td {border: 1px solid #aaa;  border-collapse: collapse;  }  table{border-collapse: collapse;  }</style>
    </head>

    <body>
    <div class="container">
        <div class="header">
            <div style="position:float; float: right; ">

                <div style="position:float; float: right; text-align: right;">
                    <span style="font-size: 25px;">IncubaM&aacute;s</span><br/>
                    <span>Sinaloa Ote No. 119</span><br/>
                    <span>Col. Alameda</span><br/>
                    <span>Celaya, Gto</span><br/>
                    <span>M&eacute;xico</span><br/>
                </div>
                <div style="position: absolute; top:0px;">
                    {{ HTML::image('Orb/images/Logo_footer.png', 'Logo Incubamas', array('style' => 'width:40%')) }}
                </div>
            </div>
        </div>
        <br/><br/>
        <div class="jumbotron" style="padding: 0px; line-height: 5px; margin:0px;">
            <p> &nbsp; Fecha: {{strftime("%d de %B, %Y", strtotime(date("Y-m-d H:i:s")))}}</p>
        </div>
        <br/><br/>

        <div class="col-md-6 col-md-offset-3  jumbotron" id="naranja">
            <h2>Saludo</h2>
            <p>Explicacion del objetivo de la vinculacion</p>
            <p>Firmar el contrato</p>
        </div>

        <ul>
            <li>IFE</li>
            <li>CURP</li>
            <li>Comprobante de domicilio</li>
            <li>Cotizaciones</li>
            <li>RFC</li>
        </ul>

        <br/><br/>
            <span style="font-size: 12px;"><p><strong>Sinaloa Ote 119 Alameda, Celaya, Guanajuato</strong></p>
                        <p>Visitanos: <a href="http://incubamas.com/" target="_blank">http://incubamas.com/</a></p>
                        <p><strong>Horarios:</strong> 9:00 - 13:00 / 15:00 - 18:00<p>
                        <p><strong>Email:</strong> <a href="mailto:hola@incubamas.com">hola@incubamas.com</a></p></span>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <br/><br/><br/><br/><br/>
        <div style="position:float; float: right; text-align: right;">
            <span style="font-size: 18px;">www.IncubaMas.com</span><br/>
        </div>
    </div>
    </body>
</html>