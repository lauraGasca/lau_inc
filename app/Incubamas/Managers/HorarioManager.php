<?php namespace Incubamas\Managers;

class HorarioManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "horario_id"    =>  'required|exists:horarios,id',
            "dia"           =>  'required|max:10',
        ];
        return $rules;
    }

}