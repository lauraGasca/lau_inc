<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Servicio;

class ServicioRepo extends BaseRepo
{
    
    public function getModel()
    {
        return new Servicio;
    }

    public function all_Order(){

        return Servicio::orderby('nombre')->get();
    }

    public function servicios(){

        return Servicio::orderby('nombre')->lists('nombre', 'id');
    }
    
}
