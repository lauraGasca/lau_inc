<?php

use Incubamas\Repositories\EmpresaRepo;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\EmpresasManager;
use Incubamas\Managers\EmpresasEditarManager;

class EmpresasController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $empresaRepo;

    public function __construct(EmpresaRepo $empresaRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->empresaRepo = $empresaRepo;
    }

    public function getCrear($emprendedor_id)
    {
        $this->_soloAsesores();
        $this->layout->content = View::make('empresas.create', compact('emprendedor_id'));
    }

    public function postCrear()
    {
        $this->_soloAsesores();
        $empresa = $this->empresaRepo->newEmpresa();
        $manager = new EmpresasManager($empresa, Input::all());
        $manager->save();
        if(Input::hasfile('logo'))
        {
            $this->empresaRepo->actualizarLogo($empresa, $empresa->id."." . Input::file('logo')->getClientOriginalExtension());
            Input::file('logo')->move('Orb/images/empresas/', $empresa->logo);
        }
        return Redirect::to('emprendedores/editar/'.Input::get('emprendedor_id'))->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getEditar($empresa_id)
    {
        $this->_soloAsesores();
        $empresa = $this->empresaRepo->empresa($empresa_id);
        $this->layout->content = View::make('empresas.update', compact('empresa'));
    }

    public function postEditar()
    {
        $this->_soloAsesores();
        $empresa = $this->empresaRepo->empresa(Input::get('id'));
        $manager = new EmpresasEditarManager($empresa, Input::all());
        $manager->save();
        if(Input::hasfile('logo'))
        {
            $this->empresaRepo->actualizarLogo($empresa, $empresa->id."." . Input::file('logo')->getClientOriginalExtension());
            Input::file('logo')->move('Orb/images/empresas/', $empresa->logo);
        }
        return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
    }

    public function getDelete($empresa_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('empresa', ['empresa_id'=>$empresa_id]);
        $manager->validar();
        $this->empresaRepo->borrarEmpresa($empresa_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    //Filtro para que solo los trabajadores entren a la funcion
    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

}