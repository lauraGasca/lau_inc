<?php namespace Incubamas\Entities;

class Ejemplo extends \Eloquent
{
    protected $table = 'ejemplos';

    protected $guarded = ['id', 'archivo'];

    public function pregunta()
    {
        return $this->belongsTo('Incubamas\Entities\Pregunta');
    }
    
}