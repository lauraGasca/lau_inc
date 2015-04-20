<?php namespace Incubamas\Managers;


class EmprendedoresEditarManager extends BaseManager
{

    public function getRules()
    {
        $rules = [
            'user_id'  	        =>    'required|exists:users,id',
            'genero'  	        =>    '',
            'fecha_nacimiento'  =>    'date'
        ];

        return $rules;
    }

}