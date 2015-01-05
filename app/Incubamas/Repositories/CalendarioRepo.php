<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Calendario;

class CalendarioRepo extends BaseRepo
{
        
    public function getModel()
    {
        
        return new Calendario;
    }
    
    public function newCalendario()
    {
        $calendario = new Calendario();
        return $calendario;
    }
    
    public function existe($user_id)
    {
        $calendario = Calendario::where('user_id','=',$user_id)->first();
        if(count($calendario)<=0){
            return false;
        }else{
            return true;
        }
    }
    
    public function buscar($user_id)
    {
        return Calendario::where('user_id','=',$user_id)->first();
    }
}
