<?php namespace Incubamas\Managers;

class ComentarioManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre"        => 'required|min:3|max:100',
            "comentario"    => 'required|min:3',
            'foto'          => 'required',
            'entrada_id'    => 'required',
            'recaptcha_response_field' => 'required|recaptcha'
        ];
        
        return $rules;
    }

}