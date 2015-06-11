<?php namespace Incubamas\Managers;

class SolicitudManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "emprendedor_id"    => 'required|exists:emprendedores,id',
            "empresa_id"        => 'exists:empresas,id',
            "servicio_id"       => 'required|exists:servicios_incuba,id',
            "nombre"            => 'required_if:servicio_id,5|max:50',
            "monto"             => 'required|max:50',
            "fecha_limite"      => 'required|date_format:d/m/Y'
        ];
        
        return $rules;
    }

}