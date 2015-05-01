<?php namespace Incubamas\Managers;

class UserManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            'user'   	=>    'required|max:30|unique:users,user',
            'nombre'	=>    'required|max:30',
            'apellidos'	=>    'required|max:30',
            'email'	    =>    'required|email|max:60|unique:users,email',
            'password'	=>    'required|max:8',
        ];
        return $rules;
    }

}