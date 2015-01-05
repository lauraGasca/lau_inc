<?php namespace Incubamas\Entities;

class NoHorarios extends \Eloquent {
    
    protected $table = 'horario_asesor';
    
    protected $fillable = array('horario_id','asesor_id','dia');
    
}