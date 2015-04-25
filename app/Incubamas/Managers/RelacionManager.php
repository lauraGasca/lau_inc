<?php namespace Incubamas\Managers;

class RelacionManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "servicio_id"       => 'required|exists:servicios,id',
            "casos_exitoso_id"  => 'required|exists:casos_exitosos,id',
        ];
        return $rules;
    }
    
}