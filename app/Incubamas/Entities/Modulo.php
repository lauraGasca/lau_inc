<?php namespace Incubamas\Entities;

class Modulo extends \Eloquent
{
    protected $table = 'modulos';

    public function preguntas()
    {
        return $this->hasMany('Incubamas\Entities\Pregunta');
    }
    
}