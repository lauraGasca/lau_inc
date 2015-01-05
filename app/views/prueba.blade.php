<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Comet Test</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
(function($){
function handleResponse(response){
$('#content').append('<div>' + response['msg'] + '</div>');
}

var timestamp = 0;
var url = '{{url('chat/backend')}}';
var noerror = true;
var ajax;

function connect() {
ajax = $.ajax(url, {
type: 'get',
data: { 'timestamp' : timestamp },
success: function(transport) {
eval('var response = '+transport);
timestamp = response['timestamp'];
handleResponse(response);
noerror = true;
},
complete: function(transport) {
(!noerror) && setTimeout(function(){ connect() }, 5000) || connect();
noerror = false;
}
});
}

$(document).ready(function(){
connect();
});
})(jQuery);
</script>
</head>
<body>
<div id="content">hola</div>
<div style="margin: 5px 0;">
<form id="cometForm"  method="get">
<input id="word" type="text" name="word" value=""/>
<input type="submit" name="submit" value="Send"  onclick="enviar()"/>
</form>
</div>
  <script type="text/javascript" src="{{ URL::asset('Orb/js/vendors/jquery/jquery.min.js') }}"></script>
  <script>
      function doRequest(request) {
        $.ajax('{{url('chat/backend')}}', {
          type: 'get',
          data: { 'msg' : request }
        });
        alert(request)
      }
      function enviar() {
        doRequest($('#word').val());
        $('#word').val('');
        return false;
      }
  </script>
</body>
</html>