<?php namespace Incubamas\Managers;

class EjemploManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "pregunta_id"   =>    'required|exists:preguntas,id',
            "texto"         =>    'required|max:1000',
            "archivo"   	=>    '',
        ];
        return $rules;
    }

}