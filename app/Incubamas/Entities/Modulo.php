<?php namespace Incubamas\Entities;

class Modulo extends \Eloquent
{
    protected $table = 'modulos';

    protected $guarded = ['id'];

    public function preguntas()
    {
        return $this->hasMany('Incubamas\Entities\Pregunta');
    }

    public function ejemplos()
    {
        return $this->hasManyThrough('Incubamas\Entities\Ejemplo', 'Incubamas\Entities\Pregunta');
    }
    
}