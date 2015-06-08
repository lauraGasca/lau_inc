<?php namespace Incubamas\Managers;

class EmpresasManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "emprendedor_id"        => 'required|exists:emprendedores,id',
            "logo"                  => 'image',
            "razon_social"          => 'required|max:100|unique:empresas,razon_social',
            "nombre_empresa"        => 'required|max:100',
            "idea_negocio"          => 'required|max:500',
            "necesidad"             => 'max:500',
            "producto_servicio"     => 'required|max:500',
            "regimen_fiscal"        => 'max:50',
            "rfc"                   => 'max:15|unique:empresas,rfc',
            "negocio_casa"          => 'required|size:1',
            "calle"                 => 'required_if:negocio_casa,1|max:50',
            "num_ext"               => 'required_if:negocio_casa,1|max:50',
            "num_int"               => 'max:50',
            "colonia"               => 'required_if:negocio_casa,1|max:50',
            "cp"                    => 'required_if:negocio_casa,1|max:50',
            "estado"                => 'required_if:negocio_casa,1|max:50',
            "municipio"             => 'required_if:negocio_casa,1|max:50',
            "pagina_web"            => 'max:100',
            "giro_actividad"        => 'max:50',
            "sector"                => 'max:50',
            "director"              => 'max:100',
            "asistente"             => 'max:100',
            "financiamiento"        => 'required|size:1',
            "monto_financiamiento"  => 'required_if:financiamiento,2|max:50',
            "costo_proyecto"        => 'required_if:financiamiento,2|max:50',
            "aportacion"            => 'required_if:financiamiento,2|max:50',
        ];
        return $rules;
    }

}