<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Evento;

class EventoRepo extends BaseRepo
{
        
    public function getModel()
    {
        return new Evento;
    }
    
    public function newEvento()
    {
        $evento = new Evento();
        $evento->url = "#";
        return $evento;
    }
    
    public function warning($fecha, $user_id)
    {
        $eventos = Evento::where('user_id','=',$user_id)
        ->whereRaw('(fecha<"'.$fecha.'" or fecha ="'.$fecha.'")')
        ->whereRaw('(fin>"'.$fecha.'" or fin ="'.$fecha.'")')
        ->whereNull('horario')
        ->get();
        //return count($eventos);
        if(count($eventos)>0)
            return true;
        return false;
    }
    
    public function warning_cita($fecha, $id, $user_id)
    {
         $eventos = Evento::whereRaw('(user_id = '.$user_id.' or user_id = '.$id.')')
        ->whereRaw('(fecha<"'.$fecha.'" or fecha ="'.$fecha.'")')
        ->whereRaw('(fin>"'.$fecha.'" or fin ="'.$fecha.'")')
        ->whereNull('horario')
        ->get();
        if(count($eventos)>0)
            return true;
        return false;
    }

    public function existe($evento_id)
    {
        $evento = Evento::find($evento_id);
        if(count($evento)<=0)
            return false;
        else
            return true;
    }

    public function confirmado($evento_id)
    {
        $evento = Evento::find($evento_id);
        if(count($evento)<=0)
            return false;
        else
            if($evento->confirmation == 0)
                return false;
            else
                return true;
    }

    public function evento($evento_id)
    {
        return Evento::find($evento_id);
    }
    
}
