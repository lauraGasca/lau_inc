<?php namespace Incubamas\Managers;

class UserEmpEditManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            'nombre'	=>    'required|max:30',
            'apellidos'	=>    'required|max:30',
            'foto'	    =>    'image',
            'email'	    =>    'email|max:60|unique:users,email,'.$this->entity->id
        ];

        return $rules;
    }
}