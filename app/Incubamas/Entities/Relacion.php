<?php namespace Incubamas\Entities;

class Relacion extends \Eloquent
{
    protected $table = 'relaciones';

    protected $guarded = [];

    public function servicio()
    {
        return $this->belongsTo('Servicio', 'servicio_id', 'id');
    }
    
}