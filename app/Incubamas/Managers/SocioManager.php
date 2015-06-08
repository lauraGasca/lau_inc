<?php namespace Incubamas\Managers;

class SocioManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "emprendedor_id"    => 'required|exists:emprendedores,id',
            "empresa_id"        => 'required|exists:empresas,id',
            "nombre"            => 'required|max:50',
            "apellidos"         => 'required|max:50',
            "telefono"          => 'required|max:25',
            "email"             => 'required|max:50',
        ];
        return $rules;
    }

}