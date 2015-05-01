<?php namespace Incubamas\Managers;

class ProgresoManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            'emprendedor_id'    =>    'required|max:30|exists:emprendedores,id',
            'pregunta_id'	    =>    'required|max:30|exists:preguntas,id',
            'texto'	            =>    'max:500',
            'estado'	        =>    'required',
        ];
        return $rules;
    }

}