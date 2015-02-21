<?php namespace Incubamas\Managers;


class AtendidosManager extends BaseManager
{
    public function getRules(){
        $rules = [
            "nombre_completo"   =>    'required|max:100',
            "correo"            =>    'required|email|max:100',
            "direccion"   	    =>    'required|max:200',
            "telefono"   	    =>    'required|max:20',
            "monto"   	        =>    'required|max:20',
            "programa"   	    =>    'required',
            "correo"   	        =>    'required'
        ];
        return $rules;
    }
}