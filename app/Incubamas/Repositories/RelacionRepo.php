<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Relacion;
use Incubamas\Entities\Servicio;

class RelacionRepo extends BaseRepo
{
    public function getModel()
    {
        return new Relacion;
    }

    public function newRelacion()
    {
        return new Relacion();
    }

    public function relaciones_caso($caso_id)
    {
        $tags ='';
        $relaciones = Relacion::where('casos_exitoso_id', '=', $caso_id)->get();
        foreach($relaciones as $relacion)
        {
            $servicio = Servicio::find($relacion->servicio_id);
            $tags.= $servicio->nombre.', ';
        }
        return substr($tags, 0, -2);
    }

    public function relacion_caso($caso_id)
    {
        $relaciones = Relacion::where('casos_exitoso_id', '=', $caso_id)->with('servicio')->get();
        return $relaciones;
    }

    public function borrarExistentes($caso_id)
    {
        Relacion::where('casos_exitoso_id', '=', $caso_id)->delete();
    }

    public function borrarRelacion($caso_id, $servicio_id)
    {
        Relacion::where('casos_exitoso_id', '=', $caso_id)->where('servicio_id', '=', $servicio_id)->delete();
    }
    
}
