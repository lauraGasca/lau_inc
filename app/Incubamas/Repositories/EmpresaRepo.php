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

}
