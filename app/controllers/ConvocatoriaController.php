<?php

use Incubamas\Repositories\ConvocatoriaRepo;
use Incubamas\Managers\ConvocatoriaEditarManager;
use Incubamas\Managers\ConvocatoriaManager;
use Incubamas\Managers\ValidatorManager;

class ConvocatoriaController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $convocatoriaRepo;

    public function __construct(ConvocatoriaRepo $convocatoriaRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('masters');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->convocatoriaRepo = $convocatoriaRepo;
    }

    public function getIndex()
    {
        $convocatorias = $this->convocatoriaRepo->convocatorias();
        $this->layout->content = View::make('convocatorias.index', compact('convocatorias'));
    }

    public function getCrear()
    {
        $this->layout->content = View::make('convocatorias.create');
    }

    public function postCrear()
    {
        $convocatoria = $this->convocatoriaRepo->newConvocatoria();
        $manager = new ConvocatoriaManager($convocatoria, Input::all());
        $manager->save();
        if(Input::hasfile('imagen'))
        {
            $this->convocatoriaRepo->actualizarImagen($convocatoria, $convocatoria->id."." . Input::file('imagen')->getClientOriginalExtension());
            Input::file('imagen')->move('Orb/images/convocatorias/', $convocatoria->imagen);
        }
        return Redirect::to('convocatorias')->with(array('confirm' => 'Se ha creado correctamente'));
    }

    public function getUpdate($id)
    {
        $convocatoria = $this->convocatoriaRepo->convocatoria($id);
        $this->layout->content = View::make('convocatorias.update', compact('convocatoria'));
    }

    public function postUpdate()
    {
        $convocatoria = $this->convocatoriaRepo->convocatoria(Input::get('id'));
        if(count($convocatoria)>0)
        {
            $manager = new ConvocatoriaEditarManager($convocatoria, Input::all());
            $manager->save();
            if(Input::hasfile('imagen'))
            {
                $this->convocatoriaRepo->actualizarImagen($convocatoria, $convocatoria->id."." . Input::file('imagen')->getClientOriginalExtension());
                Input::file('imagen')->move('Orb/images/convocatorias/', $convocatoria->imagen);
            }
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDelete($id)
    {
        $manager = new ValidatorManager('convocatoria', ['convocatoria_id'=>$id]);
        $manager->validar();
        $this->convocatoriaRepo->deleteConvocatoria($id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente'));
    }

}