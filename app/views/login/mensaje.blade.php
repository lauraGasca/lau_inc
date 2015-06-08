<!DOCTYPE html>
<html class="no-js sidebar-large">
<head>
    <meta charset="utf-8">
    <title>IncubaM&aacute;s | Incubadora de Negocios</title>
    <link rel="shortcut icon" href="{{{asset('/accio/images/favicon.ico')}}}">
    {{ HTML::style('pixit/css/icons/icons.min.css') }}
    {{ HTML::style('pixit/css/bootstrap.min.css') }}
    {{ HTML::style('pixit/css/plugins.min.css') }}
    {{ HTML::style('pixit/css/style.min.css') }}
    {{ HTML::script('/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}
</head>

<body class="error-page">
<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-3 col-xs-offset-1 col-xs-10">
        <div class="error-container" >
            <div class="error-main" style="margin-top: 15%;">
                <h1> {{$titulo}} </h1>
                <h3> {{$subtitulo}} </h3>
                <h4> {{$recomendacion}} </h4>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="copyright">© IncubaM&aacute;s 2015</div>
</div>
{{ HTML::script('/plugins/jquery-1.11.js') }}
{{ HTML::script('/plugins/bootstrap/bootstrap.min.js') }}
{{ HTML::script('/plugins/nprogress/nprogress.js') }}
{{ HTML::script('/js/application.js') }}
</body>

</html>
