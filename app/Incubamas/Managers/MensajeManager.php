<?php namespace Incubamas\Managers;

class MensajeManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "chat_id"   =>  'required|exists:chats,id',
            "cuerpo"    =>  'min:1|max:500',
            "archivo"   =>  'min:1|max:100',
            "origina"   =>  'min:1|max:100',
        ];
        return $rules;
    }

}