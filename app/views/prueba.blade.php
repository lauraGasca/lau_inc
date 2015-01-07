@extends('layouts.sistema')

@section('css')
    @parent
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link href="{{ URL::asset('Orb/css/vendors/x-editable/select2.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('Orb/css/vendors/x-editable/bootstrap-editable.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        (function ($) {
            function handleResponse(response) {
                $('#content').append('<div>' + response['msg'][0].cuerpo + '</div>');
            }

            var timestamp = 0;
            var url = '{{url('chat/backend/1')}}';
            var noerror = true;
            var ajax;

            function connect() {
                ajax = $.ajax(url, {
                    type: 'get',
                    data: {'timestamp': timestamp},
                    success: function (transport) {
                        eval('var response = ' + transport);
                        timestamp = response['timestamp'];
                        handleResponse(response);
                        noerror = true;
                    },
                    complete: function (transport) {
                        (!noerror) && setTimeout(function () {
                            connect()
                        }, 5000) || connect();
                        noerror = false;
                    }
                });
            }

            function doRequest(request) {
                $.ajax(url, {
                    type: 'get',
                    data: { 'msg' : request }
                });
            }

            $(document).ready(function () {
                connect();
            });
        })(jQuery);
    </script>
@stop

@section('chat')
    class="active"
@stop

@section('mapa')
    <li><a href="#"><i class="fa fa-home"></i></a></li>
    <li class="active">Chat</li>
@stop

@section('titulo-seccion')
    <h1>Chat <small> Listado</small></h1>
@stop

@section('contenido')
<div style="margin: 5px 0;">
    <div id="content"></div>
    <form id="cometForm" method="get">
        <input id="word" type="text" name="word" value=""/>
        <input type="submit" name="submit" value="Send"/>
    </form>
</div>
@stop

@section('scripts')
    @parent
    <script>
        var url = '{{url('chat/backend/1')}}';
        $('#cometForm').submit(function( event ) {
            event.preventDefault();
            doRequest($('#word').val());
            $('#word').val('');
        });
        function doRequest(request) {
            $.ajax(url, {
                type: 'get',
                data: { 'msg' : request }
            });
        }
    </script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/bootstrap-filestyle.js') }}"></script>
    <!--X-Editable-->
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/bootstrap-editable.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/demo-mock.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/select2.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/x-editable/jquery.mockjax.js') }}"></script>
@stop