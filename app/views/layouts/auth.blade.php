<!DOCTYPE html>

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IncubaM&aacute;s | Iniciar sesi&oacute;n</title>
        <link href="{{ URL::asset('Orb/css/styles.css') }}" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('Orb/favicon.ico') }}" />
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/modernizr/modernizr.custom.js') }}"></script>
    </head>
    
    <body>
        <div class="colorful-page-wrapper">
          <div class="center-block">
            <div class="login-block">
                @section('formulario')
                @show
            </div>
            <div class="copyrights">
              Creado por IncubaM&aacute;s &copy; 2014 </div>
          </div>
        </div>
            
        <!--Scripts-->
        <!--JQuery--> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/jquery/jquery.min.js') }}"></script> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/jquery/jquery-ui.min.js') }}"></script> 
        <!--Fullscreen--> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/fullscreen/screenfull.min.js') }}"></script> 
        <!--Sparkline--> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/sparkline/jquery.sparkline.min.js') }}"></script> 
        <!--Main App--> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/scripts.js') }}"></script>
        <!--Forms--> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.form.min.js') }}"></script> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.validate.min.js') }}"></script> 
        <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/forms/jquery.maskedinput.min.js') }}"></script> 
        <script type="text/javascript" src="{{ URL::asset('Orb/s/vendors/jquery-steps/jquery.steps.min.js') }}"></script> 
        <!--/Scripts-->
    
    </body>
        
</html>