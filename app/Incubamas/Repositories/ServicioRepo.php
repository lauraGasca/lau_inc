<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Servicio;

class ServicioRepo extends BaseRepo{
    
    public function all_Order(){
        
        return Servicio::orderby('nombre')->get();
    }
    
    public function getModel(){
        
        return new Servicio;
    }
    
}
