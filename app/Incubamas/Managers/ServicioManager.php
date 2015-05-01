<?php namespace Incubamas\Managers;

class ServicioManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre" => 'required|unique:servicios,nombre'
        ];
        return $rules;
    }

}