<?php

use Incubamas\Repositories\EmprendedoresRepo;

class SistemaController extends BaseController
{

    protected $layout = 'layouts.login';
    protected $emprendedoresRepo;

    public function __construct(EmprendedoresRepo $emprendedoresRepo)
    {
        $this->emprendedoresRepo = $emprendedoresRepo;
    }

    public function getIndex()
    {
        $this->layout->content =  View::make('login.index');
        //return View::make('sistema.login');
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('sistema');
    }

    public function postLogin()
    {
        $userdata = array('user' => Input::get('user'), 'password' => Input::get('password'));
        $rules = array('user' => 'required|min:3|max:100', 'password' => 'required|min:3|max:100');
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();

        if (Auth::attempt($userdata, Input::get('remember'))) {
            if (Auth::user()->type_id != '') {
                $this->_verificat();
                if (Auth::user()->type_id == 1 || Auth::user()->type_id == 2)
                    return Redirect::intended('emprendedores');
                if (Auth::user()->type_id == 3) {
                    $id = $this->emprendedoresRepo->emprendedorid(Auth::user()->id);
                    return Redirect::intended('emprendedores/perfil/' . $id);
                }
                if (Auth::user()->type_id == 4)
                    return Redirect::intended('blog');
            }
            return Redirect::back()->with(array('confirm' => 'Lo sentimos. No tiene permiso para acceder.'));
        }
        return Redirect::back()->with('login_errors', true)->withInput();
    }

    public function confirmation($evento_id)
    {
        $contactName = Input::get('name');
        $contactEmail = Input::get('email');
        $contactCity = Input::get('city');
        $contactMessage = Input::get('message');

        Mail::send('emails.email',
            array('name' => Input::get('name'), 'email' => Input::get('email'), 'city' => Input::get('city'), 'mensaje' => Input::get('message')),
            function ($message) {
                $message->subject('Contacto desde Sitio Web');
                $message->to('hola@incubamas.com', 'IncubaMás');
            });
        return Redirect::to('incuba#contactanos')->with(array('confirm' => 'Gracias por contactarnos.'));
    }

    public function cancellation($evento_id)
    {

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

}
