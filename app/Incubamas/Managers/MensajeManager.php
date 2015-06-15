<?php namespace Incubamas\Managers;

class MensajeManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "chat_id"       =>  'required|exists:chats,id',
            "archivo"       =>  '',
            "imagen"        =>  'image',
            "cuerpo"        =>  'required_without_all:archivo,imagen,|max:500',
        ];
        return $rules;
    }

}