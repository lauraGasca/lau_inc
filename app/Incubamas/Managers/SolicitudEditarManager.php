<?php namespace Incubamas\Managers;

class SolicitudEditarManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "empresa_id"        => 'exists:empresas,id',
            "servicio_id"       => 'required|exists:servicios_incuba,id',
            "nombre"            => 'required_if:servicio_id,5|max:50',
            "monto"             => 'required|max:50',
            "fecha_limite"      => 'required|date_format:d/m/Y'
        ];
        
        return $rules;
    }

}