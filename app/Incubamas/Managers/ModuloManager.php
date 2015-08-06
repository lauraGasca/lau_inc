<?php namespace Incubamas\Managers;

class ModuloManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre"        =>    'required|max:100',
            "orden"      	=>    'required|numeric',
        ];
        return $rules;
    }

}