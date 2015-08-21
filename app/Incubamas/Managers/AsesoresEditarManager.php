<?php namespace Incubamas\Managers;

class AsesoresEditarManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "user"                      =>    'required|unique:users,user,'.$this->entity->id,
            'email'	                    =>    'required|email|max:60|unique:users,email,'.$this->entity->id,
            'nombre'	                =>    'required|max:50',
            'apellidos'	                =>    'required|max:50',
            'puesto'	                =>    'required|max:50',
            'type_id'	                =>    'required|exists:tipo_usuario,id',
            'active'	                =>    'required',
            "password"                  =>    'confirmed',
            "password_confirmation"     =>    '',
            'foto'                      =>    'image'
        ];
        return $rules;
    }

}