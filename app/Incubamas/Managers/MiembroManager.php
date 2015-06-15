<?php namespace Incubamas\Managers;

class MiembroManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "type_id"       =>  'required_without:user_id|exists:tipo_usuario,id',
            "user_id"       =>  'required_without:type_id|exists:users,id',
            "chat_id"       =>  'required|exists:chats,id'
        ];
        return $rules;
    }

}