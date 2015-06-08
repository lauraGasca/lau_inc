<?php namespace Incubamas\Entities;

class Calendario extends \Eloquent
{
    protected $table = 'calendarios';
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function eventos()
    {
        return $this->hasMany('Evento');
    }

}