<?php namespace Incubamas\Managers;

class ChatManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "grupo"     =>  'required|size:1',
            "nombre"    =>  'required_if:grupo,1|max:100',
            "foto"	    =>  'required_if:grupo,1|required_if:grupo,3|max:100'
        ];
        
        return $rules;
    }

}