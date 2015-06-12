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
        $this->soliciturRepo->verificarSolicitud($solicitud->id);
        return Redirect::to('pagos/index/'.Input::get("emprendedor_id"))->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditarSolicitud($solicitud_id)
    {
        $solicitud = $this->soliciturRepo->solicitud($solicitud_id);
        if(count($solicitud)>0)
        {
            $emprendedor = $this->emprendedoresRepo->emprendedor($solicitud->emprendedor_id);
            $empresas_listado = $this->empresaRepo->listar_empresas($solicitud->emprendedor_id);
            $servicios = $this->soliciturRepo->servicios();
            $siguiente_pago =  $this->soliciturRepo->pagos_siguiente_pago($solicitud->id);
            $this->layout->content = View::make('servicios.update', compact('solicitud','emprendedor', 'empresas_listado', 'servicios', 'siguiente_pago'));
        }
        else
            return Response::view('errors.missing', array(), 404);
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
            $solicitud = $this->soliciturRepo->solicitud($pago->solicitud_id);
            $fecha_limite = $solicitud->fecha_limite;
            $this->layout->content = View::make('pagos.update', compact('pago','emprendedor_id', 'empresas_listado', 'solicitudes_listado', 'asesores', 'solicitudes_limite', 'fecha_limite'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditarPago()
    {
        $this->_soloAsesores();
        $pago = $this->pagoRepo->pago(Input::get("id"));
        if(count($pago)>0)
        {
            $manager = new ValidatorManager('creaPago', Input::all());
            $manager->validar();
            if($this->pagoRepo->verificarMonto(Input::get("id"), Input::get('solicitud_id'),Input::get('monto')))
                return Redirect::back()->withErrors(['monto'=>'El monto no puede ser mayor al total del adeudo.'])->withInput();
            $manager = new PagoManager($pago, Input::all());
            $manager->save();
            $this->soliciturRepo->verificarSolicitud($pago->solicitud_id);
            $this->soliciturRepo->revision_emprendedor($pago->emprendedor_id);
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
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

    public function getImprimirPago($pago_id)
    {
        $this->_soloAsesores();
        $pago = $this->pagoRepo->pago_recibo($pago_id);
        if(count($pago)>0) {
            $emprendedor = $this->emprendedoresRepo->emprendedor($pago->emprendedor_id);
            $solicitud = $this->soliciturRepo->solicitud_recibo($pago->solicitud_id);
            $asesor = $this->userRepo->usuario($pago->recibido_by);
            $html = View::make("pagos.recibo", compact('pago', 'emprendedor', 'solicitud', 'asesor'));
            $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
        }else
            return Response::view('errors.missing', array(), 404);
    }

    //Verificar
    public function getEnviarPago($pago_id)
    {
        $this->_soloAsesores();
        $pago = $this->pagoRepo->pago_recibo($pago_id);
        if(count($pago)>0) {
            $emprendedor = $this->emprendedoresRepo->emprendedor($pago->emprendedor_id);
            $solicitud = $this->soliciturRepo->solicitud_recibo($pago->solicitud_id);
            $asesor = $this->userRepo->usuario($pago->recibido_by);
            $html = View::make("pagos.recibo", compact('pago', 'emprendedor', 'solicitud', 'asesor'));
            $PDF = PDF::load($html, 'A4', 'portrait')->output();
            $correo = $emprendedor->usuario->email;
            $nombre = $emprendedor->usuario->nombre." ".$emprendedor->usuario->apellidos;
            Mail::send('emails.recibo', [], function ($message) use ($PDF, $correo, $nombre) {
                $message->subject('Recibo de Pago');
                $message->to($correo, $nombre);
                $message->attachData($PDF, 'recibo_pago.pdf');
            });
            return Redirect::to('pagos/index/' . $emprendedor->id)->with(array('confirm' => 'El correo ha sido enviado con exito'));
        }else
            return Response::view('errors.missing', array(), 404);
    }

    /**************************Otros Metodos*******************************/

    //Filtro para que solo los trabajadores entren a la funcion
    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

}