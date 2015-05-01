<?php namespace Incubamas\Managers;

class UserEmpManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            'nombre'	=>    'required|max:30',
            'apellidos'	=>    'required|max:30',
            'foto'	    =>    'image',
            'email'	    =>    'email|max:60|unique:users,email'
        ];
        return $rules;
    }

}