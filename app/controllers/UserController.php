<?php

use Incubamas\Managers\ValidatorManager;
use Incubamas\Repositories\UserRepo;
use Incubamas\Managers\UsuariosManager;

class UserController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->userRepo=$userRepo;
    }

    public function getIndex()
    {

    }

    public function getEditar($user_id = null)
    {
        if($user_id==null)
            $usuario = \Auth::user();
        else
            $usuario = $this->userRepo->usuario($user_id);
        $this->layout->content = View::make('users.update', compact('usuario'));
    }

    public function postEditar()
    {
        $usuario = $this->userRepo->usuario(Input::get('id'));
        if(count($usuario)>0)
        {
            $manager = new UsuariosManager($usuario, Input::all());
            $manager->save();
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getError()
    {
        $this->layout->content = View::make('users.error');
    }

    public function postError()
    {
        $manager = new ValidatorManager('error', Input::all());
        $manager->validar();

        if(Input::hasfile('foto'))
        {
            $archivo = 'error.' . Input::file('foto')->getClientOriginalExtension();
            Input::file('foto')->move('Orb/images/correo', $archivo);
            $imagen = true;
            $tabla = 'Orb/images/correo/'.$archivo;
        }
        else{
            $imagen = false;
            $tabla = 'No disponible';
        }

        $this->_mail('emails.estandar',
            ['titulo'=>'Reporte de eror', 'mensaje'=>'<p><strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> reporta el siguiente error:</p> <p>'.Input::get('descripcion').'</p>', 'seccion'=>"Imagen del error", 'imagen' => $imagen,
                'tabla' => $tabla], 'Error de Incubamas', 'lau_lost@hotmail.com', 'Laura Gasca');
        return Redirect::back()->with(array('confirm' => 'Se ha enviado el correo, resolveremos el problema a la brevedad.'));
    }

    public function getActivar($user_id)
    {
        $this->_soloAsesores();
        $user = $this->userRepo->usuario($user_id);
        if(count($user)>0)
        {
            if($user->active == 0)
            {
                $user->active = 1;
                $user->save();
                if($user->facebook_id=='')
                {
                    $password = $this->userRepo->actualizarPassword($user);
                    $tabla = "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: center;'><tr><td width='50%'><strong>Nombre de Usuario: </strong></td><td>".$user->user."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Contrase&ntilde;a: </strong></td><td>".$password."</td></tr></table><br/><br/><a target='_blank' href=\"".url('sistema')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #02384B; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Acceso al Sistema</a></div>";
                }else
                    $tabla = "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: center;'><tr><td width='100%'>Puede acceder mediante la opcion <strong>\"Conectar con Facebook\".</strong></td></tr></table><br/><br/><a target='_blank' href=\"".url('sistema')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #02384B; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Acceso al Sistema</a></div>";
                $this->_mail('emails.estandar',
                    ['titulo'=>'¡Su cuenta ha sido activada!', 'mensaje'=>'<p>Hola '.$user->nombre.' '.$user->apellidos.': </p> <p>Tu registro a concluido exitosamente, a partir de este momento puedes acceder a nuestro sistema.</p><p>Si tienes dudas no dudes en ponerte en contacto con nosotros.</p>', 'seccion'=>"Datos de Acceso", 'imagen' => false,
                        'tabla' => $tabla],
                    'Cuenta Activada', $user->email, $user->nombre.' '.$user->apellidos);
                return View::make('login.mensaje')->with(['titulo'=>'Activado', 'subtitulo' => 'La cuenta de '.$user->nombre.' '.$user->apellidos.' ha sido activada.',
                    'recomendacion' => 'Se notificara al usuario para que pueda ingresar al sistema.']);
            }else
                return View::make('login.mensaje')->with(['titulo'=>'Error', 'subtitulo' => 'Esta cuenta ya esta activa.',
            'recomendacion' => 'Por favor, verifique la URL o pongase en contacto con nosotros.']);
        }else
            return View::make('login.mensaje')->with(['titulo'=>'Error', 'subtitulo' => 'No podemos procesar su solicitur',
        'recomendacion' => 'Por favor, verifique la URL o pongase en contacto con nosotros.']);
    }

    public function getBloquear($user_id)
    {
        $this->_soloAsesores();
        $user = $this->userRepo->usuario($user_id);
        if(count($user)>0)
        {
            if($user->active == 0)
            {
                $user->active = 2;
                $user->save();
                if($user->facebook_id=='')
                {
                    $password = $this->userRepo->actualizarPassword($user);
                    $tabla = "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: center;'><tr><td width='50%'><strong>Nombre de Usuario: </strong></td><td>".$user->user."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Contrase&ntilde;a: </strong></td><td>".$password."</td></tr></table><br/><br/><a target='_blank' href=\"".url('sistema')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #02384B; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Acceso al Sistema</a></div>";
                }else
                    $tabla = "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: center;'><tr><td width='100%'>Puede acceder mediante la opcion <strong>\"Conectar con Facebook\".</strong></td></tr></table><br/><br/><a target='_blank' href=\"".url('sistema')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #02384B; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Acceso al Sistema</a></div>";
                $this->_mail('emails.estandar',
                    ['titulo'=>'¡Su cuenta ha sido activada!', 'mensaje'=>'<p>Hola '.$user->nombre.' '.$user->apellidos.': </p> <p>Tu registro a concluido exitosamente, a partir de este momento puedes acceder a nuestro sistema.</p><p>Si tienes dudas no dudes en ponerte en contacto con nosotros.</p>', 'seccion'=>"Datos de Acceso", 'imagen' => false,
                        'tabla' => $tabla],
                    'Cuenta Activada', $user->email, $user->nombre.' '.$user->apellidos);
                return View::make('login.mensaje')->with(['titulo'=>'Bloqueado', 'subtitulo' => 'La cuenta de '.$user->nombre.' '.$user->apellidos.' ha sido bloqueada.',
                    'recomendacion' => 'Se notificara al usuario para que pueda ingresar al sistema.']);
            }else
                return View::make('login.mensaje')->with(['titulo'=>'Error', 'subtitulo' => 'Esta cuenta ya esta activa.',
                    'recomendacion' => 'Por favor, verifique la URL o pongase en contacto con nosotros.']);
        }else
            return View::make('login.mensaje')->with(['titulo'=>'Error', 'subtitulo' => 'No podemos procesar su solicitur',
                'recomendacion' => 'Por favor, verifique la URL o pongase en contacto con nosotros.']);
    }

    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

    private function _mail($plantilla, $variables, $asunto, $correo, $nombre)
    {
        Mail::send($plantilla, $variables,
            function ($message) use ($asunto, $correo, $nombre){
                $message->subject($asunto);
                $message->to($correo, $nombre);
            });
    }

}