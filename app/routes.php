<?php

Route::get('/', ['as' => 'home', 'uses' =>'IncubaController@home']);
Route::post('contacto', ['as' => 'contacto', 'uses' =>'IncubaController@contacto']);
Route::post('emprendedor', ['as' => 'contacto', 'uses' =>'IncubaController@emprendedor']);
Route::get('nuestros-emprendedores', ['as' => 'todos', 'uses' =>'IncubaController@casos']);
Route::get('nuestros-emprendedores/{slug}/{id}', ['as' => 'emprendedores', 'uses' =>'IncubaController@caso']);
Route::get('nuestros-emprendedores/{tipo}/{slug}/{id?}', ['as' => 'servicio', 'uses' =>'IncubaController@caso_tipo']);
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

/*Route::get('/', function()
{
    return Redirect::to('incuba');
});*/

Route::get('pruebas', function()
{

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
    /*$titulo = "Laura Gasca escribe,";
    $mensaje = "Lorem ipsum dolor amet, consectetur adipiscing elit. Pellentesque ut lacus at velit consequat sodales. Ut posuere neque in molestie gravida. Integer neque lementum posuere purus. Nam convallis ipsum. Maecenas a vulputate ipsum. ";
    $seccion = "Datos de contacto";
    $imagen = false;
    $tabla = "<strong>Nombre de usuario: </strong>Este es su nombre<br/><br/><strong>Contrase&ntilde;a: </strong>contraseña";
    return View::make('emails.estandar', compact('titulo', 'mensaje', 'seccion', 'imagen', 'tabla'));*/
});
