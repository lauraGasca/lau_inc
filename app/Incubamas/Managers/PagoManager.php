<?php namespace Incubamas\Managers;


class AtendidosManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "emprendedor" => 'exists:emprendedor,id',
            "solicitud" => 'exists:solicitud,id',
            "recibido" => 'exists:asesores,id',
            "monto" => 'required|min:1|max:25',
            "start" => 'required',
            "finish" => 'date',
            "ultimo" => 'min:1'
        ];
        return $rules;
    }
}