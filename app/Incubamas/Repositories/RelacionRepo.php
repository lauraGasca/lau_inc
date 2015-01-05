<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Relacion;

class RelacionRepo extends BaseRepo{
        
    public function getModel(){
        
        return new Relacion;
    }
    
}
