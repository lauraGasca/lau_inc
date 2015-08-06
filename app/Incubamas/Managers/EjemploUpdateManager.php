<?php namespace Incubamas\Managers;

class EjemploUpdateManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "texto"         =>    'required|max:1000',
            "archivo"   	=>    '',
        ];
        return $rules;
    }

}