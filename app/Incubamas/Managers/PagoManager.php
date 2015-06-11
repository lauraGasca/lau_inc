<?php namespace Incubamas\Managers;

class PagoManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "emprendedor_id"    => 'exists:emprendedores,id',
            "solicitud_id"      => 'required|exists:solicitud,id',
            "recibido_by"       => 'required|exists:users,id',
            "monto"             => 'required|max:50',
            "fecha_emision"     => 'required|date_format:d/m/Y',
            "siguiente_pago"    => 'date_format:d/m/Y'
        ];
        return $rules;
    }

}