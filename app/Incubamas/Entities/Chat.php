<?php namespace Incubamas\Entities;

class Chat extends \Eloquent {
    
    protected $table = 'chats';
    protected $fillable = array('nombre', 'foto', 'grupo');
    
    public function comentarios()
    {
        return $this->hasMany('Comentario');
    }
    
    public function miembros()
    {
        return $this->hasMany('Miembro');
    }
}