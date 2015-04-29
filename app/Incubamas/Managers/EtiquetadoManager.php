<?php namespace Incubamas\Managers;

class EtiquetadoManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "entrada_id"    => 'required|exists:entradas,id',
            "tags_id"       => 'required|exists:tags,id',
        ];
        return $rules;
    }
    
}