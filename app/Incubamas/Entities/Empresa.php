<?php namespace Incubamas\Entities;

class Empresa extends \Eloquent {
    
    protected $table = 'empresas';
    
    public function emprendedor()
    {
        return $this->belongsTo('Emprendedor');
    }
    
}