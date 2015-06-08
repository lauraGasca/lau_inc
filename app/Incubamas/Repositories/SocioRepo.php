<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Socios;

class SocioRepo extends BaseRepo
{
    public function getModel()
    {
        return new Socios();
    }

    public function newSocio()
    {
        return new Socios();
    }

    public function Socio($id)
    {
        return Socios::find($id);
    }

    public function socios($emprendedor_id)
    {
        return Socios::with('empresa')
            ->where('emprendedor_id', '=', $emprendedor_id)->get();
    }

    public function borrarSocio($id)
    {
        $socio = Socios::find($id);
        $socio->delete();
    }

    public function listar_socios($emprendedor_id)
    {
        return Socios::selectRaw('id, CONCAT(nombre, " ", apellidos) AS nombre_completo')
            ->where('emprendedor_id','=',$emprendedor_id)->lists('nombre_completo','id');
    }

}
