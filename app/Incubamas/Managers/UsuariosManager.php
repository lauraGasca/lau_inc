<?php namespace Incubamas\Managers;

class UsuariosManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "user"                      =>    'required|unique:users,user,'.$this->entity->id,
            "password"                  =>    'confirmed',
            "password_confirmation"     =>    '',
        ];
        return $rules;
    }

}