<?php

use Incubamas\Repositories\CasosRepo;
use Incubamas\Repositories\ServicioRepo;
use Incubamas\Repositories\RelacionRepo;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\ServicioManager;
use Incubamas\Managers\CasosManager;
use Incubamas\Managers\CasosEditarManager;
use Incubamas\Managers\RelacionManager;

class CasoController extends BaseController
{

    protected $layout = 'layouts.sistema';
    protected $casosRepo;
    protected $servicioRepo;
    protected $relacionRepo;

    public function __construct(CasosRepo $casosRepo, ServicioRepo $servicioRepo, RelacionRepo $relacionRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('masters');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->casosRepo = $casosRepo;
        $this->servicioRepo = $servicioRepo;
        $this->relacionRepo = $relacionRepo;
    }

    public function getIndex()
    {
        $casos = $this->casosRepo->casos_paginados();
        $servicios_all = $this->servicioRepo->servicios_todos();
        $parametro = null;
        $this->layout->content = View::make('casos.index', compact('casos', 'servicios_all', 'parametro'));
    }

    public function postBusqueda()
    {
        $manager = new ValidatorManager('buscar', Input::all());
        $manager->validar();
        $parametro = Input::get("buscar");
        $casos = $this->casosRepo->buscar($parametro);
        $servicios_all = $this->servicioRepo->servicios_todos();
        $this->layout->content = View::make('casos.index', compact('casos', 'servicios_all', 'parametro'));
    }

    public function getCrear()
    {
        $servicios = $this->servicioRepo->servicios_tags();
        $this->layout->content = View::make('casos.create', compact('servicios'));
    }

    public function postCrear()
    {
        $caso = $this->casosRepo->newCaso();
        $manager = new CasosManager($caso, Input::all());
        $manager->save();
        $this->casosRepo->actualizarImagen($caso, $caso->id.".".Input::file("imagen")->getClientOriginalExtension());
        Input::file('imagen')->move('Orb/images/casos_exito', $caso->imagen);
        $this->casosRepo->actualizarSlug($caso);
        if(trim(Input::get("servicios"))<>'')
        {
            $nombres_servicios = explode(",", trim(Input::get("servicios")));
            foreach ($nombres_servicios as $nombre_servicio)
            {
                $servicio = $this->servicioRepo->busca_nombre($nombre_servicio);
                if (count($servicio) <= 0) {
                    $servicio = $this->servicioRepo->newServicio();
                    $manager = new ServicioManager($servicio, ['nombre' => $nombre_servicio]);
                    $manager->save();
                }
                $relacion = $this->relacionRepo->newRelacion();
                $manager = new RelacionManager($relacion, ['servicio_id' => $servicio->id, 'casos_exitoso_id' => $caso->id]);
                $manager->save();
            }
        }
        return Redirect::to('casos')->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditar($caso_id)
    {
        $caso = $this->casosRepo->caso($caso_id);
        $servicios = $this->servicioRepo->servicios_tags();
        $relaciones = $this->relacionRepo->relaciones_caso($caso_id);
        $this->layout->content = View::make('casos.update', compact('caso', 'servicios', 'relaciones'));
    }

    public function postEditar()
    {
        $caso = $this->casosRepo->caso(Input::get('id'));
        $manager = new CasosEditarManager($caso, Input::all());
        $manager->save();
        $this->casosRepo->actualizarSlug($caso);
        if (Input::hasFile('imagen'))
        {
            $this->casosRepo->actualizarImagen($caso, $caso->id.".".Input::file("imagen")->getClientOriginalExtension());
            Input::file('imagen')->move('Orb/images/casos_exito', $caso->imagen);
        }
        if(trim(Input::get("servicios"))<>'')//Verificamos si enviaron tags
        {
            $relaciones = $this->relacionRepo->relacion_caso($caso->id); //Tags que tenemos actualmente
            $nombres_servicios = explode(",", trim(Input::get("servicios"))); //Tags mandados
            if(count($relaciones)>0) //Si ya tenemos tags, revisaremos cuales se tienen que eliminar y cuales conservar
            {
                $insertar = $nombres_servicios;
                foreach($relaciones as $relacion)
                {
                    $esta = 0;
                    for ($i = 0; $i<= count($nombres_servicios); $i++)
                    {
                        if(isset($nombres_servicios[$i]))
                            if ($relacion->servicio->nombre == $nombres_servicios[$i])
                            {
                                $esta = 1;
                                unset($insertar[$i]);
                                break;
                            }
                    }
                    if($esta ==0)
                        $this->relacionRepo->borrarRelacion($relacion->	casos_exitoso_id, $relacion->servicio_id);
                }
                $nombres_servicios = $insertar;
            }
            foreach ($nombres_servicios as $nombre_servicio)
            {
                $servicio = $this->servicioRepo->busca_nombre($nombre_servicio);
                if (count($servicio) <= 0) {
                    $servicio = $this->servicioRepo->newServicio();
                    $manager = new ServicioManager($servicio, ['nombre' => $nombre_servicio]);
                    $manager->save();
                }
                $relacion = $this->relacionRepo->newRelacion();
                $manager = new RelacionManager($relacion, ['servicio_id' => $servicio->id, 'casos_exitoso_id' => $caso->id]);
                $manager->save();
            }
        }else //No enviaron tags, asi que eliminamos todos los que teniamos
            $this->relacionRepo->borrarExistentes($caso->id);

        return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getDelete($caso_id)
    {
        $manager = new ValidatorManager('caso', ['caso_id'=> $caso_id]);
        $manager->validar();
        $this->casosRepo->borrarCaso($caso_id);
        return Redirect::to('casos')->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    public function postCrearServicio()
    {
        $servicio = $this->servicioRepo->newServicio();
        $manager = new ServicioManager($servicio, Input::all());
        $manager->save();
        return Redirect::to('casos')->with(array('confirm' => "Se ha agregado correctamente."));
    }

    public function getDeleteServicio($servicio_id)
    {
        $manager = new ValidatorManager('servicio', ['servicio_id'=>$servicio_id]);
        $manager->validar();
        $this->servicioRepo->deleteServicio($servicio_id);
        return Redirect::to('casos')->with(array('confirm' => "Se ha eliminado correctamente."));
    }
}