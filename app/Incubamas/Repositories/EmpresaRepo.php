<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Empresa;

class EmpresaRepo extends BaseRepo
{
    public function getModel()
    {
        return new Empresa();
    }

    public function newEmpresa()
    {
        $empresa = new Empresa();
        return $empresa;
    }

    public function empresa($id)
    {
        return Empresa::find($id);
    }

    public function actualizarLogo($empresa, $logo)
    {
        $this->borrarLogo($empresa->logo);
        $empresa->logo = $logo;
        $empresa->save();
    }

    public function borrarEmpresa($id)
    {
        $empresa = Empresa::find($id);
        $this->borrarLogo($empresa->logo);
        $empresa->delete();
    }

    public function borrarLogo($logo)
    {
        if ($logo <> 'generic-empresa.png')
            \File::delete(public_path() . '/Orb/images/empresas/'.$logo);
    }

    public function empresas($emprendedor_id)
    {
        return Emprendedor::where('id','=',$emprendedor_id)->get();
    }

    public function listar_empresas($emprendedor_id)
    {
        return Empresa::where('emprendedor_id','=',$emprendedor_id)->lists('nombre_empresa','id');
    }

}
