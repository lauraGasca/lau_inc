<?php

Route::get('/', ['as' => 'home', 'uses' =>'IncubaController@home']);
Route::post('contacto', ['as' => 'contacto', 'uses' =>'IncubaController@contacto']);
Route::post('emprendedor', ['as' => 'contacto', 'uses' =>'IncubaController@emprendedor']);
Route::get('nuestros-emprendedores', ['as' => 'todos', 'uses' =>'IncubaController@casos']);
Route::get('nuestros-emprendedores/{slug}/{id}', ['as' => 'emprendedores', 'uses' =>'IncubaController@caso']);
Route::get('nuestros-emprendedores/{tipo}/{slug}/{id?}', ['as' => 'servicio', 'uses' =>'IncubaController@caso_tipo']);
Route::get('incuba/blog/{id}', ['as' => 'blog_ant', 'uses' =>'IncubaController@blog_ant']);
Route::get('blogs', ['as' => 'todos', 'uses' =>'IncubaController@blogs']);
Route::get('blogs/{slug}/{id}', ['as' => 'blogs', 'uses' =>'IncubaController@blog']);
Route::any('blogs/{tipo}/{slug?}/{id?}', ['as' => 'categoria', 'uses' =>'IncubaController@blog_tipo']);
Route::get('incubacion', ['as' => 'incubacion', 'uses' =>'IncubaController@incubacion']);
Route::post('incubacion', ['as' => 'incubacion', 'uses' =>'IncubaController@enviar_incubacion']);

Route::controller('blog', 'BlogController');
Route::controller('usuarios', 'UserController');
Route::controller('sistema', 'LoginController');
Route::controller('casos', 'CasoController');
Route::controller('emprendedores', 'EmprendedoresController');
Route::controller('chat', 'ChatController');
Route::controller('calendario', 'CalendarController');
Route::controller('atendidos', 'AtendidoController');
Route::controller('plan-negocios', 'ProyectoController');

//Funcion para mostrar cuando una pagina no se encuentra
App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});

Route::get('pruebas', function()
{
    /*$blogs = Blogs::all();
    foreach($blogs as $blog)
    {
        $comentarios = \Incubamas\Entities\Comentarios::where('entrada_id','=',$blog->id)->get();
        $blog->comentarios = count($comentarios);
        $blog->save();
    }*/

    /*$blogs = Blogs::all();
    foreach($blogs as $blog){

        $palabra = $blog->titulo;
        $palabra = strip_tags($palabra);
        $buscar = array("á", "é", "í", "ó", "ú", "ä", "ë", "ï", "ö", "ü", "à", "è", "ì", "ò", "ù", "ñ", ".", ";", ":", "¡", "!", "¿", "?", "/", "*", "+", "´", "{", "}", "¨", "â", "ê", "î", "ô", "û", "^", "#", "|", "°", "=", "[", "]", "<", ">", "`", "(", ")", "&", "%", "$", "¬", "@", "Á", "É", "Í", "Ó", "Ú", "Ä", "Ë", "Ï", "Ö", "Ü", "Â", "Ê", "Î", "Ô", "Û", "~", "À", "È", "Ì", "Ò", "Ù", "_", "\\", ",", "'", "²", "º", "ª");
        $rempl = array("a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "n", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "a", "e", "i", "o", "u", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "", "A", "E", "I", "O", "U", "_", " ", " ", " ", " ", " ", " ");
        $palabra = str_replace($buscar, $rempl, $palabra);
        $find = array(' ',);
        $palabra = str_replace($find, '-', $palabra);
        $palabra = preg_replace('/--+/', '-', $palabra);
        $palabra = trim($palabra, '-');
        $palabra = substr (strip_tags($palabra), 0, 100);

        $blog->slug = $palabra;
        $blog->save();
    }*/

    /*$casos = Casos::all();
    foreach($casos as $caso){

        $palabra = $caso->nombre_proyecto;
        $palabra = strip_tags($palabra);
        $buscar = array("á", "é", "í", "ó", "ú", "ä", "ë", "ï", "ö", "ü", "à", "è", "ì", "ò", "ù", "ñ", ".", ";", ":", "¡", "!", "¿", "?", "/", "*", "+", "´", "{", "}", "¨", "â", "ê", "î", "ô", "û", "^", "#", "|", "°", "=", "[", "]", "<", ">", "`", "(", ")", "&", "%", "$", "¬", "@", "Á", "É", "Í", "Ó", "Ú", "Ä", "Ë", "Ï", "Ö", "Ü", "Â", "Ê", "Î", "Ô", "Û", "~", "À", "È", "Ì", "Ò", "Ù", "_", "\\", ",", "'", "²", "º", "ª");
        $rempl = array("a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "n", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "a", "e", "i", "o", "u", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "", "A", "E", "I", "O", "U", "_", " ", " ", " ", " ", " ", " ");
        $palabra = str_replace($buscar, $rempl, $palabra);
        $find = array(' ',);
        $palabra = str_replace($find, '-', $palabra);
        $palabra = preg_replace('/--+/', '-', $palabra);
        $palabra = trim($palabra, '-');

        $caso->slug = $palabra;
        $caso->save();
    }*/


    /*$arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );
    $url="https://scontent-sjc.xx.fbcdn.net/hphotos-xap1/v/t1.0-9/1544393_799536043415816_141378394044896736_n.jpg?oh=a69614df8b835cd4894943d9a75a0b64&oe=559B90D0";
    $contents=file_get_contents($url, false, stream_context_create($arrContextOptions));
    $save_path=public_path()."/Orb/images/emprendedores/google.png";
    file_put_contents($save_path,$contents);*/
    /*$asesores = Asesor::all();
    foreach($asesores as $asesor){
        $usuario = User::find($asesor->user_id);
        $usuario->nombre = $asesor->nombre;
        $usuario->apellidos = $asesor->apellidos;
        $usuario->email = $asesor->email;
        $usuario->puesto = $asesor->puesto;
        $usuario->foto = $asesor->foto;
        $usuario->save();
    }*/

    /*$emprendedores = Emprendedor::all();
    foreach($emprendedores as $emprendedor){
        $usuario = User::find($emprendedor->user_id);
        $usuario->nombre = $emprendedor->name;
        $usuario->apellidos = $emprendedor->apellidos;
        $usuario->email = $emprendedor->email;
        $usuario->puesto = 'Emprendedor';
        $usuario->foto = $emprendedor->imagen;
        $usuario->save();
    }*/
    /*Mail::send('emails.atendidos', [],function ($message) {
            $message->subject('Prueba');
            $message->to('lau_lost@hotmail.com', 'Laura');
        });*/

    /*
    $this->_mail('emails.estandar', ['titulo'=>"Solicitud de Cita", 'seccion' => "Detalles de la Cita", 'imagen' => false,
        'mensaje'=>'<p>Hola <strong>Nombre Asesor</strong>:</p><p> El emprendedor <strong>Nombre del emprendedor</strong> ha solicitado una cita contigo en el sistema.</p>',
        'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>15 de Mayo del 2015</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>9:00 hrs</td></tr>" . $asunto . "</table><br/><br/></div>
    <div align='center'><a href=\"".url('calendario/confirmar/')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Confirmar</a> &nbsp;&nbsp;
    <a href=\"".url('calendario/cancelar/')."\" style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #B33C3C; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Cancelar</a></div>"],
        'Solicitud de Cita', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
    */

    /*$titulo = "Confirmacion de Cita";
    $mensaje = '<p>Hola <strong>Nombre Asesor</strong>:</p><p> El emprendedor <strong>Nombre del emprendedor</strong> ha solicitado una cita contigo en el sistema.</p>';
    $seccion = "Detalles de la Cita";
    $imagen = false;
    $asunto = '<tr><td><strong>Asunto: </strong></td><td>Asunto indicado en el formulario</td></tr>';
    $tabla = "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>15 de Mayo del 2015</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>9:00 hrs</td></tr>" . $asunto . "</table><br/><br/></div>
    <div align='center'><a href=\"".url('calendario/confirmar/')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Confirmar</a> &nbsp;&nbsp;
    <a href=\"".url('calendario/cancelar/')."\" style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #B33C3C; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Cancelar</a></div>";

    return View::make('emails.estandar', compact('titulo', 'mensaje', 'seccion', 'imagen', 'tabla'));*/

    $value = '07/05/2015 12:00';
    echo $value.'<br/>';
    $sistema = strtotime(substr($value, 6, 4) . "-" . substr($value, 3, 2) . "-" . substr($value, 0, 2) . " " . substr($value, 10, 6)) * 1000;
    echo $sistema.'<br/>';
    echo strftime("%d de %B de %Y a las %H:%M hrs", ($sistema/1000));
});
