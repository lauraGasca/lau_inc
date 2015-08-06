<?php namespace Incubamas\Entities;

class Pregunta extends \Eloquent
{
    protected $table = 'preguntas';

    protected $guarded = ['id'];

    public function ejemplos()
    {
        return $this->hasMany('Incubamas\Entities\Ejemplo');
    }

    public function modulo()
    {
        return $this->belongsTo('Incubamas\Entities\Modulo');
    }
}