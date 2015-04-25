<?php namespace Incubamas\Managers;

class CasosManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre_proyecto"   => 'required|max:100|unique:casos_exitosos,nombre_proyecto',
            "about_proyect"     => 'required',
            "categoria"         => 'required',
            "imagen"            => 'required|image'
        ];
        return $rules;
    }
    
}