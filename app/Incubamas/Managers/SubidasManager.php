<?php namespace Incubamas\Managers;

class SubidasManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "emprendedor_id"    => 'required|exists:emprendedores,id',
            "documento_id"      => 'exists:documentos,id',
            "nombre"            => 'required_if:documento_id,20|max:50',
            "pertenece"         => 'required',
            "empresa_id"        => 'required_if:pertenece,2|exists:empresas,id',
            "socio_id"          => 'required_if:pertenece,3|exists:socios,id',
            "documento"         => 'required'
        ];
        
        return $rules;
    }

}