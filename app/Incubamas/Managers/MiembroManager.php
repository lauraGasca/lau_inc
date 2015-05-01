<?php namespace Incubamas\Managers;

class MiembroManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "type_id"       =>  'exists:tipo_usuario,id',
            "user_id"       =>  'exists:users,id',
            "chat_id"       =>  'required|exists:chats,id',
            "ultimo_visto"  =>  'date'
        ];
        return $rules;
    }

}