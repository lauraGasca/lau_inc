<?php namespace Incubamas\Entities;

class Progreso extends \Eloquent
{
    protected $table = 'progresos';

    protected $guarded = ['id','archivo'];

    public function modulo()
    {
        return $this->belongsTo('Incubamas\Entities\Modulo');
    }

    public function pregunta()
    {
        return $this->belongsTo('Incubamas\Entities\Pregunta');
    }
    
}