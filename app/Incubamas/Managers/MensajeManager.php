<?php namespace Incubamas\Managers;

class MensajeManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "chat_id"       =>  'required|exists:chats,id',
            "archivo"       =>  '',
            "cuerpo"        =>  'required_without_all:archivo|max:500',
        ];
        return $rules;
    }

}