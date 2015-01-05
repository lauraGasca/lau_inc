<?php namespace Incubamas\Managers;

class HorarioManager extends BaseManager
{
    public function getRules(){
        $rules = [
            "horario_id"    =>  'required|exists:horarios,id',
            "asesor_id"     =>  'required|exists:asesores,id',
            "dia"           =>  'required|min:1|max:1',
        ];
        
        return $rules;
    }
}