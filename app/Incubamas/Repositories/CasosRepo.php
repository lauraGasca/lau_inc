<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Casos;

class CasosRepo extends BaseRepo{
    
    public function paginar(){
        
        return Casos::paginate(20);
    }
    
    public function getModel(){
        
        return new Casos;
    }
    
}
