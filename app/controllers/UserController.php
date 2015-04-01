<?php

use Incubamas\Managers\ValidatorManager;

class UserController extends BaseController
{
    protected $layout = 'layouts.sistema';

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function getIndex()
    {
        $users = User::all();
        return View::make('hello')->with('users', $users);
    }

    public function getError()
    {
        $this->layout->content = View::make('users.error');
    }

    public function postError()
    {
        $manager = new ValidatorManager('error', Input::all());
        $manager->validar();

        $titulo = Auth::user()->nombre.' '.Auth::user()->apellidos." reporta,";
        $mensaje = Input::get('descripcion');
        $seccion = "";
        if(Input::hasfile('foto'))
        {
            $archivo = 'error.' . Input::file('foto')->getClientOriginalExtension();
            Input::file('foto')->move('Orb/images/correo', $archivo);
            $imagen = true;
            $tabla = 'Orb/images/correo/'.$archivo;
        }
        else{
            $imagen = false;
            $tabla = '';
        }

        //return View::make('emails.estandar', compact('titulo', 'mensaje', 'seccion', 'imagen', 'tabla'));
        Mail::send('emails.estandar', compact('titulo', 'mensaje', 'seccion', 'imagen', 'tabla'),
            function ($message) {
                $message->subject('Error de Incubamas');
                $message->to('lau_lost@hotmail.com', 'Laura Gasca');
            });
        return Redirect::back()->with(array('confirm' => 'Se ha enviado el correo, resolveremos el problema a la brevedad.'));
    }

}