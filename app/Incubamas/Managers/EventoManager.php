<?php namespace Incubamas\Managers;

class EventoManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "user_id"       =>  'required|exists:users,id',
            "cuerpo"        =>  'max:100',
            "horario_id"    =>  'required|exists:horarios,id'
        ];
        return $rules;
    }

}