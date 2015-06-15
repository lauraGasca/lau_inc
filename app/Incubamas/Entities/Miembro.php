<?php namespace Incubamas\Entities;

class Miembro extends \Eloquent
{
    protected $table = 'miembros';
    protected $guarded = ['id'];
    
    public function chat()
    {
        return $this->belongsTo('Chat');
    }

    public function usuario()
    {
        return $this->belongsTo('User', 'user_id','id');
    }
    
}