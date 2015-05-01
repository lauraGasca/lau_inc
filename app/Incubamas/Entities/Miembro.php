<?php namespace Incubamas\Entities;

class Miembro extends \Eloquent
{
    protected $table = 'miembros';
    protected $fillable = array('type_id','user_id','chat_id','ultimo_visto');
    
    public function chat()
    {
        return $this->belongsTo('Chat');
    }
    
}