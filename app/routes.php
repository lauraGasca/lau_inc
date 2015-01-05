<?php

Route::get('/', function()
{
    return Redirect::to('incuba');
});

Route::get('pruebas', function()
{
    return View::make('emails.confirmacion');
});

Route::controller('incuba', 'IncubaController');
Route::controller('blog', 'BlogController');
Route::controller('usuarios', 'UserController');
Route::controller('sistema', 'SistemaController');
Route::controller('casos', 'CasoController');
Route::controller('emprendedores', 'EmprendedoresController');
Route::controller('chat', 'ChatController');
Route::controller('calendario', 'CalendarController');

//Funcion para mostrar cuando una pagina no se encuentra
App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});