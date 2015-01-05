<?php namespace Incubamas\Entities;

class Asesor extends \Eloquent {
    
    protected $table = 'asesores';
    
    public function getFullNameAttribute($value)
    {
        return $this->nombre.' '.$this->apellidos;
    }
    
    public function scopeOrdenar($query)
    {
        return $query->orderBy('nombre');
    }
}