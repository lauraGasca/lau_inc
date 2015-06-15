<?php

use Incubamas\Repositories\UserRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\SolicitudRepo;
use Incubamas\Repositories\BlogsRepo;
use Incubamas\Managers\FacebookManager;
use Incubamas\Managers\EmprendedorManager;
use Incubamas\Managers\UserManager;
use Incubamas\Managers\ValidatorManager;

class LoginController extends BaseController
{
    protected $layout = 'layouts.login';
    protected $userRepo;
    protected $emprendedoreRepo;
    protected $solicitudRepo;
    protected $blogRepo;

    public function __construct(UserRepo $userRepo, EmprendedoresRepo $emprendedoresRepo, SolicitudRepo $solicitudRepo, BlogsRepo $blogsRepo)
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->userRepo = $userRepo;
        $this->emprendedoreRepo = $emprendedoresRepo;
        $this->solicitudRepo = $solicitudRepo;
        $this->blogRepo = $blogsRepo;
    }
    
    public function getIndex($error=null)
    {
        if($error!=null) {
            $this->layout->content = View::make('login.index', compact("error"));
        }else {
            if (Auth::check()) {
                if (Auth::user()->active == 1|| Auth::user()->active == 2)
                    switch (Auth::user()->type_id) {
                        case 1:
                        case 2: return Redirect::to('emprendedores');
                        case 3: return Redirect::to('emprendedores/perfil/' . $this->emprendedoreRepo->userxemprendedor_id(Auth::user()->id));
                        case 4: return Redirect::to('blog');
                        default: return Redirect::back()->with(array('confirm' => 'No tiene permiso para acceder.'));
                    }
                Redirect::back()->with(array('confirm' => 'Su usuario no ha sido activado.'));
            }
            $this->layout->content = View::make('login.index');
        }
    }

    public function postLogin()
    {
        $data = Input::all();
        $credentials = ['user' => $data['user'], 'password' => $data['password']];
        if (Auth::attempt($credentials, Input::get('remember')))
        {
            if(Auth::user()->active == 1 || Auth::user()->active == 2) {
                $this->_verificar();
                switch (Auth::user()->type_id) {
                    case 1:
                    case 2:
                        return Redirect::to('emprendedores');
                    case 3:
                        return Redirect::to('emprendedores/perfil/' . $this->emprendedoreRepo->userxemprendedor_id(Auth::user()->id));
                    case 4:
                        return Redirect::to('blog');
                    default:
                        return Redirect::back()->with(array('confirm' => 'No tiene permiso para acceder.'));
                }
            }
            Redirect::back()->with(array('confirm' => 'Su usuario no ha sido activado.'));
        }
        return Redirect::back()->with('login_errors', true)->withInput();
    }

    public function getFblogin($auth=null)
    {
        if($auth == 'auth') {
            try {
                Hybrid_Endpoint::process();
            }catch(Exception $e){
                return Redirect::to('sistema/fblogin');
            }
            return;
        }
        $oauth = new Hybrid_Auth(app_path().'/config/facebook.php');
        $provider = $oauth->authenticate('Facebook');
        $profile = $provider->getUserProfile();

        $user = $this->userRepo->buscarxEmail($profile->email);
        if(count($user)>0){
            if($user->facebook_id=='') {
                $user->facebook_id = $profile->identifier;
                $user->save();
            }
            if($user->active == 1 ||$user->active == 1)
            {
                Auth::login($user);
                $this->_verificar();
                switch(Auth::user()->type_id)
                {
                    case 1: case 2: $direccion = 'emprendedores'; break;
                    case 3: $direccion = 'emprendedores/perfil/' . $this->emprendedoreRepo->userxemprendedor_id(Auth::user()->id); break;
                    case 4: $direccion = 'blog';
                }
                return '<html><head></head><body><script>
                    opener.location.href="' . url($direccion) . '"
                    window.close()
                </script></body></html>';
            }else {
                Session::put('resultado', 'error');
                return '<html><head></head><body><script>
                    opener.location.href="' . url('sistema') . '"
                    window.close()
                </script></body></html>';
            }
        }else{
            $user = $this->userRepo->newUser();
            $manager = new FacebookManager($user, ['nombre' => $profile->firstName, 'apellidos' => $profile->lastName, 'email' => $profile->email, 'facebook_id' => $profile->identifier]);
            $manager->save();
            if($profile->gender=='female')
                $genero = 'F';
            else
                $genero = 'M';
            $this->userRepo->guardarFoto($profile->photoURL,$user);

            $emprendedor = $this->emprendedoreRepo->newEmprendedor();
            $manager = new EmprendedorManager($emprendedor, ['user_id' => $user->id, 'genero'=> $genero, 'fecha_nacimiento'=>date("d/m/y"), 'fecha_ingreso'=>date("d/m/y")]);
            $manager->save();

            $this->_mail('emails.estandar',
                ['titulo'=>"Nuevo Registro a trav&eacute;s de <strong style='color: rgb(58, 87, 149);'>Facebook</strong> ", 'mensaje'=>'<p>Hola: </p> <p>Se ha registrado el usuario <strong>'.$user->nombre.' '.$user->apellidos.'</strong> usando la aplicaci&oacute;n de facebook.</p> <p>El correo de registro es <strong>'.$user->email.'</strong></p><p>Active el usuario para que pueda acceder libremente al sistema o bloquealo para que acceda, pero no podra realizar ninguna acci&oacute;n en el sistema.</p>',
                    'seccion'=>"Selecciona la acci&oacute;n que desees realizar", 'imagen' => false,
                    'tabla' => "<div align='center'><a href=\"".url('usuarios/activar/'.$user->id)."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Activar</a> &nbsp;&nbsp;<a href=\"".url('usuarios/bloquear/'.$user->id)."\" style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #B33C3C; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Bloquear</a></div>"],
                'Nuevo Usuario', 'hola@incubamas.com', 'IncubaMas' );

            Session::put('resultado', 'correcto');
            return '<html><head></head><body><script>
                    opener.location.href="' . url('sistema') . '"
                    window.close()
                </script></body></html>';
        }
    }
    
    public function getRegistrar()
    {
        $this->layout->content = View::make('login.registrar');
    }
    
    public function postRegistrar()
    {
        $registret = new ValidatorManager('registro',Input::all());
        $registret->validar();

        $password = '1234';
        $user = $this->userRepo->newUser();
        $manager = new UserManager($user, Input::all()+['password'=>$password]);
        $manager->save();

        $emprendedor = $this->emprendedoreRepo->newEmprendedor();
        $manager = new EmprendedorManager($emprendedor, ['user_id'=>$user->id, 'fecha_nacimiento' => Input::get('fecha_nacimiento'), 'fecha_ingreso'=>date("d/m/y")]);
        $manager->save();

       $this->_mail('emails.estandar',
            ['titulo'=>"Nuevo Registro", 'mensaje'=>'<p>Hola: </p> <p>Se ha registrado el usuario <strong>'.$user->nombre.' '.$user->apellidos.'</strong> a trav&eacute;z de la p&aacute;gina.</p> <p>El correo de registro es <strong>'.$user->email.'</strong></p><p>Active el usuario para que pueda acceder libremente al sistema o bloquealo para que acceda, pero no podra realizar ninguna acci&oacute;n en el sistema.</p>',
                'seccion'=>"Selecciona la acci&oacute;n que desees realizar", 'imagen' => false,
                'tabla' => "<div align='center'><a href=\"".url('usuarios/activar/'.$user->id)."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Activar</a> &nbsp;&nbsp;<a href=\"".url('usuarios/bloquear/'.$user->id)."\" style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #B33C3C; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Bloquear</a></div>"],
            'Registro', 'hola@incubamas.com', 'IncubaMas' );

        return Redirect::back()->with('confirm', 'Recibira un correo con sus datos de acceso cuando su usuario haya sido activado.');
    }
    
    public function getOlvidar()
    {
        $this->layout->content = View::make('login.olvidar');
    }

    public function postOlvidar()
    {
        $olvidar = new ValidatorManager('email',Input::all());
        $olvidar->validar();

        $user = $this->userRepo->buscarxEmail(Input::get('email'));
        if(count($user)>0){
            if($user->password<>'')
            {
                $password = $this->userRepo->actualizarPassword($user);
                $this->_mail('emails.estandar',
                    ['titulo'=>'Contrase&ntilde;a Actualizada', 'mensaje'=>'<p>Hola '.$user->nombre.' '.$user->apellidos.': </p> <p>Tal como lo solicitaste, tu contrase&ntilde;a para entrar al sistema ha sido actualizada.</p><p>Si tienes dudas no dudes en ponerte en contacto con nosotros.</p>', 'seccion'=>"Datos de Acceso", 'imagen' => false,
                        'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: center;'><tr><td width='50%'><strong>Nombre de Usuario: </strong></td><td>".$user->user."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Contrase&ntilde;a: </strong></td><td>".$password."</td></tr></table><br/><br/><a target='_blank' href=\"".url('sistema')."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #02384B; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Acceso al Sistema</a></div>"],
                    'Reseteo de Contraseña', $user->email, $user->nombre . " " . $user->apellidos);
                return Redirect::back()->with('confirm', 'Revise su correo para poder acceder a su cuenta.');
            }
            return Redirect::back()->with('contra', 'Su contrase&ntilde;a no puede ser actualizada. Acceso incorrecto.');
        }else
            return Redirect::back()->with('contra', 'Su contrase&ntilde;a no puede ser actualizada. Acceso incorrecto.');
    }

    public function getLogout()
    {
        Auth::logout();
        $tauth = new Hybrid_Auth(app_path().'/config/facebook.php');
        $tauth->logoutAllProviders();
        return Redirect::to('sistema');
    }

    private function _verificar()
    {
        $fecha_actual = strtotime(date("Y-m-d"));
        $this->solicitudRepo->verificar($fecha_actual);
        $this->emprendedoreRepo->verificar($fecha_actual);
        $this->blogRepo->verificar($fecha_actual);
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