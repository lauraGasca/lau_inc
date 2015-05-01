<?php namespace Incubamas\Managers;

class AtendidosManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre_completo"   =>    'required|max:100',
            "correo"            =>    'email|max:100',
            "direccion"   	    =>    'max:200',
            "telefono"   	    =>    'required|max:25',
            "monto"   	        =>    'max:20',
            "programa"   	    =>    ''
        ];
        return $rules;
    }

}