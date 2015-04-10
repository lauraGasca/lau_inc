<?php namespace Incubamas\Managers;

class FacebookManager extends BaseManager
{
    public function getRules()
    {
        $rules = array(
            'nombre'	    =>    'required|max:30',
            'apellidos'	    =>    'required|max:30',
            'email'	        =>    'required|email|max:60|unique:users,email',
            'facebook_id'	=>    'required|max:50'
        );

        return $rules;
    }
}