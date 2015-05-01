<?php namespace Incubamas\Entities;

class Evento extends \Eloquent
{
    protected $table = 'eventos';
    protected $guarded = ['id'];

    public function horario()
    {
        return $this->belongsTo('Incubamas\Entities\Horarios');
    }

    public function setStartAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['start'] = strtotime('+6 hour', strtotime(substr($value, 6, 4) . "-" . substr($value, 3, 2) . "-" . substr($value, 0, 2) . " " . substr($value, 10, 6))) * 1000;
        }
    }

    public function setEndAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['end'] = strtotime('+6 hour', strtotime(substr($value, 6, 4) . "-" . substr($value, 3, 2) . "-" . substr($value, 0, 2) . " " . substr($value, 10, 6))) * 1000;
        }
    }

    public function getFechaAttribute()
    {
        return strftime("%d de %B de %Y", ($this->start/1000));
    }

    public function getInicioAttribute()
    {
        return strftime("%d de %B de %Y a las %H:%M hrs", ($this->start/1000));
    }

    public function getFinAttribute()
    {
        return strftime("%d de %B de %Y a las %H:%M hrs", ($this->end/1000));
    }

}