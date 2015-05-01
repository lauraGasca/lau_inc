<?php namespace Incubamas\Managers;

class CalendarioManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "user_id"   	=>    'required|exists:users,id', //fecha de la cita
        ];
        return $rules;
    }
    
}