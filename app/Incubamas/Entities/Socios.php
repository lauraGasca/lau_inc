<?php namespace Incubamas\Entities;

class Socios extends \Eloquent
{
    protected $table = 'socios';
    protected $guarded = ['id'];

    public function empresa()
    {
        return $this->belongsTo('Empresa');
    }
    
}