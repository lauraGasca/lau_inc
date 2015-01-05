<?php namespace Incubamas\Entities;

class Evento extends \Eloquent {
    
    protected $table = 'eventos';
    
    protected $fillable = array('calendario_id', 'user_id', 'clase', 'titulo', 'cuerpo', 'horario', 'fecha', 'fin', 'start', 'end','confirmation');
    
    public function calendar()
    {
        return $this->belongsTo('Calendario');
    }
    
}