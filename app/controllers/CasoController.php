<?php

use Incubamas\Repositories\CasosRepo;
use Incubamas\Entities\Casos;
use Incubamas\Repositories\ServicioRepo;
use Incubamas\Entities\Servicio;
use Incubamas\Repositories\RelacionRepo;
use Incubamas\Entities\Relacion;
 
class CasoController extends BaseController {

        protected $layout = 'layouts.sistema';
	protected $casosRepo;
	protected $servicioRepo;
	protected $relacionRepo;
        
        public function __construct(CasosRepo $casosRepo, ServicioRepo $servicioRepo, RelacionRepo $relacionRepo)
        {
		$this->casosRepo = $casosRepo;
		$this->servicioRepo = $servicioRepo;
		$this->relacionRepo = $relacionRepo;
		$this->beforeFilter('auth');
		$this->beforeFilter('masters');
		$this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
	    
        }
        
	public function getIndex()
	{
	    $casos = $this->casosRepo->paginar();
	    $servicios_all = $this->servicioRepo->all_Order();
	    $this->layout->content = View::make('casos.index', compact('casos','servicios_all'));
	}
        
        public function postBusqueda()
	{
            $dataUpload = array("buscar"   =>    Input::get("buscar"));
            $rules = array("buscar"    =>    'required|min:1|max:100');
            $messages = array('required'  => 'Por favor, ingresa los parametros de busqueda.');
            $validation = Validator::make(Input::all(), $rules, $messages);   
            if ($validation->fails())
		return Redirect::back()->withErrors($validation)->withInput();
            else{	    
                $casos = Casos::where('nombre_proyecto','LIKE','%'.Input::get("buscar").'%')->paginate(20);
                $servicios_all = Servicio::orderby('nombre')->get();
		$this->layout->content = View::make('casos.index')
		->with('casos',$casos)
		->with('servicios_all',$servicios_all);
            }
	}
        
        public function getCrear()
	{
            $servicios = $this->servicioRepo->listar_todos();
	    $this->layout->content = View::make('casos.create', compact('servicios'));
	}
        
        public function postCrear()
	{ 
		$dataUpload = array(
			"nombre_proyecto"	=>    Input::get("nombre_proyecto"),
			"about_proyect"		=>    Input::get("about_proyect"),
			"categoria"		=>    Input::get("categoria"),
			"servicios[]"		=>    Input::get("servicios[]"),
			"archivo"		=>    Input::get("archivo")
		);
		$rules = array(
			"nombre_proyecto"	=>    'required|min:3|max:100|unique:casos_exitosos,nombre_proyecto',
			"about_proyect"		=>    'required|min:3|max:500',
			"categoria"		=>    'required|min:3|max:100',
			"servicios[]"		=>    'min:3|max:200',
			"archivo"		=>    'required|image'
		);  
		$messages = array('unique'    => 'El nombre de proyecto ya existe');
		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->withErrors($validation)->withInput();
		else{
			$caso = new Casos;
			$caso->nombre_proyecto = Input::get("nombre_proyecto");
			$caso->about_proyect = Input::get("about_proyect");
			$caso->categoria = Input::get("categoria");
			if($caso->save()){
				$caso->imagen = $caso->id.".".Input::file("archivo")->getClientOriginalExtension();
				$caso->save();
				Input::file('archivo')->move('Orb/images/casos_exito',$caso->imagen);
				if(count(Input::get("servicios")) > 0){
					foreach(Input::get("servicios") as $serv){
						$etiqueta = new Relacion;
						$etiqueta->servicio_id = $serv;
						$etiqueta->casos_exitoso_id = $caso->id;
						$etiqueta->save();
					}
				}
				return Redirect::to('casos')->with(array('confirm' => 'Se ha registrado correctamente.'));
			}else
				return Redirect::to('casos')->with(array('confirm' => 'No se ha podido registrar.'));
		}
	}
        
        public function getDelete($caso_id)
	{
		$dataUpload = array("caso_id"	=>    $caso_id);
		$rules = array("caso_id"	=>    'required|exists:casos_exitosos,id');
		$messages = array('exists'  => 'El caso indicado no existe.');
		$validation = Validator::make($dataUpload, $rules, $messages);
		if ($validation->fails())
			return Redirect::to('casos')->with(array('confirm' => 'No se ha podido eliminar.'));
		else{
			$casos = Casos::find($caso_id);
			$imagen = $casos->imagen;
			if($casos->delete()){
				File::delete(public_path().'\\Orb\\images\\casos_exito\\'.$imagen);
				return Redirect::to('casos')->with(array('confirm' => 'Se ha eliminado correctamente.'));
			}else
			    return Redirect::to('casos')->with(array('confirm' => 'No se ha podido eliminar.'));
		}
	}
        
        public function getEditar($caso_id)
	{
		$casos = $this->casosRepo->find($caso_id);
		$servicios = $this->servicioRepo->listar_todos();
		$relaciones = Relacion::where('casos_exitoso_id','=',$caso_id)->lists('servicio_id');
		$this->layout->content = View::make('casos.update', compact('casos','servicios','relaciones'));
	}
        
        public function postEditar()
	{
		$dataUpload = array(
			"caso_id"		=>    Input::get('caso_id'),
			"nombre_proyecto"	=>    Input::get("nombre_proyecto"),
			"about_proyect"		=>    Input::get("about_proyect"),
			"categoria"		=>    Input::get("categoria"),
			"servicios[]"		=>    Input::get("servicios[]"),
			"archivo"		=>    Input::get("archivo")
		);
		$rules = array(
			"caso_id"		=>    'required|exists:casos_exitosos,id',
			"nombre_proyecto"	=>    'required|unique:casos_exitosos,nombre_proyecto,'.Input::get('caso_id'),
			"about_proyect"		=>    'required|min:3|max:500',
			"categoria"		=>    'required|min:3|max:100',
			"servicios[]"		=>    'min:3|max:200',
			"archivo"		=>    'image'
		);  
		$messages = array(   
			'unique'    => 'El nombre de proyecto ya existe',
			'exists'    => 'El caso indicado no existe.'
		);
		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->withErrors($validation)->withInput();
		else{
			$caso_id = Input::get('caso_id');
			$caso = Casos::find($caso_id);
			$caso->nombre_proyecto = Input::get("nombre_proyecto");
			$caso->about_proyect = Input::get("about_proyect");
			$caso->categoria = Input::get("categoria");
			if($caso->save()){
				if(Input::hasFile('archivo')) {
					File::delete(public_path().'\\Orb\\images\\casos_exito\\'.$caso->imagen);
					Input::file('archivo')->move('Orb/images/casos_exito',$caso->imagen);
				}
				$existentes =  Relacion::where('casos_exitoso_id','=',Input::get('caso_id'))->delete();
				if(count(Input::get("servicios")) > 0){
					foreach(Input::get("servicios") as $serv){
						$etiqueta = new Relacion;
						$etiqueta->servicio_id = $serv;
						$etiqueta->casos_exitoso_id = $caso->id;
						$etiqueta->save();
					}
				}
				return Redirect::to('casos/editar/'.Input::get('caso_id'))->with(array('confirm' => 'Se ha actualizado correctamente.'));
			}else
				return Redirect::to('casos/editar/'.Input::get('caso_id'))->with(array('confirm' => 'No se ha podido actualizar.'));
		}
	}
	
	public function postCrearservicio()
	{
		$dataUpload = array("nombre"	=>    Input::get("nombre"));   
		$rules = array("nombre"	=>    'required|unique:servicios,nombre');
		$messages = array('unique'    => 'El nombre de proyecto ya existe');
		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->withErrors($validation)->withInput();
		else{
			$Servicio = new Servicio;
			$Servicio->nombre = Input::get("nombre");
			if($Servicio->save())
				return Redirect::to('casos')->with(array('confirm' => "Se ha agregado correctamente."));
			else
				return Redirect::to('casos')->with(array('confirm' => "Lo sentimos. No se ha podido agregar."));
                }
	}
	
	public function getDeleteservicio($servicio_id)
	{
		$dataUpload = array("servicio_id"	=>    $servicio_id);
		$rules = array("servicio_id"	=>    'required|exists:servicios,id');
		$messages = array('exists'    => 'El caso indicado no existe.');
		$validation = Validator::make($dataUpload, $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
		else{
			$servicio = Servicio::find($servicio_id);
			if($servicio->delete())
				return Redirect::to('casos')->with(array('confirm' => "Se ha eliminado correctamente."));
			else
				return Redirect::to('casos')->with(array('confirm' => "Lo sentimos. No se ha podido eliminar."));
		}
	}
}