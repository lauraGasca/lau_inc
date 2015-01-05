<?php namespace Incubamas\Entities;

class Mensaje extends \Eloquent {
    
    protected $table = 'mensajes';
    protected $fillable = array("user_id", "chat_id", "cuerpo", "archivo", "origina", "envio");
    
}