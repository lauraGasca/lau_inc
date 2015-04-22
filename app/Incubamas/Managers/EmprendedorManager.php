<?php namespace Incubamas\Managers;


class EmprendedorManager extends BaseManager{

    public function getRules()
    {
        $rules = [
            "fecha_nacimiento"  => 'required|date_format:d/m/Y',
            "user_id"           => 'required|exists:users,id'
        ];

        return $rules;
    }

}