<?php namespace Incubamas\Managers;


class EmprendedorManager extends BaseManager{

    public function getRules()
    {
        $rules = array(
            'user_id'  	        =>    'required|exists:users,id',
            'genero'  	        =>    '',
            'fecha_nacimiento'  =>    'date'
        );

        return $rules;
    }

}