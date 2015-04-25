<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Servicio;

class ServicioRepo extends BaseRepo
{
    
    public function getModel()
    {
        return new Servicio;
    }

    public function newServicio()
    {
        return new Servicio();
    }

    public function servicios_tags()
    {
        $tags ='';
        $servicios = Servicio::orderby('nombre')->get();
        foreach($servicios as $servicio)
            $tags.= '\''.$servicio->nombre.'\', ';
        return substr($tags, 0, -2);
    }

    public function busca_nombre($nombre)
    {
        return Servicio::whereRaw("nombre LIKE '".$nombre."'")->first();
    }

    public function servicios_todos()
    {

        return Servicio::orderby('nombre')->get();
    }

    public function deleteServicio($servicio_id)
    {
        $servicio = Servicio::find($servicio_id);
        $servicio->delete();
    }
    
}
