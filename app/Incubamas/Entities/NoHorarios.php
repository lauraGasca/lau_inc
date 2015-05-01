<?php namespace Incubamas\Entities;

class NoHorarios extends \Eloquent
{
    protected $table = 'horario_asesor';
    protected $guarded = ['id'];

    public function horario()
    {
        return $this->belongsTo('Incubamas\Entities\Horarios');
    }
    
}