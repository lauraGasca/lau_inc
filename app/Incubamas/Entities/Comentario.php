<?php namespace Incubamas\Entities;

class Comentario extends \Eloquent
{
    public function chat()
    {
        return $this->belongsTo('Chat');
    }

}