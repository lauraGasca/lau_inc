<?php

use Incubamas\Repositories\SolicitudRepo;
use Incubamas\Repositories\PagoRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\EmpresaRepo;
use Incubamas\Repositories\UserRepo;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\SolicitudManager;
use Incubamas\Managers\SolicitudEditarManager;
use Incubamas\Managers\PagoManager;

class PagosController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $soliciturRepo;
    protected $pagoRepo;
    protected $emprendedoresRepo;
    protected $empresaRepo;
    protected $userRepo;

    public function __construct(SolicitudRepo $solicitudRepo, PagoRepo $pagoRepo, EmprendedoresRepo $emprendedoresRepo,
        EmpresaRepo $empresaRepo, UserRepo $userRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->soliciturRepo = $solicitudRepo;
        $this->pagoRepo = $pagoRepo;
        $this->emprendedoresRepo = $emprendedoresRepo;
        $this->empresaRepo = $empresaRepo;
        $this->userRepo = $userRepo;
    }

    public function getIndex($emprendedor_id)
    {
        $this->_soloAsesores();
        $emprendedor = $this->emprendedoresRepo->emprendedor($emprendedor_id);
        $solicitudes = $this->soliciturRepo->solicitudes($emprendedor_id);
        $pagos = $this->pagoRepo->pagos($emprendedor_id);
        $adeudo = $this->soliciturRepo->adeudo($emprendedor_id);
        $pagosRealizados = $this->pagoRepo->pagosRealizados($emprendedor_id);
        $this->layout->content = View::make('pagos.index', compact('emprendedor', 'solicitudes', 'pagos', 'adeudo', 'pagosRealizados'));
    }

    public function postCambiaPrograma()
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('programa', ["programa" => Input::get("programa")]);
        $manager->validar();
        $this->emprendedoresRepo->cambiar_programa(Input::get("emprendedor_id"), Input::get("programa"));
        return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
    }

    /**************************Solicitudes*******************************/

    public function getCrearSolicitud($emprendedor_id)
    {
        $emprendedor = $this->emprendedoresRepo->emprendedor($emprendedor_id);
        $empresas_listado = $this->empresaRepo->listar_empresas($emprendedor_id);
        $servicios = $this->soliciturRepo->servicios();
        $this->layout->content = View::make('servicios.create', compact('emprendedor', 'empresas_listado', 'servicios'));
    }

    public function postCrearSolicitud()
    {
        $this->_soloAsesores();
        $solicitud = $this->soliciturRepo->newSolicitud();
        $manager = new SolicitudManager($solicitud, Input::all());
        $manager->save();
        $this->soliciturRepo->actualizarNombre($solicitud, Input::get('nombre'));
        $this->soliciturRepo->verificarSolicitud($solicitud);
        return Redirect::to('pagos/index/'.Input::get("emprendedor_id"))->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditarSolicitud($solicitud_id)
    {
        $solicitud = $this->soliciturRepo->solicitud($solicitud_id);
        $emprendedor = $this->emprendedoresRepo->emprendedor($solicitud->emprendedor_id);
        $empresas_listado = $this->empresaRepo->listar_empresas($solicitud->emprendedor_id);
        $servicios = $this->soliciturRepo->servicios();
        $siguiente_pago =  $this->soliciturRepo->pagos_siguiente_pago($solicitud->id);
        $this->layout->content = View::make('servicios.update', compact('solicitud','emprendedor', 'empresas_listado', 'servicios', 'siguiente_pago'));
    }

    public function postEditarSolicitud()
    {
        $this->_soloAsesores();
        $solicitud = $this->soliciturRepo->solicitud(Input::get('id'));
        if(count($solicitud)>0)
        {
            $manager = new ValidatorManager('editaSolicitud', Input::all());
            $manager->validar();
            if($this->soliciturRepo->verificarMonto($solicitud->id, Input::get('monto')))
                return Redirect::back()->withErrors(['monto'=>'El monto no puede ser menor al numero de pagos realizados.'])->withInput();
            $manager = new SolicitudEditarManager($solicitud, Input::all());
            $manager->save();
            $this->soliciturRepo->actualizarNombre($solicitud, Input::get('nombre'));
            $this->soliciturRepo->revision_emprendedor($solicitud->emprendedor_id);
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDeleteSolicitud($solicitud_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('solicitud', ["solicitud_id" => $solicitud_id]);
        $manager->validar();
        $this->soliciturRepo->deleteSolicitud($solicitud_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /**************************Pagos*******************************/

    public function getCrearPago($emprendedor_id)
    {
        $solicitudes_listado = $this->soliciturRepo->solicitudes_listado($emprendedor_id);
        $solicitudes_limite = $this->soliciturRepo->solicitudes_listado_fecha($emprendedor_id);
        $asesores = $this->userRepo->listar_asesores();
        $this->layout->content = View::make('pagos.create', compact('emprendedor_id', 'empresas_listado', 'solicitudes_listado', 'asesores', 'solicitudes_limite'));
    }

    public function postCrearPago()
    {
        $this->_soloAsesores();
        $pago = $this->pagoRepo->newPago();
        $manager = new ValidatorManager('creaPago', Input::all());
        $manager->validar();
        if($this->pagoRepo->verificarMonto(0, Input::get('solicitud_id'),Input::get('monto')))
            return Redirect::back()->withErrors(['monto'=>'El monto no puede ser mayor al total del adeudo.'])->withInput();
        $manager = new PagoManager($pago, Input::all());
        $manager->save();
        $this->soliciturRepo->verificarSolicitud($pago->solicitud_id);
        $this->soliciturRepo->revision_emprendedor($pago->emprendedor_id);
        return Redirect::to('pagos/index/'.Input::get("emprendedor_id"))->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditarPago($pago_id)
    {
        $pago = $this->pagoRepo->pago($pago_id);
        if(count($pago)>0)
        {
            $emprendedor_id = $pago->emprendedor_id;
            $solicitudes_listado = $this->soliciturRepo->solicitudes_listado($emprendedor_id);
            $solicitudes_limite = $this->soliciturRepo->solicitudes_listado_fecha($emprendedor_id);
            $asesores = $this->userRepo->listar_asesores();
            $this->layout->content = View::make('pagos.update', compact('pago','emprendedor_id', 'empresas_listado', 'solicitudes_listado', 'asesores', 'solicitudes_limite'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    //Verificar
    public function postEditarpago()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor" => Input::get("emprendedor_id"),
            "solicitud" => Input::get("solicitud"),
            "recibido" => Input::get("recibido"),
            "monto" => Input::get("monto"),
            "start" => Input::get("start"),
            "finish" => Input::get("finish"),
            "ultimo" => Input::get("ultimo")
        );
        $rules = array(
            "emprendedor" => 'exists:emprendedor,id',
            "solicitud" => 'exists:solicitud,id',
            "recibido" => 'exists:asesores,id',
            "monto" => 'required|min:1|max:25',
            "start" => 'required|date',
            "finish" => 'date',
            "ultimo" => 'min:1'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de siguiente pago > Fecha actual | Fecha de siguiente pago <= Fecha de Servicio
            $fecha_actual = strtotime(date("Y-m-d"));
            if (Input::get("ultimo") <> 'yes') {
                $fecha_siguiente = strtotime(date_format(date_create(Input::get("finish")), 'Y-m-d'));
                $fecha = Solicitud::select('fecha_limite')->where('id', '=', Input::get("solicitud"))->first();
                $fecha_servicio = strtotime(date_format(date_create($fecha->fecha_limite), 'Y-m-d'));
                if ($fecha_siguiente < $fecha_actual) {
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'La fecha de siguiente pago debe ser mayor a la fecha de hoy.'));
                }
                if ($fecha_siguiente > $fecha_servicio) {
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'La fecha de siguiente pago debe ser menor a la fecha de pago del servicio.'));
                }
            }
            //Monto > 0 | numero valido | Monto <= Monto de Servicio
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            $monto_servicio = Solicitud::select('monto')->where('id', '=', Input::get("solicitud"))->first();
            $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
                ->where('pago.solicitud_id', '=', Input::get("solicitud"))->first();
            $ant_pagos = Pago::find(Input::get("pago_id"));
            $faltante = $monto_servicio->monto - ($total_pagos->total - $ant_pagos->monto);
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser un numero valido.'));
            }
            if ($monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser mayor a 0'));
            }
            if ($monto_formateado > $faltante) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => $faltante . 'El monto debe ser menor o igual al faltante para liquidar el servicio.'));
            }
            $pago = Pago::find(Input::get("pago_id"));
            //Verificar que se haya liquidado si asi se indico
            $nuevo_monto = $faltante - $monto_formateado;

            if ($nuevo_monto == 0) {
                $pago->siguiente_pago = null;
                $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
                $solicitud->estado = "Liquidado";
                $solicitud->save();
            } else {
                if (Input::get("ultimo") == 'yes')
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'Aun no se ha liquidado la cuenta, indique una fecha de siguiente pago.'));
                else {
                    $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
                    $fecha_pago = strtotime(date_format(date_create($solicitud->fecha_limite), 'Y-m-d'));
                    if ($fecha_pago <= $fecha_actual)
                        $solicitud->estado = "Vencido";
                    else {
                        $nueva_fecha = strtotime('-5 day', $fecha_pago);
                        if ($nueva_fecha <= $fecha_actual) {
                            $solicitud->estado = "Alerta";
                        } else {
                            $solicitud->estado = "Activo";
                        }
                    }
                    $solicitud->save();
                }
            }
            $pago->emprendedor_id = Input::get("emprendedor_id");
            $pago->solicitud_id = Input::get("solicitud");
            $pago->recibido_by = Input::get("recibido");
            $pago->monto = $monto_formateado;
            $fecha = date_format(date_create(Input::get("start")), 'Y-m-d');
            $pago->fecha_emision = $fecha;
            if (Input::get("finish") <> '') {
                $fecha = date_format(date_create(Input::get("finish")), 'Y-m-d');
                $pago->siguiente_pago = $fecha;
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $pago->updated_by = $autor->id;
            if ($pago->save()) {
                $this->revision_emprendedor($pago->emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            } else {
                return Redirect::back()->with(array('confirm' => 'No se ha podido editar el pago.'));
            }
        }
    }

    public function getDeletePago($pago_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('pago', ["pago_id" => $pago_id]);
        $manager->validar();
        $pago = $this->pagoRepo->pago($pago_id);
        $solicitud_id = $pago->solicitud_id;
        $emprendedor_id = $pago->emprendedor_id;
        $this->pagoRepo->deletePago($pago_id);
        $this->soliciturRepo->verificarSolicitud($solicitud_id);
        $this->soliciturRepo->revision_emprendedor($emprendedor_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /**************************Envio e Impresion de Pagos*******************************/

    //Verificar
    public function getImprimirpago($pago_id, $type = null)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        if ($type == null)
            $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                DB::raw("(select nombre from asesores WHERE asesores.id = pago.recibido_by) as nombre"),
                DB::raw("(select apellidos from asesores WHERE asesores.id = pago.recibido_by) as apellidos"), "servicios_incuba.nombre as servicios",
                "empresas.nombre_empresa", "empresas.calle", "empresas.num_ext", "empresas.num_int", "empresas.colonia", "empresas.municipio", "empresas.estado", "empresas.cp",
                "emprendedores.calle as calle_2", "emprendedores.num_ext as num_ext_2", "emprendedores.num_int as num_int_2",
                "emprendedores.colonia as colonia_2", "emprendedores.municipio as municipio_2", "emprendedores.estado as estado_2", "emprendedores.cp as cp_2",
                "emprendedores.name", "emprendedores.apellidos as apellido_emp")
                ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
                ->where("pago.id", "=", $pago_id)->first();
        else
            $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                DB::raw('CONCAT(emprendedores.name, " ", emprendedores.apellidos) AS nombre_empresa'),
                "emprendedores.calle", "emprendedores.name", "emprendedores.apellidos as apellido_emp",
                "emprendedores.num_ext", "emprendedores.num_int", "emprendedores.colonia", "emprendedores.municipio",
                "emprendedores.estado", "emprendedores.cp")
                ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                ->where("pago.id", "=", $pago_id)->first();
        $html = View::make("emprendedores.recibo")->with('pago', $pago);
        $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
    }

    //Verificar
    public function getEnviarpago($pago_id, $emprendedor_id, $type = null)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("pago_id" => $pago_id);
        $rules = array("pago_id" => 'required|exists:pago,id');
        $validation = Validator::make($dataUpload, $rules);
        if ($validation->fails())
            return Redirect::to('emprendedores/pagos/' . $emprendedor_id)->with(array('confirm' => 'El correo no ha podido ser enviado'));
        else {

            if ($type == null)
                $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                    "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                    "empresas.nombre_empresa", "empresas.calle", "empresas.num_ext", "empresas.num_int", "empresas.colonia", "empresas.municipio", "empresas.estado", "empresas.cp",
                    "emprendedores.calle as calle_2", "emprendedores.num_ext as num_ext_2", "emprendedores.num_int as num_int_2",
                    "emprendedores.colonia as colonia_2", "emprendedores.municipio as municipio_2", "emprendedores.estado as estado_2", "emprendedores.cp as cp_2",
                    "emprendedores.name", "emprendedores.apellidos as apellido_emp", "emprendedores.email")
                    ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                    ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                    ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                    ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
                    ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                    ->where("pago.id", "=", $pago_id)->first();
            else
                $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                    "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                    DB::raw('CONCAT(emprendedores.name, " ", emprendedores.apellidos) AS nombre_empresa'),
                    "emprendedores.calle", "emprendedores.name", "emprendedores.apellidos as apellido_emp",
                    "emprendedores.num_ext", "emprendedores.num_int", "emprendedores.colonia", "emprendedores.municipio",
                    "emprendedores.estado", "emprendedores.cp", "emprendedores.email")
                    ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                    ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                    ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                    ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                    ->where("pago.id", "=", $pago_id)->first();
            $html = View::make("emprendedores.recibo")->with('pago', $pago);
            $PDF = PDF::load($html, 'A4', 'portrait')->output();
            $correo = $pago->email;
            $nombre = $pago->name . " " . $pago->apellido_emp;
            Mail::send('emails.recibo', $dataUpload, function ($message) use ($PDF, $correo, $nombre) {
                $message->subject('Recibo de Pago');
                $message->to($correo, $nombre);
                $message->attachData($PDF, 'file.pdf');
            });
            return Redirect::to('emprendedores/pagos/' . $emprendedor_id)->with(array('confirm' => 'El correo ha sido enviado con exito'));
        }
    }

    /**************************Otros Metodos*******************************/

    //Filtro para que solo los trabajadores entren a la funcion
    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

}