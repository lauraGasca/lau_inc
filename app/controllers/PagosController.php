<?php

use Incubamas\Repositories\AsesoresRepo;
use Incubamas\Repositories\EventoRepo;
use Incubamas\Repositories\HorariosRepo;
use Incubamas\Repositories\CalendarioRepo;
use Incubamas\Repositories\PagoRepo;
use Incubamas\Repositories\DocumentoRepo;
use Incubamas\Repositories\ChatRepo;
use Incubamas\Repositories\MensajeRepo;
use Incubamas\Repositories\UserRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\EmpresaRepo;
use Incubamas\Repositories\SocioRepo;

class PagosController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $asesoresRepo;
    protected $userRepo;
    protected $eventoRepo;
    protected $horariosRepo;
    protected $emprendedoresRepo;
    protected $pagoRepo;
    protected $documentoRepo;
    protected $chatRepo;
    protected $mensajeRepo;
    protected $empresaRepo;
    protected $socioRepo;

    public function __construct(CalendarioRepo $calendarioRepo, AsesoresRepo $asesoresRepo,
                                EventoRepo $eventoRepo, HorariosRepo $horariosRepo, EmprendedoresRepo $emprendedoresRepo,
                                PagoRepo $pagoRepo, DocumentoRepo $documentoRepo, ChatRepo $chatRepo, MensajeRepo $mensajeRepo,
                                UserRepo $userRepo, EmpresaRepo $empresaRepo, SocioRepo $socioRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->calendarioRepo = $calendarioRepo;
        $this->asesoresRepo = $asesoresRepo;
        $this->eventoRepo = $eventoRepo;
        $this->horariosRepo = $horariosRepo;
        $this->emprendedoresRepo = $emprendedoresRepo;
        $this->pagoRepo = $pagoRepo;
        $this->documentoRepo = $documentoRepo;
        $this->chatRepo = $chatRepo;
        $this->mensajeRepo = $mensajeRepo;
        $this->userRepo = $userRepo;
        $this->empresaRepo = $empresaRepo;
        $this->socioRepo = $socioRepo;
    }


    //Verificar
    public function getIndex($emprendedor_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $asesores = Asesor::select('id', DB::raw('CONCAT(nombre, " ", apellidos) AS nombre_completo'))
            ->lists('nombre_completo', 'id');
        $servicios = Servicios::all()->lists('nombre', 'id');
        $emprendedor = Emprendedor::find($emprendedor_id);
        $solicitudes = Solicitud::select('solicitud.id', 'solicitud.monto', 'solicitud.fecha_limite', 'solicitud.estado',
            DB::raw('(select nombre_empresa from empresas where id = solicitud.empresa_id) AS empresa, servicios_incuba.nombre AS servicios,
			(select SUM(monto) from pago where pago.solicitud_id = solicitud.id) as pagos,
			CONCAT(emprendedores.name, " ", emprendedores.apellidos) AS nombre_completo'))
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->join('emprendedores', 'emprendedores.id', '=', 'solicitud.emprendedor_id')
            ->where('solicitud.emprendedor_id', '=', $emprendedor->id)->get();
        $solicitud_lista_emp = Solicitud::select('solicitud.id', DB::raw('CONCAT(emprendedores.name, " ", emprendedores.apellidos, " - ", servicios_incuba.nombre) AS nombre_completo'))
            ->join('emprendedores', 'emprendedores.id', '=', 'solicitud.emprendedor_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('emprendedores.id', '=', $emprendedor->id)
            ->lists('nombre_completo', 'id');
        $solicitud_lista = Solicitud::select('solicitud.id', DB::raw('CONCAT(empresas.nombre_empresa, " - ", servicios_incuba.nombre) AS nombre_completo'))
            ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('empresas.emprendedor_id', '=', $emprendedor->id)
            ->lists('nombre_completo', 'id');
        $total_servicios = Solicitud::select(DB::raw('SUM(monto) as total'))
            ->where('solicitud.emprendedor_id', '=', $emprendedor->id)->first();
        $pagos = Pago::select('pago.id', 'pago.monto', 'pago.fecha_emision', 'pago.solicitud_id', 'pago.siguiente_pago', 'pago.created_at',
            DB::raw('(select CONCAT(asesores.nombre, " ", asesores.apellidos) AS nombre_completo from asesores WHERE asesores.id = pago.recibido_by) as nombre_completo,
			CONCAT(empresas.nombre_empresa, " - ", servicios_incuba.nombre) AS nombre_solicitud'))
            ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
            ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('pago.emprendedor_id', '=', $emprendedor->id)->get();
        $pagos_emp = Pago::select('pago.id', 'pago.monto', 'pago.fecha_emision', 'pago.solicitud_id', 'pago.created_at',
            DB::raw('(select CONCAT(asesores.nombre, " ", asesores.apellidos) AS nombre_completo from asesores WHERE asesores.id = pago.recibido_by) as nombre_completo,
			CONCAT(emprendedores.name, " ", emprendedores.apellidos, " - ", servicios_incuba.nombre) AS nombre_solicitud'))
            ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
            ->join('emprendedores', 'emprendedores.id', '=', 'solicitud.emprendedor_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('pago.emprendedor_id', '=', $emprendedor->id)->get();
        $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
            ->where('pago.emprendedor_id', '=', $emprendedor->id)->first();
        $adeudo = $total_servicios->total - $total_pagos->total;
        $empresas = Empresa::where('emprendedor_id', '=', $emprendedor->id)->lists('nombre_empresa', 'id');
        $this->layout->content = View::make('pagos.index')
            ->with('servicios', $servicios)
            ->with('emprendedor', $emprendedor)
            ->with('empresas', $empresas)
            ->with('asesores', $asesores)
            ->with('solicitudes', $solicitudes)
            ->with('solicitud_lista', $solicitud_lista)
            ->with('solicitud_lista_emp', $solicitud_lista_emp)
            ->with('total_servicios', $adeudo)
            ->with('total_pagos', $total_pagos)
            ->with('pagos', $pagos)
            ->with('pagos_emp', $pagos_emp);
    }

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

    //Verificar
    public function postCambiaprograma()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("programa" => Input::get("programa"));
        $rules = array("programa" => 'required|min:3|max:50');
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $emprendedor = Emprendedor::find(Input::get("emprendedor_id"));
            $emprendedor->programa = Input::get("programa");
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $emprendedor->updated_by = $autor->id;
            if ($emprendedor->save())
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            else
                return Redirect::back()->with(array('confirm' => 'No se ha guardado correctamente.'));

        }
    }

    //Verificar
    public function postCrearservicio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor" => Input::get("emprendedor_id"),
            "empresa" => Input::get("empresa"),
            "servicio" => Input::get("servicio"),
            "monto" => Input::get("monto"),
            "date" => Input::get("date")
        );
        $rules = array(
            "emprendedor" => 'exists:emprendedor,id',
            "empresa" => 'exists:empresas,id',
            "servicio" => 'required|exists:servicios_incuba,id',
            "monto" => 'required|min:3|max:25',
            "date" => 'required|date_format:d/m/Y'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de liquidacion > Fecha Actual
            $fecha_actual = strtotime(date("Y-m-d"));
            $date = str_replace('/', '-', Input::get("date"));
            $fecha_liquidacion = strtotime($date);
            if ($fecha_actual >= $fecha_liquidacion) {
                return Redirect::back()->withInput()
                    ->with(array('fecha' => 'La fecha de liquidacion debe ser mayor a la fecha actual.'));
            }
            //Monto > 0 y numero valido
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser un numero valido'));
            }
            if (!is_numeric($monto_formateado) || $monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser mayor a 0'));
            }
            $solicitud = new Solicitud;
            $solicitud->emprendedor_id = Input::get("emprendedor_id");
            if (Input::get("empresa") <> '') {
                $solicitud->empresa_id = Input::get("empresa");
                $solicitud->empresa = true;
            } else {
                $solicitud->empresa_id = null;
                $solicitud->empresa = false;
            }
            $solicitud->servicio_id = Input::get("servicio");
            $solicitud->monto = $monto_formateado;
            $solicitud->fecha_limite = date('Y-m-d', strtotime($date));
            //Revisar si esta cercana la fecha de pago
            $nueva_fecha = strtotime('-5 day', $fecha_liquidacion);
            if ($nueva_fecha <= $fecha_actual) {
                $solicitud->estado = "Alerta";
            } else {
                $solicitud->estado = "Activo";
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $solicitud->created_by = $autor->id;
            if ($solicitud->save())
                return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
            else
                return Redirect::back()->with(array('confirm' => 'No se ha creado correctamente.'));
        }
    }

    //Verificar
    public function getEditarservicio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $solicitud_consulta = Solicitud::find(Input::get('servicio_id'));
        $date = new DateTime($solicitud_consulta->fecha_limite);
        $solicitud_JSON = array(
            'solicitud' => $solicitud_consulta->id,
            'empresa' => $solicitud_consulta->empresa_id,
            'servicio' => $solicitud_consulta->servicio_id,
            'costo' => $solicitud_consulta->monto,
            'fecha' => $date->format('d/m/Y')
        );
        return Response::json($solicitud_JSON);
    }

    //Verificar
    public function postEditarservicio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "solicitud_id" => Input::get("solicitud_id"),
            "emprendedor" => Input::get("emprendedor_id"),
            "empresa" => Input::get("empresa"),
            "servicio" => Input::get("servicio"),
            "monto" => Input::get("monto"),
            "date" => Input::get("date")
        );
        $rules = array(
            "solicitud_id" => 'exists:solicitud,id',
            "emprendedor" => 'exists:emprendedor,id',
            "empresa" => 'exists:empresas,id',
            "servicio" => 'exists:servicios_incuba,id',
            "monto" => 'required|min:3|max:25',
            "date" => 'required|date_format:d/m/Y'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de liquidacion > Fecha Actual | Fecha de Liquidacion >= Maximo(Pago)
            $fecha_actual = strtotime(date("Y-m-d"));
            $date = str_replace('/', '-', Input::get("date"));
            $fecha_liquidacion = strtotime($date);
            $pagos = Pago::select(DB::raw('MAX(siguiente_pago) as siguiente'))
                ->where("emprendedor_id", "=", Input::get("emprendedor_id"))
                ->where("solicitud_id", "=", Input::get("solicitud_id"))->first();
            $fecha_limite = strtotime(date_format(date_create($pagos->siguiente), 'Y-m-d'));
            if ($fecha_liquidacion <= $fecha_actual) {
                return Redirect::back()->withInput()
                    ->with(array('fecha' => 'La fecha de liquidacion debe ser mayor a la fecha de hoy.'));
            }
            if ($fecha_liquidacion < $fecha_limite) {
                return Redirect::back()->withInput()
                    ->with(array('fecha' => 'La fecha de liquidacion debe ser mayor a la fecha de siguiente pago.'));
            }
            //Monto > 0 | numero valido | Monto >= Pagado
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            $total_pagado = Pago::select(DB::raw('SUM(monto) as total'))
                ->where('pago.solicitud_id', '=', Input::get("solicitud_id"))->first();
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser un numero valido.'));
            }
            if ($monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser mayor a 0'));
            }
            if ($monto_formateado < $total_pagado->total) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser un mayor al monto pagado.'));
            }
            $solicitud = Solicitud::find(Input::get("solicitud_id"));
            $solicitud->emprendedor_id = Input::get("emprendedor_id");
            $solicitud->empresa_id = Input::get("empresa");
            if (Input::get("empresa") <> '') {
                $solicitud->empresa_id = Input::get("empresa");
                $solicitud->empresa = true;
            } else {
                $solicitud->empresa_id = null;
                $solicitud->empresa = false;
            }
            $solicitud->servicio_id = Input::get("servicio");
            $solicitud->monto = $monto_formateado;
            //Revisar si esta liquidado
            if ($solicitud->monto == $total_pagado->total)
                $solicitud->estado = "Liquidado";
            else {
                //Revisar si esta cercana la fecha de pago
                $nueva_fecha = strtotime('-5 day', $fecha_liquidacion);
                if ($nueva_fecha <= $fecha_actual) {
                    $solicitud->estado = "Alerta";
                } else {
                    $solicitud->estado = "Activo";
                }
            }
            $solicitud->fecha_limite = date('Y-m-d', strtotime($date));
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $solicitud->created_by = $autor->id;
            if ($solicitud->save()) {
                $this->revision_emprendedor($solicitud->emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha guardado correctamente.'));
        }
    }

    //Verificar
    public function getDeletesolicitud($solicitud_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("solicitud_id" => $solicitud_id);
        $rules = array("solicitud_id" => 'required|exists:solicitud,id');
        $messages = array('exists' => 'El servicio indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $solicitud = Solicitud::find($solicitud_id);
            $estado = $solicitud->estado;
            $emprendedor_id = $solicitud->emprendedor_id;
            if ($solicitud->delete()) {
                if ($estado == "Vencido")
                    $this->revision_emprendedor($emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha eliminado correctamente.'));
        }
    }

    //Verificar
    public function postCrearPago()
    {
        $this->_soloAsesores();
        //Fecha de siguiente pago > Fecha actual | Fecha de siguiente pago <= Fecha de Servicio
        $fecha_actual = strtotime(date("Y-m-d"));
        if (Input::get("ultimo") <> 'yes') {
            $fecha_siguiente = $this->_mysqlformat(Input::get("finish"));
            $fecha = Solicitud::select('fecha_limite')->where('id', '=', Input::get("solicitud"))->first();
            $fecha_servicio = strtotime(date_format(date_create($fecha->fecha_limite), 'Y-m-d'));
            $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
            if ($solicitud->estado <> 'Vencido')
                if ($fecha_siguiente > $fecha_servicio) {
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'La fecha de siguiente pago debe ser menor a la fecha de pago del servicio.'));
                }
        }
        //Fecha de pago <= Fecha actual
        $fecha_pago = $this->_mysqlformat(Input::get("start"));
        if ($fecha_pago > $fecha_actual) {
            return Redirect::back()->withInput()
                ->with(array('fecha-emision' => 'La fecha de pago debe ser menor o igual a la fecha de hoy.'));
        }
        //Monto > 0 | numero valido | Monto <= Monto de Servicio
        $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
        $monto_servicio = Solicitud::select('monto')->where('id', '=', Input::get("solicitud"))->first();
        $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
            ->where('pago.solicitud_id', '=', Input::get("solicitud"))->first();
        $faltante = $monto_servicio->monto - $total_pagos->total;
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
                ->with(array('monto-pago' => 'El monto debe ser menor o igual al faltante para liquidar el servicio.'));
        }
        //Verificar que se haya liquidado si asi se indico
        $nuevo_monto = $faltante - $monto_formateado;
        if ($nuevo_monto == 0) {
            $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
            $solicitud->estado = "Liquidado";
            $solicitud->save();
        } else {
            if (Input::get("ultimo") == 'yes')
                return Redirect::back()->withInput()
                    ->with(array('liquidado' => 'Aun no se ha liquidado la cuenta, indique una fecha de siguiente pago.'));
        }
        $pago = new Pago;
        $pago->emprendedor_id = Input::get("emprendedor_id");
        $pago->solicitud_id = Input::get("solicitud");
        $pago->recibido_by = Input::get("recibido");
        $pago->monto = $monto_formateado;
        $fecha = $this->_mysqlformat(Input::get("start"));
        $pago->fecha_emision = $fecha;
        if ($solicitud->estado <> "Liquidado") {
            $fecha = $this->_mysqlformat(Input::get("finish"));
            $pago->siguiente_pago = $fecha;
        }
        $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
        $pago->created_by = $autor->id;
        if ($pago->save()) {
            $this->revision_emprendedor($pago->emprendedor_id);
            return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
        } else {
            return Redirect::back()->with(array('confirm' => 'No se ha podido realizar el pago.'));
        }
    }

    //Verificar
    public function getEditarpago()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $pago_consulta = Pago::find(Input::get('pago_id'));
        $pago_JSON = array(
            'pago' => Input::get('pago_id'),//$pago_consulta->id,
            'solicitud' => $pago_consulta->solicitud_id,
            'monto' => $pago_consulta->monto,
            'start' => $pago_consulta->fecha_emision,
            'recibido' => $pago_consulta->recibido_by,
            'finish' => $pago_consulta->siguiente_pago
        );
        return Response::json($pago_JSON);
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

    //Verificar
    public function getDeletepago($pago_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("pago_id" => $pago_id);
        $rules = array("pago_id" => 'required|exists:pago,id');
        $messages = array('exists' => 'El pago indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $pago = Pago::find($pago_id);
            $solicitud_id = $pago->solicitud_id;
            $emprendedor_id = $pago->emprendedor_id;
            if ($pago->delete()) {
                $monto_servicio = Solicitud::select('monto')->where('id', '=', $solicitud_id)->first();
                $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
                    ->where('pago.solicitud_id', '=', $solicitud_id)->first();
                $solicitud = Solicitud::find($solicitud_id);
                //$especial=$total_pagos->total-500;
                if ($monto_servicio->monto == $total_pagos->total) {
                    $solicitud->estado = "Liquidado";
                } else {
                    $fecha_actual = strtotime(date("Y-m-d"));
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
                }
                $solicitud->save();
                $this->revision_emprendedor($emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha eliminado correctamente.'));
        }
    }

    //Convierte una fecha al formato Y-d-m
    private function _mysqlformat($fecha)
    {
        if ($fecha <> "")
            return date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'Y-m-d');
        else
            return null;
    }







    //Filtro para que solo los trabajadores entren a la funcion
    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }
}