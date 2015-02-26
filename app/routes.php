<?php

/*Route::get('/', function()
{
    return Redirect::to('incuba');
});*/

Route::get('pruebas', function()
{
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
    return View::make('emails.atendidos');
});

Route::get('/', ['as' => 'home', 'uses' =>'IncubaController@getIndex']);
Route::controller('incuba', 'IncubaController');
Route::controller('blog', 'BlogController');
Route::controller('usuarios', 'UserController');
Route::controller('sistema', 'SistemaController');
Route::controller('casos', 'CasoController');
Route::controller('emprendedores', 'EmprendedoresController');
Route::controller('chat', 'ChatController');
Route::controller('calendario', 'CalendarController');
Route::controller('atendidos', 'AtendidoController');

//Funcion para mostrar cuando una pagina no se encuentra
App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});