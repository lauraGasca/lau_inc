<?php

use Incubamas\Repositories\UserRepo;
use Incubamas\Repositories\EmprendedoresRepo;

use Incubamas\Managers\FacebookManager;
use Incubamas\Managers\EmprendedorManager;
use Incubamas\Managers\UserManager;
use Incubamas\Managers\ValidatorManager;

class LoginController extends BaseController
{
    protected $layout = 'layouts.login';
    protected $userRepo;
    protected $emprendedoreRepo;

    public function __construct(UserRepo $userRepo, EmprendedoresRepo $emprendedoresRepo)
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->userRepo = $userRepo;
        $this->emprendedoreRepo = $emprendedoresRepo;
    }
    
    public function getIndex($error=null)
    {
        if($error!=null) {
            $this->layout->content = View::make('login.index', compact("error"));
        }else {
            if (Auth::check()) {
                if (Auth::user()->active == 1)
                    switch (Auth::user()->type_id) {
                        case 1:
                        case 2:
                            return Redirect::to('emprendedores');
                        case 3:
                            return Redirect::to('emprendedores/perfil/' . $this->emprendedoreRepo->emprendedorid(Auth::user()->id));
                        case 4:
                            return Redirect::to('blog');
                        default:
                            return Redirect::back()->with(array('confirm' => 'No tiene permiso para acceder.'));
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
            if(Auth::user()->active == 1)
                switch(Auth::user()->type_id)
                {
                    case 1: case 2: return Redirect::to('emprendedores');
                    case 3: return Redirect::to('emprendedores/perfil/' . $this->emprendedoreRepo->emprendedorid(Auth::user()->id));
                    case 4: return Redirect::to('blog');
                    default: return Redirect::back()->with(array('confirm' => 'No tiene permiso para acceder.'));
                }
            Redirect::back()->with(array('confirm' => 'Su usuario no ha sido activado.'));
        }
        return Redirect::back()->with('login_errors', true)->withInput();
    }

    public function getFblogin($auth=null)
    {
        if($auth == 'auth')
        {
            try
            {
                Hybrid_Endpoint::process();
            }catch(Exception $e)
            {
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
            if($user->active == 1) {
                Auth::login($user);
                $this->_verificat();
                switch(Auth::user()->type_id)
                {
                    case 1: case 2: $direccion = 'emprendedores'; break;
                    case 3: $direccion = 'emprendedores/perfil/' . $this->emprendedoreRepo->emprendedorid(Auth::user()->id); break;
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
            $this->userRepo->actualizarImagen($profile->photoURL,$user);

            $emprendedor = $this->emprendedoreRepo->newEmprendedor();
            $manager = new EmprendedorManager($emprendedor, ['user_id' => $user->id, 'genero'=> $genero]);
            $manager->save();

            $this->_mail('emails.estandar',
                ['titulo'=>'Nuevo Registro, ', 'mensaje'=>$profile->firstName.' '.$profile->lastName.' se ha registrado mediante Facebook con el correo '.$profile->email,
                    'seccion'=>"Activar Usuario", 'imagen' => false,
                    'tabla' => "Si desea activar al usuario de click en el siguiente enlace <br/><div align='center'><a href=\"".url('emprendedores/activar/'.$user->id)."\"
                    style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Activar</a></div>"],
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

        $user = $this->userRepo->newUser();
        $password = $this->_password();
        $manager = new UserManager($user, Input::all()+array('password'=>$password));
        $manager->save();

        $emprendedor = $this->emprendedoreRepo->newEmprendedor();
        $manager = new EmprendedorManager($emprendedor, ['user_id'=>$user->id, 'fecha_nacimiento' => $this->_mysqlformat(Input::get('fecha_nacimiento'))]);
        $manager->save();

        $this->_mail('emails.estandar',
            ['titulo'=>'Nuevo Registro, ', 'mensaje'=>Input::get('nombre')." ".Input::get('apellidos').' se ha registrado en la pagina con el correo '.Input::get('email'),
                'seccion'=>"Activar Usuario", 'imagen' => false,
                'tabla' => "Si desea activar al usuario de click en el siguiente enlace <br/><div align='center'><a href=\"".url('emprendedores/activar/'.$user->id)."\"
                    style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Activar</a></div>"],
            'Nuevo Usuario', 'hola@incubamas.com', 'IncubaMas' );

        return Redirect::back()->with('confirm', 'Revise su correo para poder acceder a su cuenta.'.$password);
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
        if($user->password<>'')
        {
            $password = $this->_password();

            $this->userRepo->actualizarPassword($user,$password);

            $email = $user->email;
            $nombre = $user->nombre . " " . $user->apellidos;
            $titulo = "Hola ".$nombre.',';
            $mensaje = "Tal como lo has solicitado tu contrase&ntilde;a a sido actualizada.";
            $seccion = "Datos de Inicio de sesi&oacute;n";
            $imagen = false;
            $tabla = '<strong>Nombre de usuario: </strong>'.$user->user.'<br/><br/><strong>Contrase&ntilde;a: </strong>'.$password;
            //return View::make('emails.estandar', compact('titulo', 'mensaje', 'seccion', 'imagen', 'tabla'));

            Mail::send('emails.estandar', compact('titulo', 'mensaje', 'seccion', 'imagen', 'tabla'),
                function ($message) use ($email, $nombre) {
                $message->subject('Reseteo de Contraseña');
                $message->to($email, $nombre);
            });

            return Redirect::back()->with('confirm', 'Revise su correo para poder acceder a su cuenta.');
        }

        return Redirect::back()->with('contra', 'Su contrase&ntilde;a no puede ser actualizada. Acceso incorrecto.');
    }

    public function getLogout()
    {
        Auth::logout();
        $tauth = new Hybrid_Auth(app_path().'/config/facebook.php');
        $tauth->logoutAllProviders();
        return Redirect::to('sistema');
    }

    //Genera una contraseña aleatoriamente
    private function _password()
    {
        $val_permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890?!*-+_%#/=()";
        $cad = "";
        for($i=0;$i<8;$i++) {
            $cad .= substr($val_permitidos,rand(0,62),1);
        }
        return $cad;
    }

    //Convierte una fecha al formato Y-d-m
    private function _mysqlformat($fecha)
    {
        if ($fecha <> "")
            return date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'Y-m-d');
        else
            return null;
    }

    private function _verificat()
    {
        $fecha_actual = strtotime(date("Y-m-d"));
        $verificar = Solicitud::all();
        if (count($verificar) > 0) {
            foreach ($verificar as $v) {
                if ($v->estado <> "Liquidado" && $v->estado <> "Vencido") {
                    $date = date_create($v->fecha_limite);
                    $fecha = date_format($date, 'Y-m-d');
                    $fecha_limite = strtotime($fecha);
                    if ($fecha_actual > $fecha_limite) {
                        $v->estado = "Vencido";
                        $v->save();
                    } else {
                        $nueva_fecha = strtotime('-5 day', $fecha_limite);
                        if ($nueva_fecha <= $fecha_actual) {
                            $v->estado = "Alerta";
                            $v->save();
                        }
                    }
                }
            }
        }

        $estatus = Emprendedor::all();
        if (count($estatus) > 0) {
            foreach ($estatus as $e) {
                if ($e->estatus <> "Cancelado") {
                    $e->estatus = "Activo";
                    $e->save();
                    $solicitudes = Solicitud::where("emprendedor_id", "=", $e->id)->get();
                    if (count($solicitudes) > 0) {
                        foreach ($solicitudes as $s) {
                            if ($s->estado == "Vencido") {
                                $e->estatus = "Suspendido";
                                $e->save();
                                break;
                            } else {
                                if ($s->estado <> "Liquidado") {
                                    $pagos = Pago::select(DB::raw('MAX(siguiente_pago) as siguiente'))
                                        ->where("emprendedor_id", "=", $e->id)
                                        ->where("solicitud_id", "=", $s->id)->first();
                                    $date = date_create($pagos->siguiente);
                                    $fecha = date_format($date, 'Y-m-d');
                                    $fecha_limite = strtotime($fecha);
                                    if ($fecha_actual > $fecha_limite) {
                                        $e->estatus = "Suspendido";
                                        $e->save();
                                        break;
                                    }
                                }
                            }
                        }
                    }

                }
            }
        }

        $blogs = Blogs::all();
        if (count($blogs) > 0) {
            foreach ($blogs as $blog) {
                $fecha_entrada = strtotime(date_format(date_create($blog->fecha_publicacion), 'd-m-Y'));
                if ($fecha_actual >= $fecha_entrada) {
                    if ($blog->activo != 1) {
                        $blog->activo = 1;
                        $blog->save();
                    }
                } else {
                    if ($blog->activo != 0) {
                        $blog->activo = 0;
                        $blog->save();
                    }
                }

            }
        }
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