<?php namespace Incubamas\Managers;


class ConvocatoriaEditarManager extends BaseManager
{
    public function getRules()
    {

        $rules = array(
            'nombre'        =>    'required|max:200|unique:convocatorias,nombre,'.$this->entity->id,
            'descripcion'   =>    'required',
            'imagen'        =>    'image',
            'estatus'       =>    'required'
        );


        return $rules;
    }
}