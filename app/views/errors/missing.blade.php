<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title>IncubaM&aacute;s | 404 Error</title>
        {{ HTML::style('Orb/css/styles.css') }}
        {{ HTML::script('Orb/js/vendors/modernizr/modernizr.custom.js') }}
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('Orb/favicon.ico') }}" />
    </head>
    <body>
        <div class="standalone-page-wrapper">
            <div class="error-top-block">
                <div class="error-top-block-image">
                    {{ HTML::image('Orb/images/error-robot.png') }}
                </div>
            </div>
            <div class="error-bottom-block">
                <div class="col-md-6 col-md-offset-3 error-description">
                    <div class="error-code">Error 404</div>
                    <div class="error-meaning">Pagina no encontrada</div>
                    <div class="todo">
                        <h4>¿Que hacer?</h4>
                        Lo sentimos, pero la pagina que estabas buscando no se ha encontrado en el servidor. Intente verificar si ha escrito correctamente la URL, entonces refresque la pagina.
                    </div>
                    <br/><br/><br/><br/>
                    <div class="copyrights">
                        <a>IncubaM&aacute;s</a> &copy; 2014
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>