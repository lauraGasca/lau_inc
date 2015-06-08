<?php namespace Incubamas\Entities;

class Empresa extends \Eloquent
{
    protected $table = 'empresas';

    protected $guarded = ['id', 'logo'];
    
    public function emprendedor()
    {
        return $this->belongsTo('Emprendedor');
    }
    
}