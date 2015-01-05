<?php namespace Incubamas\Entities;

class Emprendedor extends \Eloquent {
    
    protected $table = 'emprendedores';
    
    public function getFullNameAttribute($value)
    {
        return $this->name.' '.$this->apellidos;
    }
    
    public function scopeOrdenar($query)
    {
        return $query->orderBy('name');
    }
    
    public function empresas()
    {
        return $this->hasMany('Empresa');
    }
}