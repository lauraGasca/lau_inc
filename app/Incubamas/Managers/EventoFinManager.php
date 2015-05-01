<?php namespace Incubamas\Managers;

class EventoFinManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "user_id"       =>  'required|exists:users,id',
            "titulo"        =>  'required|max:100',
            "cuerpo"        =>  'max:100',
            "clase"         =>  'required|max:100',
            "start"         =>  'required|max:50',
            "end"           =>  'required|max:50'
        ];
        return $rules;
    }
}