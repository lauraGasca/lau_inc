<?php namespace Incubamas\Entities;

class Casos extends \Eloquent
{
    protected $table = 'casos_exitosos';

    public function servicios()
    {
        return $this->belongsToMany('Servicio', 'relaciones', 'casos_exitoso_id', 'servicio_id');
    }

}