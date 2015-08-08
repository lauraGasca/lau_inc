<?php

use Incubamas\Repositories\ProyectoRepo;
use Incubamas\Managers\ProgresoManager;
use Incubamas\Managers\ValidatorManager;
/****************Ejemplos***************/
use Incubamas\Managers\EjemploManager;
use Incubamas\Managers\EjemploUpdateManager;
/****************Preguntas***************/
use Incubamas\Managers\PreguntaManager;
use Incubamas\Managers\PreguntaUpdateManager;
/****************Modulos***************/
use Incubamas\Managers\ModuloManager;

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

    public function getIndex()
    {
        $modulos = $this->proyectoRepo->modulos();
        $this->layout->content = View::make('proyecto.index', compact('modulos'));
    }

    public function getModulo($modulo_id)
    {
        $modulo = $this->proyectoRepo->modulo($modulo_id);
        $this->layout->content = View::make('proyecto.modulo', compact('modulo'));
    }

    public function getPregunta($pregunta_id)
    {
        $pregunta = $this->proyectoRepo->pregunta($pregunta_id);
        $this->layout->content = View::make('proyecto.pregunta', compact('pregunta'));
    }

    /***************************** Progresos *******************************/

    public function getModelo($emprendedor_id)
    {
        $modulos = $this->proyectoRepo->proyecto();
        $progresos = $this->proyectoRepo->progresos($emprendedor_id);
        $porcentaje = $this->proyectoRepo->porcentaje($emprendedor_id);
        $this->layout->content = View::make('proyecto.modelo', compact('modulos','emprendedor_id', 'progresos', 'porcentaje'));
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

    public function getExportarWord($emprendedor_id)
    {

        $progresos = $this->proyectoRepo->progreso_exportar($emprendedor_id);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('titulo', array('name'=>'Arial', 'size'=>14, 'color'=>'1B2232', 'bold'=>true));
        $phpWord->addFontStyle('modulo', array('name'=>'Arial', 'size'=>12, 'color'=>'1B2232', 'bold'=>true));
        $phpWord->addFontStyle('pregunta', array('name'=>'Arial', 'size'=>11, 'color'=>'1B2232', 'bold'=>true));
        $phpWord->addFontStyle('respuesta', array('name'=>'Arial', 'size'=>11, 'color'=>'1B2232'));
        $section = $phpWord->addSection();

        $section->addText(htmlspecialchars('Plan de Negocios'), 'titulo');
        $section->addTextBreak(1);

        $modulo = "";
        foreach($progresos as $progreso) {
            if($progreso->modulo->nombre != $modulo){
                $section->addTextBreak(1);
                $section->addTextBreak(1);
                $section->addText(htmlspecialchars($progreso->modulo->nombre), 'modulo');
                $modulo = $progreso->modulo->nombre;
            }
            $section->addTextBreak(1);
            $section->addText(htmlspecialchars($progreso->pregunta->pregunta), 'pregunta');
            $section->addText(htmlspecialchars($progreso->texto), 'respuesta');
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Orb\modelo-negocio\\'.$emprendedor_id.'-plan-negocio.docx');
        return Redirect::to('Orb\modelo-negocio\\'.$emprendedor_id.'-plan-negocio.docx');
    }

    /***************************** Modulos *******************************/

    public function getCrear()
    {
        $this->_soloAsesores();
        $modulos = $this->proyectoRepo->modulos();
        $this->layout->content = View::make('proyecto.modulo.create', compact('modulos'));
    }

    public function postCrear()
    {
        $this->_soloAsesores();
        $modulo = $this->proyectoRepo->newModulo();
        $manager = new ModuloManager($modulo, Input::all());
        $manager->save();
        return Redirect::to('plan-negocios')->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditar($modulo_id)
    {
        $this->_soloAsesores();
        $modulo = $this->proyectoRepo->modulo($modulo_id);
        if(count($modulo)>0)
        {
            $this->layout->content = View::make('proyecto.modulo.update', compact('modulo'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditar()
    {
        $this->_soloAsesores();
        $modulo = $this->proyectoRepo->modulo(Input::get('id'));
        if(count($modulo)>0)
        {
            $manager = new ModuloManager($modulo, Input::all());
            $manager->save();
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDelete($modulo_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('modulo', ["modulo_id" => $modulo_id]);
        $manager->validar();
        $this->proyectoRepo->borrarModulo($modulo_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /***************************** Preguntas *******************************/

    public function getCrearPregunta($modulo_id)
    {
        $this->_soloAsesores();
        $modulo = $this->proyectoRepo->modulo($modulo_id);
        $this->layout->content = View::make('proyecto.pregunta.create', compact('modulo'));
    }

    public function postCrearPregunta()
    {
        $this->_soloAsesores();
        $pregunta = $this->proyectoRepo->newPregunta();
        $manager = new PreguntaManager($pregunta, Input::all());
        $manager->save();
        return Redirect::to('plan-negocios/modulo/'.Input::get("modulo_id"))->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditarPregunta($pregunta_id)
    {
        $this->_soloAsesores();
        $pregunta = $this->proyectoRepo->pregunta($pregunta_id);
        if(count($pregunta)>0)
        {
            $this->layout->content = View::make('proyecto.pregunta.update', compact('pregunta'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditarPregunta()
    {
        $this->_soloAsesores();
        $pregunta = $this->proyectoRepo->pregunta(Input::get('id'));
        if(count($pregunta)>0)
        {
            $manager = new PreguntaUpdateManager($pregunta, Input::all());
            $manager->save();
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDeletePregunta($pregunta_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('pregunta', ["pregunta_id" => $pregunta_id]);
        $manager->validar();
        $this->proyectoRepo->borrarPregunta($pregunta_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /***************************** Ejemplos *******************************/

    public function getCrearEjemplo($pregunta_id)
    {
        $this->_soloAsesores();
        $pregunta = $this->proyectoRepo->pregunta($pregunta_id);
        $this->layout->content = View::make('proyecto.ejemplo.create', compact('pregunta'));
    }

    public function postCrearEjemplo()
    {
        $this->_soloAsesores();
        $ejemplo = $this->proyectoRepo->newEjemplo();
        $manager = new EjemploManager($ejemplo, Input::all());
        $manager->save();
        if(Input::hasfile('archivo'))
        {
            $this->proyectoRepo->actualizarArchivoEjemplo($ejemplo, $ejemplo->id . "." . Input::file("archivo")->getClientOriginalExtension());
            Input::file('archivo')->move('Orb/images/ejemplos/', $ejemplo->archivo);
        }
        return Redirect::to('plan-negocios/pregunta/'.Input::get("pregunta_id"))->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getEditarEjemplo($ejemplo_id)
    {
        $this->_soloAsesores();
        $ejemplo = $this->proyectoRepo->ejemplo($ejemplo_id);
        if(count($ejemplo)>0)
        {
            $this->layout->content = View::make('proyecto.ejemplo.update', compact('ejemplo'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditarEjemplo()
    {
        $this->_soloAsesores();
        $ejemplo = $this->proyectoRepo->ejemplo(Input::get('id'));
        if(count($ejemplo)>0)
        {
            $manager = new EjemploUpdateManager($ejemplo, Input::all());
            $manager->save();
            if(Input::hasfile('archivo'))
            {
                $this->proyectoRepo->actualizarArchivoEjemplo($ejemplo, $ejemplo->id.".".Input::file("archivo")->getClientOriginalExtension());
                Input::file('archivo')->move('Orb/images/ejemplos/', $ejemplo->archivo);
            }elseif (Input::get("empresa") == 'yes')
                $this->proyectoRepo->actualizarArchivoEjemplo($ejemplo, '');
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDeleteEjemplo($ejemplo_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('ejemplo', ["ejemplo_id" => $ejemplo_id]);
        $manager->validar();
        $this->proyectoRepo->borrarEjemplo($ejemplo_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /**************************Otros*******************************/

    //Filtro para que solo los trabajadores entren a la funcion
    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

}