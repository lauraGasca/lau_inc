<?php namespace Incubamas\Managers;

class EventoManager extends BaseManager
{
    public function getRules(){
        $rules = [
            "calendario_id" =>  'required|exists:calendarios,id',
            "user_id"       =>  'required|exists:users,id',
            "titulo"        =>  'required|min:1|max:150',
            "cuerpo"        =>  'max:100',
            "horario"       =>  'exists:horarios,id',
            "clase"         =>  'required|min:10|max:50',
            "fecha"         =>  'required|date',
            "fin"           =>  'required|date',
            "start"         =>  'required|min:13|max:13',
            "end"           =>  'required|min:13|max:13',
            "confirmation"  =>  'required'
        ];
        
        return $rules;
    }
}