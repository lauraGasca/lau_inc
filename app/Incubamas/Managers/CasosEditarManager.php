<?php namespace Incubamas\Managers;

class CasosEditarManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre_proyecto"   => 'required|max:100|unique:casos_exitosos,nombre_proyecto,'.$this->entity->id,
            "about_proyect"     => 'required',
            "categoria"         => 'required',
            "imagen"            => 'image'
        ];
        return $rules;
    }
    
}