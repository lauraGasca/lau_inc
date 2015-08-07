<?php

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
use Incubamas\Repositories\ProyectoRepo;
use Incubamas\Repositories\SolicitudRepo;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\UserEmpManager;
use Incubamas\Managers\EmprendedoresManager;
use Incubamas\Managers\UserEmpEditManager;
use Incubamas\Managers\EmprendedoresEditarManager;
use Incubamas\Managers\SocioManager;
use Incubamas\Managers\SubidasManager;

class EmprendedoresController extends BaseController
{
    protected $layout = 'layouts.sistema';
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
    protected $proyectoRepo;
    protected $soliciturRepo;

    public function __construct(CalendarioRepo $calendarioRepo, ProyectoRepo $proyectoRepo, SolicitudRepo $solicitudRepo,
                                EventoRepo $eventoRepo, HorariosRepo $horariosRepo, EmprendedoresRepo $emprendedoresRepo,
                                PagoRepo $pagoRepo, DocumentoRepo $documentoRepo, ChatRepo $chatRepo, MensajeRepo $mensajeRepo,
                                UserRepo $userRepo, EmpresaRepo $empresaRepo, SocioRepo $socioRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->calendarioRepo = $calendarioRepo;
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
        $this->proyectoRepo = $proyectoRepo;
        $this->soliciturRepo = $solicitudRepo;
    }

    /**************************Listar Emprendedores*******************************/

    public function getIndex()
    {
        $this->_soloAsesores();
        $emprendedores = $this->emprendedoresRepo->emprendedores();
        $parametro = null;
        $this->layout->content = View::make('emprendedores.index',compact('emprendedores', 'parametro'));
    }

    public function postBusqueda()
    {
        $this->_soloAsesores();
        $parametro = Input::get("buscar");
        $manager = new ValidatorManager('buscar', ['buscar'=> $parametro]);
        $manager->validar();
        $emprendedores = $this->emprendedoresRepo->burcarEmprendedores($parametro);
        $this->layout->content = View::make('emprendedores.index', compact('emprendedores', 'parametro'));
    }

    public function getBusqueda()
    {
        $parametro = Input::get("buscar");
        $emprendedores = $this->emprendedoresRepo->burcarEmprendedores($parametro);
        return Response::json($emprendedores);
    }

    /**************************Perfil Emprendedores*******************************/

    public function getPerfil($emprendedor_id, $chat_id=null)
    {
        $this->_emprendedorAsesor($emprendedor_id);
        $emprendedor = $this->emprendedoresRepo->emprendedor($emprendedor_id);
        //Calendario
        $eventos = $this->eventoRepo->eventosFuturos();
        $minDate = $this->_noSabadoDomingo(strtotime(date('j-m-Y')), 2);
        $maxDate = $this->_noSabadoDomingo(strtotime(date('j-m-Y')), 30);
        $asesores = [null=>'Selecciona al Asesor']+$this->userRepo->listar_asesores();
        //Modelo de Negocio
        $completados = $this->proyectoRepo->numProgresos($emprendedor_id);
        $disponibles = $this->proyectoRepo->numPreguntas();
        //Documentos
        $num_documentos = $this->documentoRepo->num_documentos();
        $subidas = $this->documentoRepo->num_subidos($emprendedor_id);  
        $subidos = $this->emprendedoresRepo->subidos($emprendedor_id);
        //Informacion de los pagos
        $pagos = $this->pagoRepo->pagosRealizados($emprendedor_id);
        $adeudo = $this->soliciturRepo->adeudo($emprendedor_id);
        //Mensajes
        $mensajes = null;
        $active_chat = null;
        $chats = $this->chatRepo->consultor();
        if (count($chats) > 0 && $chat_id <> null) {
            $active_chat = $this->chatRepo->chat($chat_id);
            $mensajes = $this->mensajeRepo->mensajes($chat_id);
            if($active_chat->chat->grupo == 1)
                $this->userRepo->actualizar_visto(Auth::user()->id);
            else
                $this->chatRepo->leido($active_chat->chat_id, date("Y-m-d H:i:s"));
        }
        $this->layout->content = View::make('emprendedores.perfil', compact('emprendedor', 'eventos', 'asesores', 'maxDate', 'minDate',
            'pagos', 'adeudo', 'num_documentos', 'subidas', 'subidos', 'completados', 'disponibles', 'chats', 'mensajes', 'active_chat'));
    }


    /**************************Emprendedores*******************************/

    public function getCrear()
    {
        $this->_soloAsesores();
        $this->layout->content = View::make('emprendedores.create');
    }

    public function postCrear()
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('user', Input::all());
        $manager->validar();
        $user = $this->userRepo->newUserAct();
        $manager = new UserEmpManager($user, Input::all());
        $manager->save();
        $this->userRepo->crearNomUser($user);
        if(Input::hasfile('foto'))
        {
            $this->userRepo->actualizarFoto($user, $user->id."." . Input::file('foto')->getClientOriginalExtension());
            Input::file('foto')->move('Orb/images/emprendedores/', $user->foto);
        }
        $emprendedor = $this->emprendedoresRepo->newEmprendedor();
        $manager = new EmprendedoresManager($emprendedor, Input::all()+['user_id'=>$user->id]);
        $manager->save();
        if (Input::get("empresa") == 'yes')
            return Redirect::to('emprendedores/crearempresa/' . $emprendedor->id);
        else
            return Redirect::to('emprendedores/editar/'.$emprendedor->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getEditar($emprendedor_id)
    {
        $this->_soloAsesores();
        $emprendedor = $this->emprendedoresRepo->emprendedor($emprendedor_id);
        if(count($emprendedor)>0)
        {
            $socios = $this->socioRepo->socios($emprendedor_id);
            $subidas = $this->emprendedoresRepo->subidos($emprendedor_id);
            $this->layout->content = View::make('emprendedores.update', compact('emprendedor', 'socios', 'socios_listado', 'documentos', 'subidas'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditar()
    {
        $this->_soloAsesores();
        $emprendedor = $this->emprendedoresRepo->emprendedor(Input::get('id'));
        if(count($emprendedor)>0)
        {
            $manager = new EmprendedoresEditarManager($emprendedor, Input::all());
            $manager->save();
            $user = $this->userRepo->usuario($emprendedor->user_id);
            $manager = new UserEmpEditManager($user, Input::all());
            $manager->save();
            if(Input::hasfile('foto'))
            {
                $this->userRepo->actualizarFoto($user, $user->id."." . Input::file('foto')->getClientOriginalExtension());
                Input::file('foto')->move('Orb/images/emprendedores/', $user->foto);
            }elseif (Input::get("empresa") == 'yes')
                    $this->userRepo->actualizarFoto($user, 'generic-emprendedor.png');
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDelete($user_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('usuario', ['user_id'=>$user_id]);
        $manager->validar();
        $this->userRepo->borrarUsuario($user_id);
        return Redirect::to('emprendedores')->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }


    /**************************Socios*******************************/

    public function getCrearSocio($emprendedor_id)
    {
        $this->_soloAsesores();
        $empresas_listado = $this->empresaRepo->listar_empresas($emprendedor_id);
        $this->layout->content = View::make('emprendedores.socios', compact('emprendedor_id', 'empresas_listado'));
    }

    public function postCrearSocio()
    {
        $this->_soloAsesores();
        $socio = $this->socioRepo->newSocio();
        $manager = new SocioManager($socio, Input::all());
        $manager->save();
        return Redirect::to('emprendedores/editar/'.Input::get('emprendedor_id'))->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getDeleteSocio($socio_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('socio', ['socio_id'=> $socio_id]);
        $manager->validar();
        $this->socioRepo->borrarSocio($socio_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /**************************Documentos*******************************/

    public function getSubirDocumento($emprendedor_id, $procede=null)
    {
        $this->_emprendedorAsesor($emprendedor_id);
        $documentos = $this->documentoRepo->documentos_listar();
        $empresas_listado = $this->empresaRepo->listar_empresas($emprendedor_id);
        $socios_listado = $this->socioRepo->listar_socios($emprendedor_id);
        $this->layout->content = View::make('emprendedores.documentos', compact('emprendedor_id', 'documentos', 'empresas_listado', 'socios_listado', 'procede'));
    }

    public function postSubirDocumento()
    {
        $this->_emprendedorAsesor(Input::get("emprendedor_id"));
        $subida = $this->documentoRepo->newSubida();
        $manager = new SubidasManager($subida, Input::all());
        $manager->save();
        $this->documentoRepo->actualizarDocumento($subida, $subida->id."." . Input::file('documento')->getClientOriginalExtension());
        Input::file('documento')->move('Orb/documentos/', $subida->documento);
        return Redirect::to('emprendedores/editar/'.Input::get('emprendedor_id'))->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getDeleteDocumento($subida_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('subidas', ['subida_id'=>$subida_id]);
        $manager->validar();
        $this->documentoRepo->borrarSubida($subida_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /**************************Otros*******************************/

    //Filtro para que solo los trabajadores entren a la funcion
    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

    //Filtro para que solo los trabajadores y emprendedores entren a la funcion
    private function _emprendedorAsesor($emprendedor_id)
    {
        if (Auth::user()->type_id == 1 && Auth::user()->type_id != 2 && Auth::user()->type_id != 3)
            return Redirect::to('sistema');
        elseif (Auth::user()->type_id == 3) {
            $emprendedor = $this->emprendedoresRepo->userxemprendedor_id(Auth::user()->id);
            if ($emprendedor_id <> $emprendedor)
                return Redirect::to('emprendedores/perfil/' . $emprendedor);
        }
    }

    //Si la fecha indicada cae en fin de semana, se recorre para el lunes
    private function _noSabadoDomingo($fecha, $dias)
    {
        if (date("w", strtotime('+'.$dias.' day', $fecha)) == 0)
            $fecha_final = date('Y-m-d', strtotime('+'.($dias+1).' day', $fecha));
        elseif (date("w", strtotime('+'.$dias.' day', $fecha)) == 6)
            $fecha_final = date('Y-m-d', strtotime('+'.($dias+2).' day', $fecha));
        else
            $fecha_final = date('Y-m-d', strtotime('+'.$dias.' day', $fecha));

        return $fecha_final;
    }

}