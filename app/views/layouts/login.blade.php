<!DOCTYPE html>
<html>
    <head>
        <!-- BEGIN META SECTION -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="" name="description" />
        <meta content="themes-lab" name="author" />
        <title>
            @section('titulo')
                
                Incubamas
                
            @show
        </title>
        <!-- END META SECTION -->
        
        
        @section('css')
            <!-- BEGIN MANDATORY STYLE -->
            {{ HTML::style('pixit/css/icons/icons.min.css') }}
            {{ HTML::style('pixit/css/bootstrap.min.css') }}
            {{ HTML::style('pixit/css/plugins.min.css') }}
            {{ HTML::style('pixit/css/style.min.css') }}
            <!-- END  MANDATORY STYLE -->
            
            <!-- BEGIN PAGE LEVEL STYLE -->
            {{ HTML::style('pixit/css/animate-custom.css') }}
            <!-- END PAGE LEVEL STYLE -->

            <link rel="shortcut icon" href="{{ URL::asset('accio/images/favicon.ico') }}">
            {{ HTML::script('pixit/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}


        @show
        
    </head>
    
    <body class="login fade-in" data-page="login">
    
        <!-- BEGIN LOGIN BOX -->
        <div class="container" id="login-block">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
                    <div class="login-box clearfix animated flipInY">
                        <div class="page-icon animated bounceInDown">
                        
                            @section('imagen')
                                
                            @show
                            
                        </div>
                        <div class="login-logo">
                            <a href="#?login-theme-3">
                                {{ HTML::image('accio/images/Logo footer.png','IncubaMas') }}
                            </a>
                        </div>
                        <hr>
                        <div class="login-form">
                        
                            @section('contenido')
                                
                            @show
                            
                        </div>
                    </div>

                    <div class="social-login row">
                        <div class="fb-login col-lg-12 col-md-12 animated flipInX">
                            <a onclick="ventanaFB()" href="#" class="btn btn-facebook btn-block"><i class="fa fa-facebook"></i> | Conectar con <strong>Facebook</strong></a>
                        </div>
                    </div>
                    <script>
                        var miPopup
                        function ventanaFB(){
                            miPopup = window.open("{{url("sistema/fblogin")}}","miwin","width=600,height=400,scrollbars=yes")
                            miPopup.focus()
                        }
                    </script>


                </div>
            </div>
        </div>
        <!-- END LOGIN BOX -->
            
        @section('scripts')

            <!-- BEGIN MANDATORY SCRIPTS -->
            {{ HTML::script('pixit/plugins/jquery-1.11.js') }}
            {{ HTML::script('pixit/plugins/bootstrap/bootstrap.min.js') }}
            <!-- END MANDATORY SCRIPTS -->

            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            {{ HTML::script('pixit/plugins/backstretch/backstretch.min.js') }}
            {{ HTML::script('pixit/js/account.js') }}
            <!-- END PAGE LEVEL SCRIPTS -->

        @show
        
    </body>

</html>
