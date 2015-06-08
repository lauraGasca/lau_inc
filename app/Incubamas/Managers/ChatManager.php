<?php namespace Incubamas\Managers;

class ChatManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre"	        =>  'min:1|max:100',
            "foto"	        =>  'min:1|max:100',
            "grupo"	        =>  'required|min:1|max:1',
            "ultimo_mensaje"    =>  'required|date'
        ];
        
        return $rules;
    }

}