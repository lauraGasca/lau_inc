<?php

use Incubamas\Repositories\ProyectoRepo;
use Incubamas\Managers\ProgresoManager;

class ProyectoController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $proyectoRepo;

    public function __construct(ProyectoRepo $proyectoRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->proyectoRepo = $proyectoRepo;
    }

    public function getIndex($emprendedor_id)
    {
        $modulos = $this->proyectoRepo->modulos();
        $progresos = $this->proyectoRepo->progresos($emprendedor_id);
        $this->layout->content = View::make('proyecto.index', compact('modulos','emprendedor_id', 'progresos'));
    }

    public function postUpdatePregunta()
    {
        $pregunta = $this->proyectoRepo->pregunta(Input::get('pregunta_id'));
        $progreso = $this->proyectoRepo->existe(Input::get('emprendedor_id'), Input::get('pregunta_id'));
        if($pregunta->archive == 0)
            if(Input::get('texto')<>'') $estado = 1; else $estado = 0;
        else
            if(Input::hasFile('archivo')) $estado = 1; else $estado = 0;
        if(count($progreso)<=0)
            $progreso = $this->proyectoRepo->newProgreso();
        $manager = new ProgresoManager($progreso, Input::all()+['estado'=>$estado]);
        $manager->save();
        if(Input::hasfile('archivo'))
        {
            $this->proyectoRepo->actualizarArchivo($progreso, $progreso->emprendedor_id.'-'.$progreso->pregunta_id. "." . Input::file('archivo')->getClientOriginalExtension());
            Input::file('archivo')->move('Orb/images/progresos/', $progreso->archivo);
        }
        return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
				parent.mensaje('.Input::get('pregunta_id').','.$pregunta->archive.');
			</script></body></html>';
    }

}