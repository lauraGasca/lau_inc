<?php namespace Incubamas\Managers;


class ConvocatoriaManager extends BaseManager
{
    public function getRules()
    {
        $rules = array(
            'nombre'        =>    'required|max:200|unique:convocatorias,nombre',
            'descripcion'   =>    'required|max:1000',
            'imagen'        =>    'required|image',
            'estatus'       =>    'required'
        );

        return $rules;
    }
}