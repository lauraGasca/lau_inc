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
Route::controller('mensajes', 'ChatController');
Route::controller('calendario', 'CalendarController');
Route::controller('atendidos', 'AtendidoController');
Route::controller('plan-negocios', 'ProyectoController');
Route::controller('empresas', 'EmpresasController');
Route::controller('pagos', 'PagosController');
Route::controller('convocatorias', 'ConvocatoriaController');
Route::controller('sliders', 'SliderController');

//Funcion para mostrar cuando una pagina no se encuentra
App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});
